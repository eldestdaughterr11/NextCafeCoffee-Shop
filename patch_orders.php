<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nextcafe_ecomms", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add shipping_method
    try {
        $pdo->exec("ALTER TABLE orders ADD COLUMN shipping_method VARCHAR(50) DEFAULT 'Delivery' AFTER status");
    } catch (Exception $e) {}

    // Add payment_method
    try {
        $pdo->exec("ALTER TABLE orders ADD COLUMN payment_method VARCHAR(50) DEFAULT 'COD' AFTER shipping_method");
    } catch (Exception $e) {}

    // Add address
    try {
        $pdo->exec("ALTER TABLE orders ADD COLUMN address TEXT AFTER payment_method");
    } catch (Exception $e) {}

    echo "Orders table patched successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
