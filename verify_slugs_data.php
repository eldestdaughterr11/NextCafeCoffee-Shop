<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nextcafe_ecomms", "root", "");
    $stmt = $pdo->query("SELECT id, product_name, slug FROM products LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id']}, Name: {$row['product_name']}, Slug: {$row['slug']}\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
