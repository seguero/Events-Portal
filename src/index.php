<?php
// Start the session to manage user authentication state
session_start();

require __DIR__ . '/autoload.php';

// Front controller: the single entry point for all requests

$router = new framework\Router();
$app = new framework\Application($router);
$app->run();