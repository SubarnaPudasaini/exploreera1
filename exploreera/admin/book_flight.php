<?php
include "connect.php";

// Fetch all bookings ordered by ID
$sql = "SELECT * FROM flight_bookings ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Bookings — Admin</title>
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

        .btn-accept {
            background-color: #4CAF50;
            color: white;
        }

        .btn-decline {
            background-color: #f44336;
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
                <a href="index.php">Dashboard</a>
                <a href="bookings.php" class="active">Bookings</a>
                <a href="admin_profile.php">Profile</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="search">Bookings Management</div>
                <div class="top-actions">
                    <a class="btn" href="index.php">Back</a>
                </div>
            </header>

            <section class="page">
                <h1 class="page-title">All Bookings</h1>

                <div class="panel animated-panel">
                    <table class="data-table" id="bookingsTable">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Date</th>
                                <th>Passengers</th>
                                <th>Status</th>
                                <th style="width:160px;">Actions</th>
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
            <td>{$row['from_location']}</td>
            <td>{$row['to_location']}</td>
            <td>{$row['journey_date']}</td>
            <td>{$row['passengers']}</td>
            <td class='status'>{$row['status']}</td>
            <td>
                <form class='action-form' style='display:inline-block;'>
                    <input type='hidden' name='booking_id' value='{$row['id']}'>
                    <button type='submit' name='action' value='accept' class='btn-action btn-accept'>✅</button>
                </form>
                <form class='action-form' style='display:inline-block;'>
                    <input type='hidden' name='booking_id' value='{$row['id']}'>
                    <button type='submit' name='action' value='decline' class='btn-action btn-decline'>❌</button>
                </form>
            </td>
        </tr>";
                                    $rank++;
                                }
                            } else {
                                echo "<tr><td colspan='8' class='no-data'>No bookings found</td></tr>";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        // ----- AJAX for Accept/Decline -----
        document.querySelectorAll(".action-form").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const bookingId = form.querySelector("input[name='booking_id']").value;
                const action = form.querySelector("button").value;
                const fd = new FormData();
                fd.append("booking_id", bookingId);
                fd.append("action", action);

                fetch("update_booking.php", {
                        method: "POST",
                        body: fd
                    })
                    .then(res => res.text())
                    .then(() => {
                        const row = form.closest("tr");
                        if (action === "accept") {
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

                            // Re-rank remaining rows
                            const rows = document.querySelectorAll("#bookingsTable tbody tr");
                            if (rows.length === 0) {
                                document.querySelector("#bookingsTable tbody").innerHTML = "<tr><td colspan='8' class='no-data'>No bookings found</td></tr>";
                            } else {
                                rows.forEach((r, i) => {
                                    const rankCell = r.querySelector(".rank");
                                    if (rankCell) rankCell.innerText = i + 1;
                                });
                            }
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Request failed. Check console.");
                    });
            });
        });
    </script>
</body>

</html>