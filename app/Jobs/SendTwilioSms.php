<?php

namespace App\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class SendTwilioSms implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public function __construct(
        protected string $to,
        protected string $message
    ) {}

    public function handle(): void
    {
        $config = config('services.twilio');

        $client = new Client($config['key'], $config['secret'], $config['sid']);

        try {
            $client->messages->create(
                $this->to, // Recipient phone number in E.164 format (e.g., +1234567890)
                [
                    // Using service_sid automatically handles optimal routing/shortcodes
                    'from' => $config['service_sid'],
                    'body' => $this->message,
                ]
            );
        } catch (Exception $e) {
            // Log specifically without exposing sensitive system properties 
            Log::error('Twilio Production Error: ' . $e->getMessage(), [
                'to' => $this->to
            ]);

            // Fail the job so Laravel knows to queue it for a retry
            throw $e;
        }
    }
}
