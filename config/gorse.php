<?php

return [
    'endpoint' => env('GORSE_ENDPOINT'),
    'api_key' => env('GORSE_API_KEY'),
    'options' => [
        'connect_timeout' => env('GORSE_CONNECT_TIMEOUT', 10),
        'timeout' => env('GORSE_TIMEOUT', 30)
    ]
];