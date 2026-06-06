<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
putenv('VIEW_COMPILED_PATH=/tmp');

require __DIR__ . '/../public/index.php';
