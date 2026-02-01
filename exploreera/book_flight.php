<?php
include "connect.php";
// 2. Get data from the form
$from = $_POST['from'];
$to = $_POST['to'];
$date = $_POST['date'];
$passengers = $_POST['passengers'];

// 3. Insert data into database
$sql = "INSERT INTO flight_bookings (`from_location`, `to_location`, `journey_date`, `passengers`) 
        VALUES ('$from', '$to', '$date', '$passengers')";

if ($conn->query($sql) === TRUE) {
    echo "Flight booked successfully!";
    // Optionally redirect to bill page with GET parameters
    header("Location: bill.html?from=$from&to=$to&date=$date&passengers=$passengers");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
