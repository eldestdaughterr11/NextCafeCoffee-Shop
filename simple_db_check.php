<?php
// Simple DB check
require 'app/Config/Database.php';
$dbConfig = new \Config\Database();
$config = $dbConfig->default;

try {
    $dsn = "mysql:host={$config['hostname']};dbname={$config['database']};charset={$config['DBCollat']}";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM users WHERE role = 'admin'");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($admins) > 0) {
        echo "Admin users found:\n";
        print_r($admins);
    } else {
        echo "No admin users found.\n";
        $stmt = $pdo->query("SELECT id, username, email, role FROM users LIMIT 10");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Existing users (up to 10):\n";
        print_r($users);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
