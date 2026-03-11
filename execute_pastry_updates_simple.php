<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'nextcafe_ecomms';

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$updates = [
    'Banana Bread' => 'images/bananabread.jpg',
    'Cinnamon Roll' => 'images/cinnamonrolls.jpg',
    'Chocolate Muffin' => 'images/chocolatemuffins.webp',
    'Butter Croissant' => 'images/buttercroissants.jpg',
    'Blueberry Muffin' => 'images/blueberrymuffins.jpg'
];

echo "--- UPDATING PASTRY IMAGES ---\n";

foreach ($updates as $name => $image) {
    echo "Updating {$name}... ";
    
    $stmt = $conn->prepare("UPDATE products SET image_url = ?, updated_at = NOW() WHERE product_name = ?");
    $stmt->bind_param("ss", $image, $name);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo "Done.\n";
    } else {
        echo "No changes or product not found.\n";
    }
    $stmt->close();
}

echo "\n--- VERIFICATION ---\n";
$names = "'" . implode("','", array_map([$conn, 'real_escape_string'], array_keys($updates))) . "'";
$result = $conn->query("SELECT product_name, image_url FROM products WHERE product_name IN ($names)");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Product: {$row['product_name']} | Image: {$row['image_url']}\n";
    }
} else {
    echo "No products found in the list.\n";
}

$conn->close();
