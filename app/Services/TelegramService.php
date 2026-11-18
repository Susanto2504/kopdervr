<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class TelegramService
{
    public function sendMessage(string $message): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            throw new RuntimeException(
                'Token bot atau Telegram chat ID belum dikonfigurasi.'
            );
        }

        $response = Http::timeout(20)
            ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
            ]);

        if (!$response->successful() || !$response->json('ok')) {
            throw new RuntimeException(
                'Telegram gagal mengirim pesan: ' .
                $response->body()
            );
        }
    }

    public function sendPhoto(
        string $photoBinary,
        string $caption
    ): void {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            throw new \RuntimeException(
                'Token atau Chat ID Telegram belum dikonfigurasi.'
            );
        }

        $response = \Illuminate\Support\Facades\Http::attach(
            'photo',
            $photoBinary,
            'qris.png'
        )->post(
            "https://api.telegram.org/bot{$token}/sendPhoto",
            [
                'chat_id' => $chatId,
                'caption' => $caption,
            ]
        );

        if (!$response->successful() || !$response->json('ok')) {
            throw new \RuntimeException(
                'Telegram gagal mengirim gambar QRIS.'
            );
        }
    }
}