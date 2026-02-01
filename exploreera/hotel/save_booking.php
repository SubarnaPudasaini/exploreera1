<?php
include 'connect.php';
// GET FORM DATA
$hotel = $_POST['hotel'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$from_city = $_POST['from_city'];
$to_city = $_POST['to_city'];
$persons = $_POST['persons'];
$nights = $_POST['nights'];
$checkin_date = $_POST['checkin_date'];

// INSERT INTO DATABASE
$sql = "INSERT INTO bookings (hotel, name, phone, from_city, to_city, persons, nights, checkin_date)
        VALUES ('$hotel', '$name', '$phone', '$from_city', '$to_city', '$persons', '$nights', '$checkin_date')";

if ($conn->query($sql) === TRUE) {
    echo "<h2>Booking Successful!</h2>";
    echo "<p>Thank you, $name. Your booking for <b>$hotel</b> has been saved.</p>";
    echo "<a href='index.html'>Go Back</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
