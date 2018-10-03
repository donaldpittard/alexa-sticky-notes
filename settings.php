<?php
define('APP_ROOT', __DIR__);
$dbopts = parse_url(getenv('DATABASE_URL'));

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'doctrine' => [
            'dev_mode'      => true,
            'cache_dir'     => APP_ROOT . '/var/doctrine/',
            'metadata_dirs' => [APP_ROOT . '/src/Domain'],
            'connection'    => [
                'driver'   => 'pdo_pgsql',
                'host'     => $dbopts['host'],
                'dbname'   => ltrim($dbopts['path'], '/'),
                'user'     => $dbopts['user'],
                'password' => $dbopts['pass'],
                'charset'  => 'utf-8',
            ],
        ],
    ],
];
