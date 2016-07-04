<?php


use Gogordos\Framework\Slim\Config;

$config_common = require __DIR__ . '/config_common.php';
$config_env = require __DIR__ . '/config_env.php';

$config = new Config(
    array_merge(
        $config_common['config'],
        $config_env['config']
    )
);

return [
    'settings' => [
        /** Set to false in production */
        'displayErrorDetails' => $config->get('display_error_details'), // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../../../public/templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../../../logs/slim/app.log',
        ],

        'config' => $config
    ],
];
