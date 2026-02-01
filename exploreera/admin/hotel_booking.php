<?php
include "connect.php";

// Fetch all hotel bookings ordered by ID
$sql = "SELECT * FROM hotel_bookings ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Hotel Bookings — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-action {
            font-size: 16px;
            padding: 5px 12px;
            margin: 2px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-confirm {
            background-color: #4CAF50;
            color: white;
        }

        .btn-cancel {
            background-color: #f44336;
            color: white;
        }

        .btn-delete {
            background-color: #ff9800;
            color: white;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="brand">ExploreEra Admin</div>
            <nav>
                <a href="index.php" class="active">Dashboard</a>
                <a href="users.php">Users</a>
                <a href="admin_profile.php">Profile</a>
                <a href="bookings.php">Flight</a>
                <a href="admin_vehicalbooking.php">Vehical</a>
                <a href="hotel_booking.php">Hotel or Restaurent</a>

                <!-- future links -->
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="search">Hotel Bookings Management</div>
                <div class="top-actions">
                    <a class="btn" href="index.php">Back</a>
                </div>
            </header>

            <section class="page">
                <h1 class="page-title">All Hotel Bookings</h1>

                <div class="panel animated-panel">
                    <table class="data-table" id="hotelBookingsTable">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>ID</th>
                                <th>Guest Name</th>
                                <th>Journey Date</th>

                                <th>Rooms</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th style="width:200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rank = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr data-id='{$row['id']}'>
                                        <td class='rank'>{$rank}</td>
                                        <td>{$row['id']}</td>
                                        <td>{$row['guest_name']}</td>
                                        <td>{$row['journey_date']}</td>
                                 
                                        <td>{$row['rooms']}</td>
                                        <td>{$row['days']}</td>
                                        <td class='status'>{$row['status']}</td>
                                        <td>
                                            <form class='status-form' style='display:inline-block;'>
                                                <input type='hidden' name='booking_id' value='{$row['id']}'>
                                                <button type='submit' name='action' value='confirm' class='btn-action btn-confirm'>✅</button>
                                                
                                            </form>
                                            <form class='delete-form' style='display:inline-block;'>
                                                <input type='hidden' name='booking_id' value='{$row['id']}'>
                                                <button type='submit' class='btn-action btn-delete'>🗑️</button>
                                            </form>
                                        </td>
                                    </tr>";
                                    $rank++;
                                }
                            } else {
                                echo "<tr><td colspan='9' class='no-data'>No hotel bookings found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        // ----- AJAX for Confirm/Cancel -----
        document.querySelectorAll(".status-form").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const bookingId = form.querySelector("input[name='booking_id']").value;
                const action = form.querySelector("button[name='action']:focus").value;
                const fd = new FormData();
                fd.append("booking_id", bookingId);
                fd.append("action", action);

                fetch("update_hotel_booking.php", {
                        method: "POST",
                        body: fd
                    })
                    .then(res => res.text())
                    .then(() => {
                        const row = form.closest("tr");
                        if (action === "confirm") {
                            row.querySelector(".status").innerText = "confirmed";
                            row.animate([{
                                background: "#baf2c7"
                            }, {
                                background: ""
                            }], {
                                duration: 900
                            });
                        } else {
                            row.querySelector(".status").innerText = "cancelled";
                            row.animate([{
                                    opacity: 1,
                                    transform: "translateX(0)"
                                }, {
                                    opacity: 0,
                                    transform: "translateX(40px)"
                                }], {
                                    duration: 400
                                })
                                .onfinish = () => row.remove();
                            updateRanks();
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Request failed. Check console.");
                    });
            });
        });

        // ----- AJAX for Delete -----
        document.querySelectorAll(".delete-form").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const bookingId = form.querySelector("input[name='booking_id']").value;
                if (confirm("Are you sure you want to delete this booking permanently?")) {
                    const fd = new FormData();
                    fd.append("booking_id", bookingId);

                    fetch("delete__hotel_booking.php", {
                            method: "POST",
                            body: fd
                        })
                        .then(res => res.text())
                        .then(res => {
                            if (res === "success") {
                                const row = form.closest("tr");
                                row.remove();
                                updateRanks();
                            } else {
                                alert("Failed to delete from database");
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert("Request failed");
                        });
                }
            });
        });

        // ----- Update rank numbers after row removal -----
        function updateRanks() {
            const rows = document.querySelectorAll("#hotelBookingsTable tbody tr");
            if (rows.length === 0) {
                document.querySelector("#hotelBookingsTable tbody").innerHTML = "<tr><td colspan='9' class='no-data'>No hotel bookings found</td></tr>";
            } else {
                rows.forEach((r, i) => {
                    const rankCell = r.querySelector(".rank");
                    if (rankCell) rankCell.innerText = i + 1;
                });
            }
        }
    </script>
</body>

</html>