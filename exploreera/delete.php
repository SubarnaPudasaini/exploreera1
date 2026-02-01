<?php
include "backend/connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('User deleted successfully!');
                window.location.href='datashow.php';
              </script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
