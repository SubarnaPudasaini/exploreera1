<?php
include "connect.php";

$hotelName = $_GET['hotel'] ?? '';
$hotelName = mysqli_real_escape_string($conn, $hotelName);

$sql = "SELECT * FROM hotels WHERE name='$hotelName'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Hotel not found.";
    exit;
}

$hotel = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $hotel['name'] ?> • Exploreera-hotel-details</title>

    <style>
        :root {
            --primary: #0f4c81;
            --accent: #ff8c1a;
            --bg: #f4f6f9;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: var(--bg);
            color: #333;
        }

        /* ===== Header ===== */
        header {
            background: linear-gradient(135deg, #0f4c81, #1b6cb8);
            color: #fff;
            padding: 28px;
            text-align: center;
        }

        header h2 {
            margin: 0;
            font-size: 30px;
            letter-spacing: 0.5px;
        }

        /* ===== Hero Image ===== */
        .hero {
            position: relative;
            max-height: 420px;
            overflow: hidden;
        }

        .hero img {
            width: 100%;
            height: 420px;
            object-fit: cover;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .55), transparent);
        }

        /* ===== Main Card ===== */
        .container {
            max-width: 1000px;
            margin: -80px auto 40px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .15);
            padding: 30px;
            position: relative;
            z-index: 2;
        }

        /* ===== Title Section ===== */
        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .title-row h3 {
            margin: 0;
            font-size: 26px;
            color: var(--primary);
        }

        .badge {
            background: var(--accent);
            color: #fff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        /* ===== Info Sections ===== */
        .section {
            margin-top: 25px;
        }

        .section h4 {
            margin-bottom: 10px;
            font-size: 18px;
            color: var(--primary);
        }

        .section p {
            line-height: 1.6;
            color: #555;
        }

        /* ===== Amenities ===== */
        .amenities {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .amenities span {
            background: #eef3f8;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 14px;
        }

        /* ===== Price Card ===== */
        .price-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #fff7ed, #fff);
            border: 1px solid #ffe0bd;
            padding: 20px;
            border-radius: 14px;
            margin-top: 30px;
        }

        .price {
            font-size: 26px;
            font-weight: 700;
            color: var(--accent);
        }

        /* ===== Button ===== */
        .btn {
            padding: 14px 32px;
            font-size: 16px;
            background: linear-gradient(135deg, #ff8c1a, #ff6a00);
            color: #fff;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            text-decoration: none;
            transition: .3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 140, 26, .4);
        }

        .btn1 {
            padding: 10px 22px;
            font-size: 16px;
            background: linear-gradient(135deg, #000000ff, #4ecae0ff);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: .3s;
        }

        .btn1:hover {
            transform: translateY(-2px);
            background-color: #f4f6f9;
            color: black;
            box-shadow: 0 10px 25px rgba(255, 140, 26, .4);
        }

        /* ===== Responsive ===== */
        @media(max-width:768px) {
            .price-box {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }
    </style>
</head>

<body>



    <div class="hero">
        <img src="<?= $hotel['image_url'] ?>" alt="<?= $hotel['name'] ?>">
    </div>

    <div class="container">

        <div class="title-row">
            <h3><?= $hotel['name'] ?></h3>
            <span class="badge">Premium Stay</span>
        </div>

        <div class="section">
            <h4>📍 Location</h4>
            <p><?= $hotel['location'] ?></p>
        </div>

        <div class="section">
            <h4>✨ Amenities</h4>
            <div class="amenities">
                <?php foreach (explode(',', $hotel['amenities']) as $a): ?>
                    <span><?= trim($a) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="price-box">
            <div>
                <div class="price">Rs. <?= number_format($hotel['price']) ?> / night</div>
                <small>Taxes may apply</small>
            </div>
            <a href="booking.php?hotel=<?= urlencode($hotel['name']) ?>" class="btn">Book Now</a>
        </div>
        <br><a href="hotel.php?hotel=<?= urlencode($hotel['name']) ?>" class="btn1">← Back</a>

    </div>

</body>

</html>