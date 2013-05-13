<?php

use \Pomm\Silex\PommServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

if (!is_file(__DIR__ . '/config/current.php')) {
    throw new \RunTimeException('No current configuration file found in config.');
}

$app = new Silex\Application();

$app['config'] = require __DIR__ . '/config/current.php';

$app['debug'] = $app['config']['debug'];

$app->register(new PommServiceProvider(), array(
    'pomm.class_path' => __DIR__ . '/vendor/pomm',
    'pomm.databases' => $app['config']['pomm'],
));

return $app;
