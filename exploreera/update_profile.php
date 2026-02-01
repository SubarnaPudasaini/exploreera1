<?php
session_start();
$_SESSION['user_email'] = $email_from_db; // set the logged-in email
header("Location: profile.php");
exit;


// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "exploreera";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from database
$email = $_SESSION['user_email'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "User not found!";
    exit;
}

$user = $result->fetch_assoc();
