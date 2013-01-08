<?php

use Pomm\Silex\PommServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['config'] = require __DIR__ . '/config/current.php';

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app->register(new PommServiceProvider(), array(
    'pomm.databases' => $app['config']['pomm.dsn'],
));

$app->get('/', function(Request $request) use($app) {
    return $app['twig']->render('index.twig.html');
});

return $app;
