<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'nextcafe_ecomms';

$updates = [
    'classic-coffee-frappe' => 'images/classiccofeefrappe.jpg',
    'caramel-frappe'        => 'images/caramelfrappe.jpg',
    'mocha-frappe'          => 'images/mochafrappe.webp',
    'matcha-frappe'         => 'images/matchafrappe.jpg',
    'vanilla-frappe'        => 'images/vanillafrappe.jpg',
];

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure Frappe category exists
    $stmt = $pdo->prepare("INSERT IGNORE INTO `categories` (`name`, `slug`, `status`, `created_at`, `updated_at`) VALUES (?, ?, ?, NOW(), NOW())");
    $stmt->execute(['Frappe', 'frappe', 'active']);
    echo "Checked Frappe category.\n";

    foreach ($updates as $slug => $image) {
        $stmt = $pdo->prepare("UPDATE products SET image_url = ?, category = 'Frappe' WHERE slug = ?");
        $stmt->execute([$image, $slug]);
        $count = $stmt->rowCount();
        
        if ($count > 0) {
            echo "Updated $slug -> $image\n";
        } else {
            // Check if it exists at all
            $check = $pdo->prepare("SELECT id FROM products WHERE slug = ?");
            $check->execute([$slug]);
            if ($check->fetch()) {
                echo "Skipped $slug (already up to date or no change detected)\n";
            } else {
                echo "Warning: Product with slug '$slug' not found in database!\n";
            }
        }
    }
    
    echo "\nDatabase update complete!\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
