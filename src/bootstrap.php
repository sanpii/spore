<?php

use Pomm\Silex\PommServiceProvider;
use Silex\Provider\TwigServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['config'] = require __DIR__ . '/config/current.php';

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app->register(new PommServiceProvider(), array(
    'pomm.databases' => $app['config']['pomm'],
));

return $app;
