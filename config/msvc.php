<?php

return [
    'root_prefix' => env('ROOT_PREFIX', ''),
    'name' => env('MICROSERVICE_NAME', 'msvc'),
    'max_requests_per_minute' => env('MAX_REQUESTS_PER_MINUTE', 128),
];
