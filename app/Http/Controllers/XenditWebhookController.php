<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class XenditWebhookController extends Controller
{
    public function handle(
        Request $request,
        TelegramService $telegram
    ) {
        // 1. Verifikasi callback token Xendit
        $callbackToken = config('services.xendit.callback_token');
        $receivedToken = $request->header('x-callback-token');

        if (!$callbackToken || !$receivedToken || !hash_equals($callbackToken, $receivedToken)) {
            Log::warning('Webhook Xendit ditolak: token tidak valid.');
            return response()->json(['success' => false, 'message' => 'Callback token tidak valid.'], 401);
        }

        // 2. Ambil payload webhook
        $payload = $request->all();
        Log::info('XENDIT WEBHOOK DITERIMA', ['event' => $payload['event'] ?? null, 'payload' => $payload]);

        // 3. Pastikan event merupakan pembayaran QRIS
        if (($payload['event'] ?? null) !== 'qr.payment') {
            return response()->json(['success' => true, 'message' => 'Event diabaikan.'], 200);
        }

        // 4. Ambil informasi pembayaran
        // Mendukung struktur payload dengan data dan tanpa data
        $data = $payload['data'] ?? $payload;
        $qrCode = $data['qr_code'] ?? [];
        $qrId = $qrCode['id'] ?? $data['qr_id'] ?? null;
        $paymentId = $data['id'] ?? $data['payment_id'] ?? null;
        $status = $data['status'] ?? null;
        $amount = $data['amount'] ?? null;
        $created = $data['created'] ?? null;

        // 5. Validasi kelengkapan data
        if (!$qrId || !$paymentId || $amount === null || !$status) {
            Log::warning('Payload webhook QRIS tidak lengkap.', [
                'qr_id' => $qrId, 
                'payment_id' => $paymentId, 
                'status' => $status, 
                'amount' => $amount
            ]);
            return response()->json(['success' => false, 'message' => 'Data pembayaran tidak lengkap.'], 400);
        }

        // 6. Cari pesanan berdasarkan ID QRIS
        $pesanan = Pesanan::where('xendit_qr_id', $qrId)->first();

        if (!$pesanan) {
            Log::warning('QRIS tidak ditemukan di database.', [
                'qr_id' => $qrId, 
                'payment_id' => $paymentId
            ]);
            return response()->json(['success' => false, 'message' => 'QRIS tidak terhubung dengan pesanan.'], 200);
        }

        // 7. Validasi nominal pembayaran
        if (round((float) $amount, 2) !== round((float) $pesanan->total_pembayaran, 2)) {
            Log::error('Nominal callback QRIS tidak cocok.', [
                'invoice' => $pesanan->nomor_invoice,
                'amount_callback' => $amount,
                'amount_pesanan' => $pesanan->total_pembayaran,
            ]);

            return response()->json(['success' => false, 'message' => 'Nominal pembayaran tidak cocok.'], 422);
        }

        // 8. Pastikan pembayaran berhasil
        if (!in_array($status, ['COMPLETED', 'SUCCEEDED'], true)) {
            Log::info('Status pembayaran belum berhasil.', [
                'invoice' => $pesanan->nomor_invoice,
                'status' => $status,
            ]);

            return response()->json(['success' => true, 'message' => 'Pembayaran belum berhasil.'], 200);
        }

        // 9. Konversi waktu pembayaran ke format MySQL
        try {
            $waktuDibayar = !empty($created) ? Carbon::parse($created)->timezone(config('app.timezone'))->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s');

        } catch (\Throwable $e) {
            Log::error('Format tanggal pembayaran tidak valid.', [
                'created' => $created,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['success' => false, 'message' => 'Format tanggal pembayaran tidak valid.'], 422);
        }

        // 10. Update status pembayaran hanya satu kali
        $updated = Pesanan::whereKey($pesanan->getKey())->where(function ($query) {
            $query->whereNull('status_pembayaran')->orWhere('status_pembayaran', '!=', 'LUNAS');
        })->update([
            'status_pembayaran' => 'LUNAS',
            'xendit_payment_id' => $paymentId,
            'dibayar_pada' => $waktuDibayar,
            'status_pesanan' => 'confirmed',
            'dikonfirmasi_pada' => now(),
        ]);

        // 11. Periksa apakah pesanan sudah pernah dibayar
        if ($updated === 0) {
            Log::info('Webhook diabaikan: pesanan sudah LUNAS.', [
                'invoice' => $pesanan->nomor_invoice,
                'payment_id' => $paymentId,
            ]);

            return response()->json(['success' => true, 'message' => 'Pesanan sudah berstatus LUNAS.'], 200);
        }

        // 12. Ambil data pesanan terbaru
        $pesanan->refresh();

        Log::info('STATUS PESANAN BERHASIL DIPERBARUI.', [
            'invoice' => $pesanan->nomor_invoice,
            'qr_id' => $qrId,
            'payment_id' => $paymentId,
            'status_pembayaran' => $pesanan->status_pembayaran,
            'dibayar_pada' => $pesanan->dibayar_pada,
        ]);

        // 13. Susun notifikasi Telegram
        $nominal = 'Rp' . number_format((float) $pesanan->total_pembayaran, 0, ',', '.');

        // Ambil nama pelanggan dari data pesanan
        $namaPelanggan = $pesanan->nama_penerima;

        $pesan =
            "🎉 PEMBAYARAN BERHASIL!\n\n" .
            "Halo, {$namaPelanggan}! 💗\n\n" .
            "Pembayaran pesanan Anda telah berhasil kami terima.\n\n" .
            "📋 DETAIL PEMBAYARAN\n" .
            "Invoice: {$pesanan->nomor_invoice}\n" .
            "Total Pembayaran: {$nominal}\n" .
            "Status Pembayaran: LUNAS ✅\n\n" .
            "📦 PESANAN SEDANG DIPROSES\n\n" .
            "Pesanan Anda sedang diproses untuk dikirim. " .
            "Mohon menunggu informasi pengiriman selanjutnya.\n\n" .
            "Terima kasih telah berbelanja bersama kami! 💗";

        // 14. Kirim notifikasi Telegram
        try {
            $telegram->sendMessage($pesan);

            Log::info(
                'Notifikasi pembayaran berhasil dikirim ke Telegram.',
                [
                    'invoice' => $pesanan->nomor_invoice,
                    'nama_pelanggan' => $namaPelanggan,
                    'payment_id' => $paymentId,
                ]
            );

        } catch (\Throwable $e) {
            Log::error(
                'Gagal mengirim notifikasi pembayaran ke Telegram.',
                [
                    'invoice' => $pesanan->nomor_invoice,
                    'error' => $e->getMessage(),
                ]
            );
        }

        // 15. Respons berhasil ke Xendit
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diproses.',
            'invoice' => $pesanan->nomor_invoice,
            'nama_pelanggan' => $namaPelanggan,
            'status_pembayaran' => $pesanan->status_pembayaran,
        ], 200);
    }
}
