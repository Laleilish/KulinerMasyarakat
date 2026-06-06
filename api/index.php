<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
putenv('VIEW_COMPILED_PATH=/tmp');

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>🚨 Error Tertangkap Manual! 🚨</h1>";
    echo "<b>Pesan Error:</b> " . $e->getMessage() . "<br><br>";
    echo "<b>File:</b> " . $e->getFile() . "<br>";
    echo "<b>Baris:</b> " . $e->getLine() . "<br>";
    exit;
}
