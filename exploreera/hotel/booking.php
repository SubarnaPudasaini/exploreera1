<?php
include "connect.php";

$hotelName = $_GET['hotel'] ?? '';
$hotelName = mysqli_real_escape_string($conn, $hotelName);

// Fetch hotel
$sql = "SELECT * FROM hotels WHERE name='$hotelName'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Hotel not found.";
    exit;
}

$hotel = mysqli_fetch_assoc($result);

if (isset($_POST['confirm_booking'])) {
    $guest = mysqli_real_escape_string($conn, $_POST['guest_name']);
    $date = $_POST['journey_date'];
    $guests = (int)$_POST['guests'];
    $rooms = (int)$_POST['rooms'];
    $days = (int)$_POST['days']; // NEW

    $insert = "INSERT INTO hotel_bookings
      (guest_name, journey_date, passengers, rooms, days, status) 
      VALUES ('$guest','$date','$guests','$rooms','$days','confirmed')";

    if (mysqli_query($conn, $insert)) {
        $booking_id = mysqli_insert_id($conn);

        // ✅ REDIRECT TO BILL
        header("Location: bill.php?booking_id=$booking_id&hotel=$hotelName");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?= $hotel['name'] ?> • Nepal TravelHub</title>

    <style>
        /* 🔒 UI KEPT EXACTLY SAME */
        :root {
            --primary: #0f4c81;
            --accent: #ff8c1a;
            --bg: #f3f6fb;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg);
        }

        header {
            background: linear-gradient(135deg, #0f4c81, #1c6fb8);
            color: #fff;
            padding: 28px;
            text-align: center;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, .15);
            padding: 40px;
        }

        .hotel-preview {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .hotel-preview img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 18px;
        }

        .hotel-info h3 {
            margin: 0;
            color: var(--primary);
            font-size: 26px;
        }

        .hotel-info p {
            margin: 8px 0;
            color: #555;
        }

        .price {
            font-size: 22px;
            font-weight: 700;
            color: var(--accent);
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 12px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            background: linear-gradient(135deg, #ff8c1a, #ff6a00);
            color: #fff;
            border: none;
            border-radius: 40px;
            cursor: pointer;
        }

        .btn-primary:hover {
            box-shadow: 0 15px 30px rgba(255, 140, 26, .4);
        }

        .btn-secondary {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: var(--primary);
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="hotel-preview">
            <img src="<?= $hotel['image_url'] ?>" alt="<?= $hotel['name'] ?>">
            <div class="hotel-info">
                <h3><?= $hotel['name'] ?></h3>
                <p><?= $hotel['location'] ?></p>
                <p class="price">Rs. <?= number_format($hotel['price']) ?> / night</p>
            </div>
        </div>

        <form method="POST">
            <label>Guest Full Name</label>
            <input type="text" name="guest_name" required placeholder="Eg.. Subarna Pudasaini.">

            <label>Check-in Date</label>
            <input type="date" name="journey_date" required>


            <label>Number of Rooms</label>
            <input type="number" name="rooms" min="1" value="1" required>

            <!-- ✅ NEW FIELD -->
            <label>How Many Days?</label>
            <input type="number" name="days" min="1" value="1" required>

            <button type="submit" name="confirm_booking" class="btn-primary">
                Confirm Booking
            </button>

            <a href="details.php?hotel=<?= urlencode($hotel['name']) ?>" class="btn-secondary">
                ← Back to Hotel Details
            </a>
        </form>

    </div>

</body>

</html>