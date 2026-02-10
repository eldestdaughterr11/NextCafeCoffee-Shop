<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nextcafe_ecomms", "root", "");
    $stmt = $pdo->query("DESCRIBE products");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . "\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
