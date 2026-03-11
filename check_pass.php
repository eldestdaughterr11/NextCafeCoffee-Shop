<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'nextcafe_ecomms';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, username, email, role, password FROM users WHERE email = 'admin@example.com'");
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        echo "Admin user found:\n";
        echo "ID: {$admin['id']}\n";
        echo "Role: {$admin['role']}\n";
        echo "Password Hash: {$admin['password']}\n";
        echo "Hash Length: " . strlen($admin['password']) . "\n";
        
        // Test MD5
        echo "Matches MD5('admin123'): " . (md5('admin123') === $admin['password'] ? 'YES' : 'NO') . "\n";
        
        // Test password_verify
        echo "Matches password_verify('admin123'): " . (password_verify('admin123', $admin['password']) ? 'YES' : 'NO') . "\n";
    } else {
        echo "Admin user 'admin@example.com' not found.\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
