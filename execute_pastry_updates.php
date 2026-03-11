<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
$loader = require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/app/Config/Paths.php';
$config = new \Config\Paths();
require __DIR__ . '/vendor/codeigniter4/framework/system/bootstrap.php';

$db = \Config\Database::connect();

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
    $builder = $db->table('products');
    $builder->where('product_name', $name);
    $builder->update([
        'image_url' => $image,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    if ($db->affectedRows() > 0) {
        echo "Done.\n";
    } else {
        echo "No changes or product not found.\n";
    }
}

echo "\n--- VERIFICATION ---\n";
$query = $db->table('products')->whereIn('product_name', array_keys($updates))->get();
foreach ($query->getResult() as $row) {
    echo "Product: {$row->product_name} | Image: {$row->image_url}\n";
}
