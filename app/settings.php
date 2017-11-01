<?php
return [
    'settings' => [
        // Slim settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,

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
