<?php
$host     = getenv("DB_HOST") ?: "db";
$port     = getenv("DB_PORT") ?: "5432";
$dbname   = getenv("DB_NAME") ?: "postgres";
$user     = getenv("DB_USER") ?: "postgres";
$password = getenv("DB_PASSWORD") ?: "mypassword";

$con = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$con) {
    die("❌ Database connection failed:a " . pg_last_error());
}

echo "✅ Database connected successfully!<br>";

$result = pg_query($con, "SELECT version();");
$row = pg_fetch_row($result);


?>
