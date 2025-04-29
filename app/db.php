<?php
$host = getenv('DB_HOST') ?: '10.100.10.3';
$user = getenv('DB_USER') ?: 'imageservice';
$pass = getenv('DB_PASSWORD') ?: 'M3inepasswort';
$db   = getenv('DB_NAME') ?: 'image_service';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>