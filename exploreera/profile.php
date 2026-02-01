<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.html"); // redirect if not logged in
    exit;
}


// Database connection
include "connect.php"; // Make sure connect.php contains $conn = new mysqli(...);

$email = $_SESSION['user_email'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('User not found!'); window.location.href='index.html';</script>";
    exit;
}

$user = $result->fetch_assoc();
