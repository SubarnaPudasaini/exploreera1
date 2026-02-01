<?php
include "connect.php";

if (isset($_POST['booking_id'])) {
    $id = intval($_POST['booking_id']);
    $sql = "DELETE FROM vehiccal_bookings WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "no id";
}
