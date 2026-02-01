<?php
include "connect.php";

$booking_id = $_GET['booking_id'] ?? 0;
$hotelName  = $_GET['hotel'] ?? '';

$booking_id = (int)$booking_id;
$hotelName  = mysqli_real_escape_string($conn, $hotelName);

// Fetch booking
$bookingSql = "SELECT * FROM hotel_bookings WHERE id=$booking_id";
$bookingRes = mysqli_query($conn, $bookingSql);

if (mysqli_num_rows($bookingRes) == 0) {
    echo "Booking not found.";
    exit;
}
$booking = mysqli_fetch_assoc($bookingRes);

// Fetch hotel
$hotelSql = "SELECT * FROM hotels WHERE name='$hotelName'";
$hotelRes = mysqli_query($conn, $hotelSql);

if (mysqli_num_rows($hotelRes) == 0) {
    echo "Hotel not found.";
    exit;
}
$hotel = mysqli_fetch_assoc($hotelRes);

// Calculations
$pricePerNight = $hotel['price'];
$rooms = $booking['rooms'];
$nights = 1; // default (can extend later)
$subtotal = $pricePerNight * $rooms * $nights;
$serviceCharge = $subtotal * 0.1;
$tax = $subtotal * 0.13;
$total = $subtotal + $serviceCharge + $tax;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hotel Bill • Nepal TravelHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --primary: #0f4c81;
            --accent: #ff8c1a;
            --bg: #eef2f7;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: 'Segoe UI', sans-serif;
        }

        header {
            background: linear-gradient(135deg, #0f4c81, #1c6fb8);
            color: #fff;
            padding: 30px;
            text-align: center;
            animation: slideDown 1s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-40px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .invoice {
            max-width: 850px;
            margin: 50px auto;
            background: #fff;
            border-radius: 25px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, .15);
            padding: 40px;
            animation: fadeIn 1.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .top h2 {
            color: var(--primary);
            margin: 0;
        }

        .badge {
            background: var(--accent);
            color: #fff;
            padding: 10px 18px;
            border-radius: 30px;
            font-weight: 600;
        }

        .hotel {
            display: flex;
            gap: 25px;
            margin: 30px 0;
        }

        .hotel img {
            width: 260px;
            height: 180px;
            object-fit: cover;
            border-radius: 18px;
        }

        .details p {
            margin: 6px 0;
            color: #555;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .table th,
        .table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            text-align: right;
        }

        .table th {
            background: #f6f8fc;
            color: #333;
        }

        .table td:first-child,
        .table th:first-child {
            text-align: left;
        }

        .total {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .actions {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 26px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
        }

        .print {
            background: linear-gradient(135deg, #ff8c1a, #ff6a00);
            color: #fff;
        }

        .back {
            color: var(--primary);
        }

        .print:hover {
            box-shadow: 0 15px 30px rgba(255, 140, 26, .4);
        }
    </style>
</head>

<body>



    <div class="invoice">

        <div class="top">
            <h2>Invoice #<?= $booking['id'] ?></h2>
            <div class="badge">PAID</div>
        </div>

        <div class="hotel">
            <img src="<?= $hotel['image_url'] ?>" alt="">
            <div class="details">
                <h3><?= $hotel['name'] ?></h3>
                <p><?= $hotel['location'] ?></p>
                <p>Guest: <strong><?= $booking['guest_name'] ?></strong></p>
                <p>Check-in: <?= $booking['journey_date'] ?></p>
                <p>Rooms: <?= $booking['rooms'] ?></p>
            </div>
        </div>

        <table class="table">
            <tr>
                <th>Description</th>
                <th>Amount (Rs.)</th>
            </tr>
            <tr>
                <td>Room Charge (<?= $rooms ?> × <?= $nights ?> night)</td>
                <td><?= number_format($subtotal) ?></td>
            </tr>
            <tr>
                <td>Service Charge (10%)</td>
                <td><?= number_format($serviceCharge) ?></td>
            </tr>
            <tr>
                <td>VAT (13%)</td>
                <td><?= number_format($tax) ?></td>
            </tr>
            <tr>
                <th class="total">Total Payable</th>
                <th class="total">Rs. <?= number_format($total) ?></th>
            </tr>
        </table>

        <div class="actions">
            <a href="#" onclick="window.print()" class="btn print">🖨 Print Bill</a>
            <a href="../homepage.html" class="btn back">← Back to Home</a>
            <a href="booking.php" class="btn back">← Back to Previous</a>
        </div>

    </div>

</body>

</html>