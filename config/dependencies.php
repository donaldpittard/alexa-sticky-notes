<?php

// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Database
$container['db'] = function ($c) {
    $db  = $c->get('settings')['db'];
    $pdo = new PDO('pgsql:host=' . $db['host'] . ';port=' . $db['port'] . ';dbname=' . $db['dbname'] . ';user=' . $db['user'] . ';password=' . $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    return $pdo;
};

// Google Client
$container['google'] = function ($c) {
    $googleCreds  = $c->get('settings')['google'];
    $googleClient = new Google_Client();

    $googleClient->setClientId($googleCreds['client_id']);
    $googleClient->setClientSecret($googleCreds['client_secret']);
    $googleClient->setApplicationName('Alexa Sticky Notes');
    $googleClient->setRedirectUri($googleCreds['redirect_uri']);
    $googleClient->setScopes('email');

    return $googleClient;
};

// Index Controller
$container['index'] = function ($c) {
    return new App\Controller\Index($c);
};

// Login Controller
$container['login'] = function ($c) {
    return new App\Controller\Login($c);
};

// Notes Controller
$container['notes'] = function ($c) {
    return new App\Controller\Notes($c);
};

// Session
$container['session'] = function ($c) {
    return new \SlimSession\Helper();
};
