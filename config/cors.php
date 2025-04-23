<?php

return [

    'paths' => ['api/*'], // atau ['*'] jika ingin semua route diizinkan

    'allowed_methods' => ['*'], // izinkan semua method (GET, POST, PUT, dsb)

    'allowed_origins' => ['http://localhost:3000'], // <== Tambahkan origin frontend kamu

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];

