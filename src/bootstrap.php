<?php

use \Symfony\Component\Yaml\Yaml;
use \Silex\Provider\TwigServiceProvider;
use \Silex\Provider\WebProfilerServiceProvider;
use \Silex\Provider\UrlGeneratorServiceProvider;
use \Silex\Provider\HttpFragmentServiceProvider;
use \Silex\Provider\ServiceControllerServiceProvider;
use \PommProject\Silex\ServiceProvider\PommServiceProvider;
use \PommProject\Silex\ProfilerServiceProvider\PommProfilerServiceProvider;

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

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app->register(new PommServiceProvider(), array(
    'pomm.configuration' => $app['config']['pomm'],
));

if (class_exists('\Silex\Provider\WebProfilerServiceProvider')) {
    $app->register(new UrlGeneratorServiceProvider);
    $app->register(new ServiceControllerServiceProvider);
    $app->register(new HttpFragmentServiceProvider);

    $profiler = new WebProfilerServiceProvider();
    $app->register($profiler, array(
        'profiler.cache_dir' => __DIR__ . '/../cache/profiler',
    ));
    $app->mount('/_profiler', $profiler);

    $app->register(new PommProfilerServiceProvider);
}

return $app;
