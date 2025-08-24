<?php
// โหลดค่าจาก environment variables (มาจาก .env ผ่าน docker-compose)
$host     = getenv("DB_HOST") ?: "db";
$port     = getenv("DB_PORT") ?: "5432";
$dbname   = getenv("DB_NAME") ?: "postgres";
$user     = getenv("DB_USER") ?: "postgres";
$password = getenv("DB_PASSWORD") ?: "mypassword";

// สร้างการเชื่อมต่อ PostgreSQL
$con = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// ตรวจสอบการเชื่อมต่อ
if (!$con) {
    die("❌ Database connection failed: " . pg_last_error());
}
?>
