<?php

$db_host = getenv("DB_HOST");
$db_name = getenv("DB_NAME");
$user_name = getenv("DB_USER");
$user_password = getenv("DB_PASS");

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

try {
    $conn = new PDO($dsn, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
