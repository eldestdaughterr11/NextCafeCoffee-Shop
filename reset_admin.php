<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'nextcafe_ecomms';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Using bcrypt as expected by Admin/Auth logic
    $newPassword = password_hash('admin123', PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = 'admin@example.com' OR username = 'admin'");
    $stmt->execute([$newPassword]);

    if ($stmt->rowCount() > 0) {
        echo "Successfully updated admin password to admin123\n";
    } else {
        echo "No user updated. Check if admin@example.com or username 'admin' exists.\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
