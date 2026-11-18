<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Pesanan;
use App\Services\TelegramService;
use App\Services\XenditService;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PesananUnityController extends Controller
{
    public function store(
        Request $request,
        XenditService $xendit,
        TelegramService $telegram
    ) {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:30',
            'alamat' => 'required|string',
            'produk' => 'required|array|min:1',
            'produk.*.sku' => 'required|string',
            'produk.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            $hasil = DB::transaction(function () use (
                $data,
                $xendit
            ) {
                $customer = Customer::where(
                    'nomor_telepon',
                    $data['nomor_telepon']
                )->first();

                if (!$customer) {
                    $customer = Customer::create([
                        'nama' => $data['nama'],
                        'nomor_telepon' => $data['nomor_telepon'],
                        'alamat' => $data['alamat'],
                    ]);
                }

                $items = [];
                $subtotalPesanan = 0;

                foreach ($data['produk'] as $item) {
                    $barang = Barang::where('sku', $item['sku'])
                        ->lockForUpdate()
                        ->first();

                    if (!$barang) {
                        throw ValidationException::withMessages([
                            'produk' => [
                                'SKU tidak ditemukan: ' . $item['sku'],
                            ],
                        ]);
                    }

                    $jumlah = (int) $item['jumlah'];

                    if ($barang->stok < $jumlah) {
                        throw ValidationException::withMessages([
                            'produk' => [
                                'Stok barang ' . $barang->nama
                                . ' tidak mencukupi.',
                            ],
                        ]);
                    }

                    $harga = (float) $barang->harga_jual;
                    $subtotal = $harga * $jumlah;

                    $items[] = [
                        'nama' => $barang->nama,
                        'sku' => $barang->sku,
                        'harga' => $harga,
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal,
                        'barang' => $barang,
                    ];

                    $subtotalPesanan += $subtotal;
                }

                $biayaPengiriman = 15000;
                $diskon = 0;

                $totalPembayaran = $subtotalPesanan
                    + $biayaPengiriman
                    - $diskon;

                $pesanan = Pesanan::create([
                    'customer_id' => $customer->id,
                    'nomor_invoice' => 'INV-'
                        . now()->format('YmdHis') . '-'
                        . Str::upper(Str::random(5)),
                    'metode_pembayaran' => 'QRIS',
                    'metode_pengiriman' => 'Kurir Toko',
                    'status_pesanan' => 'pending',
                    'subtotal' => $subtotalPesanan,
                    'biaya_pengiriman' => $biayaPengiriman,
                    'diskon' => $diskon,
                    'total_pembayaran' => $totalPembayaran,
                    'nama_penerima' => $data['nama'],
                    'nomor_telepon_penerima' =>
                        $data['nomor_telepon'],
                    'alamat_pengiriman' => $data['alamat'],
                    'tanggal_pesanan' => now(),
                ]);

                foreach ($items as $item) {
                    $barang = $item['barang'];

                    $pesanan->detailPesanan()->create([
                        'barang_id' => $barang->id,
                        'nama_barang' => $barang->nama,
                        'sku' => $barang->sku,
                        'harga' => $item['harga'],
                        'jumlah' => $item['jumlah'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    $barang->decrement('stok', $item['jumlah']);
                }

                // Buat QRIS sesuai total pesanan.
                $qr = $xendit->createDynamicQr(
                    (int) round($totalPembayaran),
                    $pesanan->nomor_invoice
                );

                // Simpan ID QRIS dan status pembayaran.
                $pesanan->update([
                    'xendit_qr_id' => $qr['id'],
                    'status_pembayaran' => 'PENDING',
                ]);

                // Kembalikan data yang diperlukan di luar transaksi.
                return [
                    'id' => $pesanan->id,
                    'nomor_invoice' => $pesanan->nomor_invoice,
                    'subtotal' => $pesanan->subtotal,
                    'biaya_pengiriman' => $pesanan->biaya_pengiriman,
                    'diskon' => $pesanan->diskon,
                    'total_pembayaran' => $pesanan->total_pembayaran,
                    'metode_pembayaran' => $pesanan->metode_pembayaran,
                    'metode_pengiriman' => $pesanan->metode_pengiriman,
                    'items' => array_map(function ($item) {
                        return [
                            'nama' => $item['nama'],
                            'sku' => $item['sku'],
                            'harga' => $item['harga'],
                            'jumlah' => $item['jumlah'],
                            'subtotal' => $item['subtotal'],
                        ];
                    }, $items),
                    'qr' => $qr,
                ];
            });
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Pesanan atau QRIS gagal diproses. Periksa log Laravel.',
            ], 502);
        }

        $qr = $hasil['qr'];
        $items = $hasil['items'];

        unset($hasil['qr'], $hasil['items']);

        $telegramSent = false;

        try {
            // Ubah data QRIS menjadi gambar PNG.
            $qrCode = new QrCode(
                data: $qr['qr_string'],
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Medium,
                size: 500,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255),
            );

            $writer = new PngWriter();
            $qrImage = $writer->write($qrCode)->getString();

            // Susun daftar barang untuk caption Telegram.
            $daftarBarang = "📦 DAFTAR PESANAN\n";

            foreach ($items as $item) {
                $daftarBarang .= '- '
                    . $item['nama']
                    . ' (SKU: ' . $item['sku'] . ')'
                    . ' x ' . $item['jumlah']
                    . ' = Rp' . number_format(
                        (float) $item['subtotal'],
                        0,
                        ',',
                        '.'
                    )
                    . "\n";
            }

            $caption = "🛍️ PEMBAYARAN KOPDES\n"
                . "Invoice: " . $hasil['nomor_invoice'] . "\n\n"
                . $daftarBarang . "\n"
                . "Subtotal: Rp" . number_format(
                    (float) $hasil['subtotal'],
                    0,
                    ',',
                    '.'
                ) . "\n"
                . "Ongkir: Rp" . number_format(
                    (float) $hasil['biaya_pengiriman'],
                    0,
                    ',',
                    '.'
                ) . "\n"
                . "Diskon: Rp" . number_format(
                    (float) $hasil['diskon'],
                    0,
                    ',',
                    '.'
                ) . "\n"
                . "💰 TOTAL: Rp" . number_format(
                    (float) $hasil['total_pembayaran'],
                    0,
                    ',',
                    '.'
                ) . "\n\n"
                . "🆔 ID QRIS: " . $qr['id'] . "\n"
                . "Status QRIS: " . ($qr['status'] ?? 'ACTIVE') . "\n"
                . "Status Pembayaran: PENDING\n\n"
                . "Silakan pindai QRIS untuk melakukan pembayaran.";

            // Gambar QRIS tetap dikirim sebagai foto.
            $telegram->sendPhoto($qrImage, $caption);
            $telegramSent = true;
        } catch (\Throwable $e) {
            Log::error('Pengiriman QRIS ke Telegram gagal.', [
                'invoice' => $hasil['nomor_invoice'],
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $telegramSent
                ? 'Pesanan tersimpan. QRIS dikirim ke Telegram admin.'
                : 'Pesanan dan QRIS berhasil dibuat, tetapi pengiriman Telegram gagal.',
            'data' => array_merge($hasil, [
                'qr_id' => $qr['id'],
                'qr_status' => $qr['status'],
                'telegram_sent' => $telegramSent,
            ]),
        ], 201);
    }
}
