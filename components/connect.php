<?php

$db_host = getenv("DB_HOST");
$db_name = getenv("DB_NAME");
$db_user = getenv("DB_USER");
$db_pass = getenv("DB_PASS");

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

try {
    $conn = new PDO($dsn, $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Connected to DB!";
} catch(PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>
