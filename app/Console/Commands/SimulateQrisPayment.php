<?php
namespace App\Console\Commands;

use App\Models\Pesanan;
use App\Services\XenditService;
use Illuminate\Console\Command;
use RuntimeException;

class SimulateQrisPayment extends Command
{
    protected $signature = 'app:simulate-qris-payment {invoice}';

    protected $description = 'Simulasikan pembayaran QRIS Xendit';

    public function handle(XenditService $xendit): int
    {
        $invoice = $this->argument('invoice');

        $pesanan = Pesanan::where('nomor_invoice', $invoice)->first();

        if (!$pesanan) {
            $this->error('Pesanan tidak ditemukan.');
            return self::FAILURE;
        }

        if (!$pesanan->xendit_qr_id) {
            $this->error('ID QRIS pesanan tidak ditemukan.');
            return self::FAILURE;
        }

        if ($pesanan->status_pembayaran === 'SUCCEEDED') {
            $this->info('Pesanan ini sudah dibayar.');
            return self::SUCCESS;
        }

        if ($pesanan->status_pembayaran !== 'PENDING') {
            $this->error('Status pembayaran bukan PENDING.');
            return self::FAILURE;
        }

        try {
            $result = $xendit->simulatePayment(
                $pesanan->xendit_qr_id
            );

            $this->info('Permintaan simulasi berhasil dikirim ke Xendit.');
            $this->line(json_encode(
                $result,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            ));

            $this->comment(
                'Periksa status pesanan di database setelah callback diterima.'
            );

            return self::SUCCESS;
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}
