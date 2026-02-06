<?php

return [
    'active' => env('ELASTIC_APM_ENABLED', true),

    'server_url' => env('ELASTIC_APM_SERVER_URL', 'http://apm-server:8200'),

    'service_name' => env('ELASTIC_APM_SERVICE_NAME', 'Laravel-API'),
    
    'environment' => env('APP_ENV', 'local'),

    'transactions' => [
        'ignorePatterns' => [], 
        'queryParams' => [],
    ],
    
    'httpClient' => [
        'verify' => false,
    ],
];