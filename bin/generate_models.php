#! /usr/bin/env php
<?php

use \Pomm\Tools\ScanSchemaTool;

$app = require __DIR__ . '/../src/bootstrap.php';

$scan = new ScanSchemaTool(array(
    'schema' => isset($argv[1]) ? $argv[1] : 'public',
    'database' => $app['pomm']->getDatabase(),
    'namespace' => 'Model',
    'prefix_dir' => __DIR__ . '/../src/',
));

$scan->execute();
