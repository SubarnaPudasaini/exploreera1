<?php
include "connect.php";

$booking_id = $_POST['booking_id'] ?? '';
$action = $_POST['action'] ?? '';

if ($booking_id && $action) {
    $status = ($action == 'accept') ? 'confirmed' : 'cancelled';
    $sql = "UPDATE bookings SET status='$status' WHERE id=$booking_id";
    mysqli_query($conn, $sql);
}

header("Location: bookings.php");
exit();
