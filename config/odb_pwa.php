<?php

return [
    'name'             => env('APP_NAME', 'PWA App'),
    'short_name'       => env('APP_SHORT_NAME', 'PWA App'),
    'base_domain'			        => 'localhost',
    'prefix'                => '/pwa',
    'icons_path'			         => storage_path('/vendor/odinbi/pwa/src/resources/icons'),
    'scope'					            => '.',
    'middleware' => env('PWA_MIDDLEWARE', 'web'),
    'database' => [
    	'driver' => 'mysql'
    ]
];
