<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default social profile URLs
    |--------------------------------------------------------------------------
    |
    | Used as fallbacks when footer social links are empty or still set to "#".
    | Override via .env or Admin → Footer.
    |
    */
    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK', 'https://facebook.com/minimarvelsbyaf'),
        'instagram' => env('SOCIAL_INSTAGRAM', 'https://www.instagram.com/minimarvelsbyaf/'),
        'youtube' => env('SOCIAL_YOUTUBE', 'https://www.youtube.com/@MiniMarvels-x2i'),
        'twitter' => env('SOCIAL_TWITTER', ''),
        'linkedin' => env('SOCIAL_LINKEDIN', ''),
        'tiktok' => env('SOCIAL_TIKTOK', ''),
    ],
];
