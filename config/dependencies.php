<?php

// DIC configuration

use App\Middleware\Authentication;
use Psr\Container\ContainerInterface;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function (ContainerInterface $c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function (ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

// Database
$container['db'] = function (ContainerInterface $c) {
    $db       = $c->get('settings')['db'];
    $host     = $db['host'];
    $port     = $db['port'];
    $name     = $db['dbname'];
    $username = $db['user'];
    $password = $db['pass'];
    $dsn      = "mysql:host=$host;port=$port;dbname=$name";
    $options  = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
};

// Google Client
$container['google'] = function (ContainerInterface $c) {
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
$container['index'] = function (ContainerInterface $c) {
    $renderer = $c->get('renderer');
    $session  = $c->get('session');

    return new App\Controller\Index($renderer, $session);
};

// Login Controller
$container['login'] = function (ContainerInterface $c) {
    $db           = $c->get('db');
    $googleClient = $c->get('google');
    $renderer     = $c->get('renderer');
    $session      = $c->get('session');

    return new App\Controller\Login($db, $googleClient, $renderer, $session);
};

// Notes Controller
$container['notes'] = function (ContainerInterface $c) {
    $db      = $c->get('db');
    $session = $c->get('session');

    return new App\Controller\Notes($db, $session);
};

// Authentication Middleware
$container[Authentication::class] = function (ContainerInterface $c) {
    $session = $c->get('session');

    return new Authentication($session);
};

// Session
$container['session'] = function (ContainerInterface $c) {
    return new \SlimSession\Helper();
};

// Logout Controller
$container['logout'] = function (ContainerInterface $c) {
    return new App\Controller\Logout($c);
};
