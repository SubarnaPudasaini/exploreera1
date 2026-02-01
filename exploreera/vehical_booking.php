<?php
include "connect.php";

// Get vehicle from URL
$vehicle = $_GET['vehicle'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - N-ExploreEra</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #0f172a, #020617);
            color: #fff;
            padding: 30px 15px;
            text-align: center;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        .booking-section {
            background: #1e293b;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 234, 255, 0.4);
        }

        .booking-section h2 {
            margin-bottom: 25px;
            color: #00eaff;
            font-size: 28px;
        }

        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .booking-form input,
        .booking-form select {
            padding: 15px;
            border-radius: 12px;
            border: none;
            outline: none;
            font-size: 16px;
            transition: 0.3s;
        }

        .booking-form input:focus,
        .booking-form select:focus {
            box-shadow: 0 0 15px #00eaff;
        }

        .booking-form button {
            padding: 18px;
            border-radius: 15px;
            border: none;
            font-size: 18px;
            font-weight: bold;
            background: #00eaff;
            color: #020617;
            cursor: pointer;
            transition: 0.3s;
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

        .booking-form button:hover {
            background: #22c55e;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="booking-section">
            <h2><?php
                if ($vehicle === "Train") echo "Book Train Seats";
                elseif ($vehicle === "Bus") echo "Book Bus";
                else echo "Book Your " . $vehicle;
                ?></h2>

            <form class="booking-form" method="POST" action="save_booking.php">
                <input type="hidden" name="vehicle" value="<?php echo $vehicle; ?>">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="tel" name="contact" placeholder="Contact Number" required>
                <input type="text" name="pickup" placeholder="Pickup Location" required>
                <input type="text" name="dropoff" placeholder="Drop Location" required>
                <input type="date" name="booking_date" required>
                <input type="number" name="seats" min="1" placeholder="Passengers / Seats" required>
                <button type="submit">Confirm Booking</button>
            </form>
            <a href="vehical.html"><button class="print-btn">Back</button></a>
        </section>
    </div>
</body>

</html>