<?php
session_start(); // START SESSION
include "connect.php";

$email = isset($_GET['email']) ? $_GET['email'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';

// Basic validation
if (empty($email) || empty($password)) {
  echo "<script>alert('Please enter both email and password'); window.history.back();</script>";
  exit;
}

// Escape inputs to prevent SQL injection
$email = $conn->real_escape_string($email);
$password = $conn->real_escape_string($password);

// Check if user exists
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // User found, set session
  $user = $result->fetch_assoc();
  $_SESSION['user_email'] = $user['email']; // store email in session

  echo "<script>
            window.location.href='homepage.html';
          </script>";
} else {
  // User not found
  echo "<script>
            alert('Invalid email or password!');
            window.history.back();
          </script>";
}

$conn->close();
