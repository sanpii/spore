<?php

use \Silex\Application;
use \Symfony\Component\HttpFoundation\Request;

$app = require __DIR__ . '/bootstrap.php';

$app->get('/', function(Application $app, Request $request) {
    return $app['twig']->render('index.html.twig');
});

return $app;
