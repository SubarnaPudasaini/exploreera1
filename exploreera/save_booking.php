<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicle = $_POST['vehicle'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $booking_date = $_POST['booking_date'];
    $seats = $_POST['seats'];

    // Fare calculation
    switch ($vehicle) {
        case "Car":
            $fare = 700 * $seats;
            break;
        case "Bus":
            $fare = 650 * $seats;
            break;
        case "Taxi":
            $fare = 350 * $seats;
            break;
        case "Train":
            $fare = 150 * $seats;
            break;
        case "Van":
            $fare = 550 * $seats;
            break;
        case "Bike":
            $fare = 650 * $seats;
            break;
        default:
            $fare = 0;
    }

    $sql = "INSERT INTO vehiccal_bookings (vehicle, name, contact, pickup, dropoff, booking_date, seats, fare)
            VALUES ('$vehicle','$name','$contact','$pickup','$dropoff','$booking_date','$seats','$fare')";

    if (mysqli_query($conn, $sql)) {
        // Get last inserted id
        $last_id = mysqli_insert_id($conn);
        header("Location: vehical_bill.php?id=$last_id");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
