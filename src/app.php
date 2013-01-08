<?php

use Silex\Application;
use Sanpi\Coding\Rule;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/Sanpi/Cist/Resources/views',
));

$app->get('/', function(Request $request) use($app) {
    return $app['twig']->render('index.twig.html');
});

return $app;
