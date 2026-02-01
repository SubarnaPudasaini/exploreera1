<?php
include "connect.php";

if (isset($_GET['username']) && isset($_GET['email']) && isset($_GET['password'])) {
    $username = $_GET['username'];
    $email = $_GET['email'];
    $password = $_GET['password'];

    // Check if email exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.history.back();</script>";
        exit;
    }



    $sql = "INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration Successful!'); window.location.href='login_registration.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
