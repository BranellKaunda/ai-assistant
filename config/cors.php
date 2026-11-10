<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | The portfolio website lives on another domain, so only the origins listed
    | in CORS_ALLOWED_ORIGINS (comma separated) may call the assistant API.
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['POST'],

    'allowed_origins' => array_filter(explode(',', env('CORS_ALLOWED_ORIGINS', ''))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'Accept'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
