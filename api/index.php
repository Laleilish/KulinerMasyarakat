<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Vercel is read-only, redirect ALL writable paths to /tmp
$_ENV['IS_VERCEL'] = true;
putenv('IS_VERCEL=true');

$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
putenv('VIEW_COMPILED_PATH=/tmp/views');

$_ENV['LOG_CHANNEL'] = 'stderr';
putenv('LOG_CHANNEL=stderr');

$_ENV['CACHE_STORE'] = 'array';
putenv('CACHE_STORE=array');

$_ENV['SESSION_DRIVER'] = 'cookie';
putenv('SESSION_DRIVER=cookie');

$_ENV['APP_SERVICES_CACHE'] = '/tmp/cache/services.php';
putenv('APP_SERVICES_CACHE=/tmp/cache/services.php');

$_ENV['APP_PACKAGES_CACHE'] = '/tmp/cache/packages.php';
putenv('APP_PACKAGES_CACHE=/tmp/cache/packages.php');

$_ENV['APP_CONFIG_CACHE'] = '/tmp/cache/config.php';
putenv('APP_CONFIG_CACHE=/tmp/cache/config.php');

$_ENV['APP_ROUTES_CACHE'] = '/tmp/cache/routes-v7.php';
putenv('APP_ROUTES_CACHE=/tmp/cache/routes-v7.php');

$_ENV['APP_EVENTS_CACHE'] = '/tmp/cache/events.php';
putenv('APP_EVENTS_CACHE=/tmp/cache/events.php');

// Create temp directories
@mkdir('/tmp/views', 0755, true);
@mkdir('/tmp/cache', 0755, true);
@mkdir('/tmp/sessions', 0755, true);
@mkdir('/tmp/logs', 0755, true);

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>🚨 Error Tertangkap!</h1>";
    echo "<b>Pesan:</b> " . htmlspecialchars($e->getMessage()) . "<br><br>";
    echo "<b>File:</b> " . htmlspecialchars($e->getFile()) . "<br>";
    echo "<b>Baris:</b> " . $e->getLine() . "<br><br>";
    echo "<b>Trace:</b><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
}
