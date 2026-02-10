<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nextcafe_ecomms", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, product_name, slug FROM products");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id']} | Name: {$row['product_name']} | Slug: [{$row['slug']}]\n";
        
        if (empty($row['slug'])) {
            $newSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['product_name'])));
            $update = $pdo->prepare("UPDATE products SET slug = ? WHERE id = ?");
            $update->execute([$newSlug, $row['id']]);
            echo "  --> FIXED: Set slug to [$newSlug]\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
