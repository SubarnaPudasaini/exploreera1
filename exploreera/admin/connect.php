<?php
$servername = "sql311.infinityfree.com";
$username   = "if0_40747303";
$password   = "9748308206";
$database   = "if0_40747303_exploreera";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully"; // (use only for testing)
?>
