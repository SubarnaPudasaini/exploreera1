<?php
include "connect.php";

// Fetch all vehiccal bookings ordered by ID
$sql = "SELECT * FROM vehiccal_bookings ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vehiccal Bookings — Admin</title>
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
            <h1 class="page-title">All Vehiccal Bookings</h1>

            <table class="data-table" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>ID</th>
                        <th>Vehicle</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th style="width:200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status = isset($row['status']) ? $row['status'] : 'pending';
                            echo "<tr data-id='{$row['id']}'>
                                <td class='rank'>{$rank}</td>
                                <td>{$row['id']}</td>
                                <td>{$row['vehicle']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['contact']}</td>
                                <td class='status'>{$status}</td>
                                <td>
                                    <form class='status-form' style='display:inline-block;'>
                                        <input type='hidden' name='booking_id' value='{$row['id']}'>
                                        <button type='submit' name='action' value='accept' class='btn-action btn-accept'>✅</button>
                                        <button type='submit' name='action' value='declinee' class='btn-action btn-decline'>❌</button>
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
                        echo "<tr><td colspan='7' class='no-data'>No bookings found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <script>
        // ----- AJAX for Accept/Decline -----
        document.querySelectorAll(".status-form").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const bookingId = form.querySelector("input[name='booking_id']").value;
                const action = form.querySelector("button[name='action']:focus").value;
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
                        }
                        if (action === "declinee") {
                            row.querySelector(".status").innerText = "Decline";
                            row.animate([{
                                background: "#baf2c7"
                            }, {
                                background: ""
                            }], {
                                duration: 900
                            });
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

                    fetch("delete_vehiccal_booking.php", {
                            method: "POST",
                            body: fd
                        })
                        .then(res => res.text())
                        .then(res => {
                            console.log("Server response:", res);
                            if (res.trim() === "success") {
                                const row = form.closest("tr");
                                row.remove();
                                updateRanks();
                            } else {
                                alert("Failed to delete: " + res);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert("Request failed");
                        });
                }
            });
        });

        // ----- Update rank numbers -----
        function updateRanks() {
            const rows = document.querySelectorAll("#bookingsTable tbody tr");
            if (rows.length === 0) {
                document.querySelector("#bookingsTable tbody").innerHTML = "<tr><td colspan='7' class='no-data'>No bookings found</td></tr>";
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