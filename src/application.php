<?php
declare(strict_types = 1);

use \Silex\Application;
use \Symfony\Component\HttpFoundation\Request;

$app = require __DIR__ . '/bootstrap.php';

$app->get('/', function(Application $app, Request $request): string {
    return $app['twig']->render('index.html.twig');
});

return $app;
