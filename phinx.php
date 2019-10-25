<?php

require __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/.env')) {
    $env = Dotenv\Dotenv::create(__DIR__);
    $env->load();
}

$dbopts = parse_url(getenv('DATABASE_URL'));

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_database' => 'db',
            'db' => [
                'adapter' => 'mysql',
                'host' => $dbopts['host'],
                'name' => ltrim($dbopts['path'], '/'),
                'user' => $dbopts['user'],
                'pass' => $dbopts['pass'],
                'port' => $dbopts['port'],
                'charset' => 'utf8',
            ],
        ],
        'version_order' => 'creation'
    ];
