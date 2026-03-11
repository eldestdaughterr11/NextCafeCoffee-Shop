<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'nextcafe_ecomms';

$updates = [
    'hot-chocolate' => 'images/hotchocolate.jpg',
    'matcha-latte'  => 'images/matchalatte.jpg',
    'flat-white'    => 'images/flatwhite.jpg',
    'caramel-latte' => 'images/caramellatte.jpg',
    'cappuccino'    => 'images/cappuccino.jpg',
];

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "--- UPDATING PRODUCT IMAGES ---\n";
    foreach ($updates as $slug => $image) {
        $stmt = $pdo->prepare("UPDATE products SET image_url = ? WHERE slug = ?");
        $stmt->execute([$image, $slug]);
        $count = $stmt->rowCount();
        
        if ($count > 0) {
            echo "Successfully updated: $slug -> $image\n";
        } else {
            $check = $pdo->prepare("SELECT id, image_url FROM products WHERE slug = ?");
            $check->execute([$slug]);
            $row = $check->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                if ($row['image_url'] === $image) {
                    echo "Already set correctly: $slug\n";
                } else {
                    echo "No change for: $slug (check if product_name matches slug)\n";
                }
            } else {
                echo "Warning: Product with slug '$slug' not found in database!\n";
            }
        }
    }
    
    echo "\nDatabase update complete!\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
