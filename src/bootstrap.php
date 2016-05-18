<?php
declare(strict_types = 1);

use \Silex\Provider;
use \Symfony\Component\Yaml\Yaml;
use \PommProject\Silex\ {
    ServiceProvider\PommServiceProvider,
    ProfilerServiceProvider\PommProfilerServiceProvider
};

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Silex\Application();

$app['config'] = function () {
    if (!is_file(__DIR__ . '/config/parameters.yml')) {
        throw new \RunTimeException('No current configuration file found in config.');
    }

    $config = Yaml::parse(__DIR__ . '/config/parameters.yml');
    $parameters = $config['parameters'];

    $config['pomm'] = [
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
    unset($config['parameters']);

    return $config;
};

$app['debug'] = $app['config']['debug'];

$app->register(new Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/views',
]);

$app->register(new PommServiceProvider(), [
    'pomm.configuration' => $app['config']['pomm'],
]);

if (class_exists(Provider\WebProfilerServiceProvider::class)) {
    $app->register(new Provider\ServiceControllerServiceProvider);
    $app->register(new Provider\HttpFragmentServiceProvider);

    $profiler = new Provider\WebProfilerServiceProvider();
    $app->register($profiler, [
        'profiler.cache_dir' => __DIR__ . '/../cache/profiler',
    ]);
    $app->mount('/_profiler', $profiler);

    $app->register(new PommProfilerServiceProvider);
}

return $app;
