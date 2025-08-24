<?php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

$conn = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass");

if ($conn) {
    echo " Connected to PostgreSQL successfully!";
} else {
    echo " Connection failed.";
}
?>
