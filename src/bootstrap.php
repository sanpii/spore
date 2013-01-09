<?php

use Pomm\Silex\PommServiceProvider;
use Silex\Provider\TwigServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['config'] = require __DIR__ . '/config/current.php';

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app['pomm.service'] = $app->share(function() use ($app) {
    return new Pomm\Service($app['config']['pomm']);
});

$app['pomm'] = function() use ($app) {
    return $app['pomm.service']->createConnection();
};

return $app;
