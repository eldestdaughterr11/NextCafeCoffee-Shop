<?php
// Standalone migration script - no CodeIgniter dependency
$host = 'localhost';
$database = 'nextcafe_ecomms';
$username = 'root';
$password = '';

echo "Connecting to database...\n";

try {
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "✓ Connected successfully\n\n";
    echo "Running migration...\n\n";
    
    // Read migration file
    $sql = file_get_contents('migration_ecommerce_features.sql');
    
    // Execute as multi-query
    if ($conn->multi_query($sql)) {
        do {
            // Store first result set
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
    }
    
    if ($conn->error) {
        echo "Error: " . $conn->error . "\n";
    } else {
        echo "✅ Migration executed successfully!\n\n";
    }
    
    // Verify tables
    echo "Verifying tables:\n";
    $result = $conn->query("SHOW TABLES LIKE 'reviews'");
    echo ($result->num_rows > 0) ? "✓ reviews table exists\n" : "✗ reviews table missing\n";
    
    $result = $conn->query("SHOW TABLES LIKE 'wishlist'");
    echo ($result->num_rows > 0) ? "✓ wishlist table exists\n" : "✗ wishlist table missing\n";
    
    $result = $conn->query("SHOW COLUMNS FROM orders LIKE 'tracking_number'");
    echo ($result->num_rows > 0) ? "✓ tracking columns added\n" : "✗ tracking columns missing\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
