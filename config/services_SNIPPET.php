<?php
/*
 |--------------------------------------------------------------------------
 | ADD THESE KEYS to your existing config/services.php inside the return array
 |--------------------------------------------------------------------------
 | (Do NOT replace the whole file — just merge these entries.)
 */

return [

    // ... your existing services (mailgun, postmark, ses, etc.) ...

    'whatsapp' => [
        'phone_id' => env('WHATSAPP_PHONE_ID'),
        'token'    => env('WHATSAPP_TOKEN'),
    ],

    'sms' => [
        'endpoint' => env('SMS_GATEWAY_ENDPOINT'),
        'api_key'  => env('SMS_GATEWAY_API_KEY'),
        'sender'   => env('SMS_GATEWAY_SENDER', 'Bookish'),
    ],

];
