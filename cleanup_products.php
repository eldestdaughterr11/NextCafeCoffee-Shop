<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nextcafe_ecomms", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Get all products
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Initial product count: " . count($products) . "\n";

    $seenNames = [];
    $toDelete = [];

    foreach ($products as $p) {
        $name = strtolower(trim($p['product_name']));
        if (isset($seenNames[$name])) {
            $toDelete[] = $p['id'];
            echo "Found duplicate: '{$p['product_name']}' (ID: {$p['id']}) - Marking for deletion.\n";
        } else {
            $seenNames[$name] = $p['id'];
        }
    }

    if (!empty($toDelete)) {
        $ids = implode(',', $toDelete);
        $pdo->exec("DELETE FROM products WHERE id IN ($ids)");
        echo "Deleted " . count($toDelete) . " duplicate(s).\n";
    }

    // 2. Ensure all remaining products have valid, unique slugs
    $stmt = $pdo->query("SELECT id, product_name, slug FROM products");
    $remaining = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($remaining as $p) {
        $idealSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $p['product_name'])));
        
        // If slug is wrong or empty, update it
        if ($p['slug'] !== $idealSlug || empty($p['slug'])) {
            $update = $pdo->prepare("UPDATE products SET slug = ? WHERE id = ?");
            $update->execute([$idealSlug, $p['id']]);
            echo "Updated ID {$p['id']} slug to: $idealSlug\n";
        }
    }

    echo "Cleanup complete.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
