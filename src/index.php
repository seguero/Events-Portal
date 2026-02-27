<?php
require __DIR__ . '/autoload.php';

$router = new framework\Router();
$app = new framework\Application($router);
$app->run();