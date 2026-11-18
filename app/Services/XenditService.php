<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class XenditService
{
    public function createDynamicQr(
        int $amount,
        string $referenceId
    ): array {
        if ($amount < 1 || $amount > 10000000) {
            throw new RuntimeException(
                'Nominal QRIS harus antara Rp1 dan Rp10.000.000.'
            );
        }

        $secretKey = config('services.xendit.secret_key');

        if (!$secretKey) {
            throw new RuntimeException(
                'XENDIT_SECRET_KEY belum dikonfigurasi.'
            );
        }

        $response = Http::withBasicAuth($secretKey, '')
            ->withHeaders([
                'api-version' => config(
                    'services.xendit.api_version',
                    '2022-07-31'
                ),
            ])
            ->timeout(30)
            ->post('https://api.xendit.co/qr_codes', [
                'reference_id' => $referenceId,
                'type' => 'DYNAMIC',
                'currency' => 'IDR',
                'amount' => $amount,
            ]);

        if (!$response->successful()) {
            report(new RuntimeException(
                'Xendit API error: HTTP ' .
                $response->status() . ' - ' .
                $response->body()
            ));

            throw new RuntimeException(
                'Xendit gagal membuat QRIS. Periksa log Laravel.'
            );
        }

        $data = $response->json();

        if (empty($data['id']) || empty($data['qr_string'])) {
            throw new RuntimeException(
                'Respons Xendit tidak memuat ID atau data QRIS.'
            );
        }

        return $data;
    }

    public function simulatePayment(string $qrId): array
    {
        $secretKey = config('services.xendit.secret_key');

        if (!$secretKey) {
            throw new RuntimeException(
                'XENDIT_SECRET_KEY belum dikonfigurasi.'
            );
        }

        $response = Http::withBasicAuth($secretKey, '')
            ->withHeaders([
                'api-version' => '2022-07-31',
            ])
            ->timeout(30)
            ->post(
                "https://api.xendit.co/qr_codes/{$qrId}/payments/simulate"
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'Simulasi gagal: HTTP ' .
                $response->status() . ' - ' .
                $response->body()
            );
        }

        return $response->json() ?? [];
    }
}
