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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    /*
    |--------------------------------------------------------------------------
    | Social Login Services
    |--------------------------------------------------------------------------
    |
    | Configuration for OAuth social login providers
    |
    */

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '885852749625-jdkhk2fsh3ca2kr79jgn7jmnb0qiv7qb.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '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'),
        'redirect' => env('APP_URL', 'http://localhost:8000') . '/social-accounts/callback/youtube',
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('APP_URL', 'http://localhost:8000') . '/social-accounts/callback/facebook',
    ],

    'instagram' => [
        'client_id' => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect' => env('APP_URL', 'http://localhost:8000') . '/social-accounts/callback/instagram',
    ],

    'tiktok' => [
        'client_id' => env('TIKTOK_CLIENT_ID'),
        'client_secret' => env('TIKTOK_CLIENT_SECRET'),
        'redirect' => env('APP_URL', 'http://localhost:8000') . '/social-accounts/callback/tiktok',
    ],

];
