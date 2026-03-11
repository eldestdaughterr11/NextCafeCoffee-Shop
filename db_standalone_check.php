<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'nextcafe_ecomms';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, username, email, role FROM users WHERE role = 'admin'");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($admins) > 0) {
        echo "Admin users found:\n";
        print_r($admins);
    } else {
        echo "No admin users found.\n";
        $stmt = $pdo->query("SELECT id, username, email, role FROM users LIMIT 10");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Check all users (up to 10):\n";
        print_r($users);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
