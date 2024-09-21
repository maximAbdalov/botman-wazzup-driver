<?php

return [
    'url' => env('WHATSAPP_PARTNER', 'https://api.wazzup24.com/v3'),
    'token' => env('WHATSAPP_TOKEN'),
    'chanel_id' => env('WHATSAPP_CHANEL_ID', ''),
    'throw_http_exceptions' => true,
];
