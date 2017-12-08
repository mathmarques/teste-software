<?php
return [
    'settings' => [
        // Slim settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,

        'phpunit' => [
            'phpunit' => __DIR__ . '/../vendor/bin/phpunit',
            'unitFolder' => __DIR__ . '/../cache/phpunit/'
        ],

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'smarty' => [
                'cacheDir' => __DIR__ . '/../cache/smarty/cache',
                'compileDir' => __DIR__ . '/../cache/smarty/compile',
            ],
        ],
    ],
];
