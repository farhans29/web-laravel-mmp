<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | The paths that should be accessible via CORS. You can use wildcards (*)
    | to match multiple paths or specific endpoints.
    |
    */
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'register',
        'password/*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed HTTP Methods
    |--------------------------------------------------------------------------
    |
    | The methods the client is allowed to use with cross-origin requests.
    |
    */
    'allowed_methods' => [
        'POST',
        'GET',
        'OPTIONS',
        'PUT',
        'PATCH',
        'DELETE',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | The domains that are allowed to access your application. For production,
    | replace the wildcard (*) with your actual domain names.
    |
    */
    'allowed_origins' => array_filter(explode(
        ',',
        env('CORS_ALLOWED_ORIGINS', '*,https://mmp.integrated-os.cloud')
    )),

    /*
    |--------------------------------------------------------------------------
    | Allowed Origin Patterns
    |--------------------------------------------------------------------------
    |
    | You can use regular expressions to match allowed origins.
    |
    */
    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | The headers that are allowed in the request.
    |
    */
    'allowed_headers' => [
        'Content-Type',
        'X-Auth-Token',
        'Origin',
        'Authorization',
        'X-Requested-With',
        'Accept',
        'X-CSRF-TOKEN',
        'X-XSRF-TOKEN',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Headers that are allowed to be exposed to the web browser.
    |
    */
    'exposed_headers' => [
        'Authorization',
        'X-RateLimit-Limit',
        'X-RateLimit-Remaining',
        'X-RateLimit-Reset',
    ],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | Indicates how long (in seconds) the results of a preflight request can be
    | cached in the browser.
    |
    */
    'max_age' => env('CORS_MAX_AGE', 86400), // 24 hours

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | Indicates whether the browser should include credentials (cookies, HTTP
    | authentication, and client-side SSL certificates) in the requests.
    |
    */
    'supports_credentials' => env('CORS_SUPPORTS_CREDENTIALS', true),

    /*
    |--------------------------------------------------------------------------
    | Forced Paths
    |--------------------------------------------------------------------------
    |
    | Paths that should always be processed by the CORS middleware.
    |
    */
    'forced_paths' => [
        'api/*',
    ],
];
