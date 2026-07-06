<?php

namespace App\Services\Otp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Fallback OTP channel — generic SMS gateway.
 * Swap the endpoint/payload for your provider (e.g. Twilio, Telenor, Jazz).
 */
class SmsChannel implements OtpChannel
{
    public function send(string $mobile, string $message): bool
    {
        $endpoint = config('services.sms.endpoint');
        $apiKey   = config('services.sms.api_key');
        $sender   = config('services.sms.sender');

        if (! $endpoint || ! $apiKey) {
            Log::warning('SMS OTP channel not configured.');
            return false;
        }

        try {
            $response = Http::asForm()->post($endpoint, [
                'api_key' => $apiKey,
                'to'      => $mobile,
                'from'    => $sender,
                'message' => $message,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('SMS OTP send failed: '.$e->getMessage());
            return false;
        }
    }
}
