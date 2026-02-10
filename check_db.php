<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
$pathsPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Paths.php');
require_once $pathsPath;
$paths = new Config\Paths();
require_once $paths->systemDirectory . DIRECTORY_SEPARATOR . 'bootstrap.php';

$db = \Config\Database::connect();
$query = $db->query("SHOW COLUMNS FROM products");
$columns = $query->getResult();
foreach ($columns as $column) {
    echo $column->Field . "\n";
}
