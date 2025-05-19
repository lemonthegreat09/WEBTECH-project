<?php
$host = "localhost";
$user = "root";
$pass = ""; // adjust if you have a password
$db = "webtech_clients";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
