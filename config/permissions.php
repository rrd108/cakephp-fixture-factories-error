<?php
return [
    'Permissions' => [
        'noAuth' => [
            'Users' => ['register', 'passwordReminder'],
        ],
        'admin' => '*',       // `access` is ignored, can *read* and *write* all resources
        'user' => [        // can *read* and *write* own resources
            'Bookings' => ['add', 'edit', 'index', 'my', 'next'],
            'Cars' => ['search'],
            'Users' => ['edit', 'login'],
        ],
    ]
];
