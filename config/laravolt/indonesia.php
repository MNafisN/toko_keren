<?php

return [
    'table_prefix' => 'wilayah_',
    'route' => [
        'enabled' => false,
        'middleware' => ['api', 'auth'],
        'prefix' => 'indonesia',
    ],
    'view' => [
        'layout' => 'ui::layouts.app',
    ],
    'menu' => [
        'enabled' => false,
    ],
];
