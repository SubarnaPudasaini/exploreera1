<?php
include "connect.php";

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM vehiccal_bookings WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $booking = mysqli_fetch_assoc($result);
} else {
    die("Booking not found!");
}

// Vehicle icons mapping
$vehicleIcons = [
    "Car" => "https://cdn-icons-png.flaticon.com/512/741/741407.png",
    "Bus" => "https://cdn-icons-png.flaticon.com/512/3448/3448339.png",
    "Taxi" => "https://cdn-icons-png.flaticon.com/512/3202/3202926.png",
    "Train" => "https://cdn-icons-png.flaticon.com/512/3448/3448612.png",
    "Van" => "https://cdn-icons-png.flaticon.com/512/741/741412.png",
    "Bike" => "https://cdn-icons-png.flaticon.com/512/998/998370.png"
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Bill - N-ExploreEra</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Ultra-premium bill style */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a, #020617);
            color: #fff;
            padding: 30px 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .bill-container {
            max-width: 700px;
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 234, 255, 0.5);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .bill-container h2 {
            text-align: center;
            font-size: 32px;
            color: #00eaff;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .bill-item {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 12px;
            transition: 0.3s;
        }

        .bill-item span {
            font-weight: 600;
        }

        .bill-item.vehicle {
            font-size: 22px;
            color: #facc15;
            justify-content: flex-start;
            gap: 15px;
        }

        .bill-item.vehicle img {
            width: 40px;
            height: 40px;
        }

        .bill-item:hover {
            background: rgba(0, 234, 255, 0.1);
        }

        .total {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            color: #22c55e;
        }

        .print-btn {
            margin-top: 25px;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            color: #020617;
            background: #00eaff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .print-btn:hover {
            background: #22c55e;
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <div class="bill-container">
        <h2>Booking Bill</h2>

        <div class="bill-item vehicle">
            <img src="<?php echo $vehicleIcons[$booking['vehicle']]; ?>" alt="Vehicle">
            <span><?php echo $booking['vehicle']; ?></span>
        </div>
        <div class="bill-item"><span>Name:</span> <span><?php echo $booking['name']; ?></span></div>
        <div class="bill-item"><span>Contact:</span> <span><?php echo $booking['contact']; ?></span></div>
        <div class="bill-item"><span>Pickup:</span> <span><?php echo $booking['pickup']; ?></span></div>
        <div class="bill-item"><span>Drop:</span> <span><?php echo $booking['dropoff']; ?></span></div>
        <div class="bill-item"><span>Date:</span> <span><?php echo $booking['booking_date']; ?></span></div>
        <div class="bill-item"><span>Passengers / Seats:</span> <span><?php echo $booking['seats']; ?></span></div>

        <div class="total">Fare: Rs.<?php echo $booking['fare']; ?></div>

        <button class="print-btn" onclick="window.print()">Print / Save Bill</button>
        <a href="vehical.html"><button class="print-btn">Back</button></a>
    </div>

</body>

</html>