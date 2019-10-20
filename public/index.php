<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $env = Dotenv\Dotenv::create(__DIR__ . '/../');
    $env->load();
}

session_start();

// Instantiate the app
$configDir = __DIR__ . '/../config';
$settings = require $configDir . '/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require $configDir . '/dependencies.php';

// Register middleware
require $configDir . '/middleware.php';

// Register routes
require $configDir . '/routes.php';

// Run app
$app->run();
