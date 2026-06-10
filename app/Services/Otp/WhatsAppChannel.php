<?php

namespace App\Services\Otp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Primary OTP channel — WhatsApp Cloud API.
 * Configure credentials in config/services.php (whatsapp.*).
 */
class WhatsAppChannel implements OtpChannel
{
    public function send(string $mobile, string $message): bool
    {
        $phoneId = config('services.whatsapp.phone_id');
        $token   = config('services.whatsapp.token');

        if (! $phoneId || ! $token) {
            Log::warning('WhatsApp OTP channel not configured.');
            return false;
        }

        try {
            $response = Http::withToken($token)
                ->post("https://graph.facebook.com/v19.0/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to'                => $this->normalize($mobile),
                    'type'              => 'text',
                    'text'              => ['body' => $message],
                ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('WhatsApp OTP send failed: '.$e->getMessage());
            return false;
        }
    }

    private function normalize(string $mobile): string
    {
        // Pakistan numbers: 03001234567 -> 923001234567
        $digits = preg_replace('/\D/', '', $mobile);
        if (str_starts_with($digits, '0')) {
            $digits = '92'.substr($digits, 1);
        }
        return $digits;
    }
}
