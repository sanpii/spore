<?php

use \Symfony\Component\Yaml\Yaml;
use \Pomm\Silex\PommServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['config'] = $app->share(function () {
    if (!is_file(__DIR__ . '/config/parameters.yml')) {
        throw new \RunTimeException('No current configuration file found in config.');
    }

    $config = Yaml::parse(__DIR__ . '/config/parameters.yml');
    $parameters = $config['parameters'];

    $parameters['pomm'] = [
        $parameters['project_name'] => [
            'dsn' => sprintf(
                "pgsql://%s:%s@%s:%s/%s",
                $parameters['database_user'],
                $parameters['database_password'],
                $parameters['database_host'],
                $parameters['database_port'],
                $parameters['database_name']
            ),
        ],
    ];

    return $parameters;
});

$app['debug'] = $app['config']['debug'];

$app->register(new PommServiceProvider(), array(
    'pomm.class_path' => __DIR__ . '/vendor/pomm',
    'pomm.databases' => $app['config']['pomm'],
));

return $app;
