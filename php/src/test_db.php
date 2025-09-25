<?php
require 'db.php';

echo "<h2>✅ Connected to PostgreSQL successfully!</h2>";

// ==== 1. SELECT version ====
$result = pg_query($con, "SELECT version();");
$row = pg_fetch_row($result);
echo "<p><b>Postgres Version:</b> " . $row[0] . "</p>";

// ==== 2. สร้างตารางทดสอบ (ถ้ายังไม่มี) ====
pg_query($con, "
    CREATE TABLE IF NOT EXISTS test_users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100)
    )
");

// ==== 3. INSERT ====
$insert = pg_query($con, "INSERT INTO test_users (name, email) VALUES ('Test User', 'test@example.com');");
if ($insert) {
    echo "<p>✅ Insert success!</p>";
} else {
    echo "<p>❌ Insert failed: " . pg_last_error($con) . "</p>";
}

// ==== 4. SELECT ====
$result = pg_query($con, "SELECT * FROM test_users;");
if ($result) {
    echo "<h3>📋 Current Data in test_users:</h3>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<pre>" . print_r($row, true) . "</pre>";
    }
} else {
    echo "<p>❌ Select failed: " . pg_last_error($con) . "</p>";
}

// ==== 5. UPDATE ====
$update = pg_query($con, "UPDATE test_users SET name = 'Updated User' WHERE email = 'test@example.com';");
if ($update) {
    echo "<p>✅ Update success!</p>";
} else {
    echo "<p>❌ Update failed: " . pg_last_error($con) . "</p>";
}

// ==== 6. DELETE ====
$delete = pg_query($con, "DELETE FROM test_users WHERE email = 'test@example.com';");
if ($delete) {
    echo "<p>✅ Delete success!</p>";
} else {
    echo "<p>❌ Delete failed: " . pg_last_error($con) . "</p>";
}
?>
