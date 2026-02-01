<?php
// Database credentials
$host = "localhost";  // XAMPP default
$user = "root";       // XAMPP default username
$pass = "";           // XAMPP default password is empty
$dbname = "exploreearth"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: success message
// echo "Connected successfully";
