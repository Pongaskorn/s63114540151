<?php
header('Content-Type: text/html; charset=utf-8');
include "db.php";

echo "<h2>🚀 PostgreSQL Connection Test</h2>";

try {
    $stmt = $pdo->query("SELECT NOW() as current_time");
    $row = $stmt->fetch();
    echo "<p>✅ Connected! Current DB time: " . $row['current_time'] . "</p>";

    $stmt = $pdo->query("SELECT product_id, product_title, product_price FROM products LIMIT 5");
    echo "<h3>Sample Products:</h3><ul>";
    foreach ($stmt as $row) {
        echo "<li>ID: {$row['product_id']} | {$row['product_title']} | {$row['product_price']}</li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    echo "<p>❌ Query failed: " . $e->getMessage() . "</p>";
}
