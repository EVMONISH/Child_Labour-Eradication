<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'affordmed' => [
        'email' => env('LOG_EMAIL'),
        'name' => env('LOG_NAME'),
        'roll_no' => env('LOG_ROLL_NO'),
        'access_code' => env('LOG_ACCESS_CODE'),
        'client_id' => env('LOG_CLIENT_ID'),
        'client_secret' => env('LOG_CLIENT_SECRET'),
        'api_base' => env('NOTIFICATION_API_BASE'),
        'access_token' => env('LOG_ACCESS_TOKEN'),
    ],

];
