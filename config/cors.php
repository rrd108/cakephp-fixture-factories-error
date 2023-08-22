<?php
return [
    'Cors' => [
        'AllowOrigin' => ['http://localhost:5173'],
        'AllowMethods' => ['DELETE', 'GET', 'PATCH', 'POST', 'OPTIONS'],
        'AllowHeaders' => ['Token', 'Content-Type'],
        'MaxAge' => 300,
    ]
];
