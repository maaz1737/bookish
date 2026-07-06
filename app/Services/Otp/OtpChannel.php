<?php

namespace App\Services\Otp;

interface OtpChannel
{
    /** Returns true if the message was accepted by the provider. */
    public function send(string $mobile, string $message): bool;
}
