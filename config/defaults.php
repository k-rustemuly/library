<?php
error_reporting(1);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Aqtau');
$settings = [];
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';
$settings['template'] = $settings['root'] . '/templates';
$settings['uploads_public_dir'] = 'uploads/news/';
$settings['uploads_dir'] = UPLOADS_DIR . '/news/';

$settings['error'] = [
    // Should be set to false in production
    'display_error_details' => $_ENV["API_IS_DEBUG"],
    // Should be set to false for unit tests
    'log_errors' => $_ENV["API_IS_DEBUG"],
    // Display error details in error log
    'log_error_details' => $_ENV["API_IS_DEBUG"],
];

$settings['logger'] = [
    'name' => 'app',
    'path' => $settings['root'] . '/logs',
    'filename' => 'app.log',
    'level' => \Monolog\Logger::DEBUG,
    'file_permission' => 0775,
];

$settings['db'] = [
    'driver' => \Cake\Database\Driver\Mysql::class,
    'host' => $_ENV["DB_HOST"],
    'encoding' => 'utf8mb4',
    'username' => $_ENV["DB_USER"],
    'password' => $_ENV["DB_PASSWORD"],
    'database' => $_ENV["DB_NAME"],
    'collation' => 'utf8mb4_unicode_ci',
    // Enable identifier quoting
    'quoteIdentifiers' => true,
    // Set to null to use MySQL servers timezone
    'timezone' => "+06:00",
    // Disable meta data cache
    'cacheMetadata' => false,
    // Disable query logging
    'log' => false,
    // PDO options
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => true,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Convert numeric values to strings when fetching.
        // Since PHP 8.1 integers and floats in result sets will be returned using native PHP types.
        // This option restores the previous behavior.
        PDO::ATTR_STRINGIFY_FETCHES => true,
    ],
];

return $settings;