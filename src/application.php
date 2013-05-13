<?php

use \Symfony\Component\HttpFoundation\Request;

$app = require __DIR__ . '/bootstrap.php';

$app->get('/', function(Request $request) use($app) {
    $data = array(
        '_links' => array(
            'self' => array(
                'href' => '/',
            ),
        ),
        'content' => 'Hello world!',
    );

    return $app->json($data);
});

return $app;
