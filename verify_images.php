<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'nextcafe_ecomms';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT product_name, slug, image_url FROM products WHERE slug LIKE '%frappe%'");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($result);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
