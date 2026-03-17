<?php
$host = "localhost";
$user = "root";
$pass = "admin";
$db   = "skilllens_ai";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>