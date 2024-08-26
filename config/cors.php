<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', '*'], // 添加 '*' 以覆盖所有路由
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];