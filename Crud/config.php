<?php
$conn = new mysqli("localhost", "root", "", "interview-crud");
// print_r($conn);
// exit;

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
