<?php
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
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'db' => [
            'host'   => $dbopts['host'],
            'user'   => $dbopts['user'],
            'pass'   => $dbopts['pass'],
            'dbname' => ltrim($dbopts['path'], '/'),
            'port'   => $dbopts['port'],
        ],
        'google' => [
            'client_id'     => getenv('GOOGLE_CLIENT_ID'),
            'client_secret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirect_uri'  => getenv('GOOGLE_REDIRECT_URI'),
        ],
    ],
];
