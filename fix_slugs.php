<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nextcafe_ecomms", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Add column if not exists
    try {
        $pdo->exec("ALTER TABLE products ADD COLUMN slug VARCHAR(255) AFTER product_name");
    } catch (Exception $e) {
        echo "Column might already exist: " . $e->getMessage() . "\n";
    }

    // 2. Add unique index if not exists
    try {
        $pdo->exec("ALTER TABLE products ADD UNIQUE (slug)");
    } catch (Exception $e) {
        echo "Index might already exist: " . $e->getMessage() . "\n";
    }

    // 3. Populate slug from product_name
    $stmt = $pdo->query("SELECT id, product_name FROM products WHERE slug IS NULL OR slug = ''");
    $updateStmt = $pdo->prepare("UPDATE products SET slug = ? WHERE id = ?");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['product_name'])));
        $updateStmt->execute([$slug, $row['id']]);
        echo "Updated product {$row['id']} with slug: $slug\n";
    }

    echo "Database patch complete.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
