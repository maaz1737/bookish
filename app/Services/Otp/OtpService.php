<?php

namespace App\Services\Otp;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Jobs\SendTwilioSms;


/**
 * Passwordless OTP login (Section 5.2).
 * Primary channel WhatsApp; falls back to SMS if WhatsApp delivery fails.
 */
class OtpService
{
    public function __construct(
        private WhatsAppChannel $whatsapp,
        private SmsChannel $sms,
    ) {}

    // public function sendWhatsappNotification($otp,  $recipient)
    // {
    //     $twilio_whatsapp_number = getenv("TWILIO_PHONE_NUMBER");
    //     $account_sid = getenv("TWILIO_ACCOUNT_SID");
    //     $auth_token = getenv("TWILIO_AUTH_TOKEN");

    //     $client = new Client($account_sid, $auth_token);
    //     $message = "Your otp to login to meezan account is {$otp}.";
    //     return $client->messages->create("whatsapp:$recipient", array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    // }

    public function request(string $mobile): array
    {
        $code = (string) random_int(100000, 999999);
        $message = "Your Bookish verification code is {$code}. It expires in 5 minutes.";

        // Primary: WhatsApp. Fallback: SMS.
        $channel = 'whatsapp';
        $sent = $this->whatsapp->send($mobile, $message);

        // $this->sendWhatsappNotification($code, $mobile);


        if (! $sent) {
            $channel = 'sms';
            $sent = $this->sms->send($mobile, $message);
        }

        Otp::create([
            'mobile'     => $mobile,
            'code_hash'  => Hash::make($code),
            'channel'    => $channel,
            'expires_at' => now()->addMinutes(5),
        ]);

        if (app()->environment('production')) {
            SendTwilioSms::dispatch($mobile, 'Your production verification code is' . $code);
        }

        // In local/testing the code is returned so it can be auto-filled.
        return [
            'sent'    => $sent,
            'channel' => $channel,
            'debug_code' => app()->environment('local', 'testing') ? $code : null,
        ];
    }

    public function verify(string $mobile, string $code): ?User
    {
        $otp = Otp::where('mobile', $mobile)
            ->whereNull('consumed_at')
            ->latest()
            ->first();

        if (! $otp || $otp->isExpired() || $otp->attempts >= 5) {
            return null;
        }

        $otp->increment('attempts');

        if (! Hash::check($code, $otp->code_hash)) {
            return null;
        }

        $otp->update(['consumed_at' => now()]);

        return User::firstOrCreate(
            ['mobile' => $mobile],
            ['name' => 'Customer ' . Str::substr($mobile, -4), 'role' => 'customer', 'mobile_verified_at' => now()]
        );
    }
}
