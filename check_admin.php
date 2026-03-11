<?php
require __DIR__ . '/app/Config/Paths.php';
$paths = new \Config\Paths();

// Boot CI4
require $paths->systemDirectory . '/Boot.php';
\CodeIgniter\Boot::bootConsole($paths);

$db = \Config\Database::connect();
$admin = $db->table('users')->where('role', 'admin')->get()->getRow();

if ($admin) {
    echo "Admin user found:\n";
    print_r($admin);
} else {
    echo "No admin user found.\n";
    $allUsers = $db->table('users')->get()->getResult();
    echo "All users in DB:\n";
    print_r($allUsers);
}
