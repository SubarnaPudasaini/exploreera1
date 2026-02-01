<?php
include "connect.php";

// Fetch all users ordered by ID
$sql = "SELECT * FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Users — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .btn {
            padding: 5px 12px;
            margin: 2px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
        }

        /* Simple modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
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
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="search">Users Management</div>
                <div class="top-actions">
                    <a class="btn" href="index.php">Back</a>
                </div>
            </header>

            <section class="page">
                <h1 class="page-title">Users</h1>

                <div class="panel animated-panel">
                    <table class="data-table" id="usersTable">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
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
                                    <td class='u-name'>{$row['name']}</td>
                                    <td class='u-email'>{$row['email']}</td>
                                    <td>{$row['password']}</td>
                                    <td>
                                        <button class='btn btn-edit' data-id='{$row['id']}'>Edit</button>
                                        <button class='btn btn-danger btn-delete' data-id='{$row['id']}'>Delete</button>
                                    </td>
                                </tr>";
                                    $rank++;
                                }
                            } else {
                                echo "<tr><td colspan='6' class='no-data'>No users found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-box">
            <h3>Edit User</h3>
            <form id="editForm">
                <input type="hidden" name="id" id="edit-id">
                <label>Name</label>
                <input type="text" name="name" id="edit-name" required>
                <label>Email</label>
                <input type="email" name="email" id="edit-email" required>
                <div class="modal-actions">
                    <button type="submit" class="btn">Save</button>
                    <button type="button" class="btn btn-danger" id="cancelEdit">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ----- DELETE USER -----
        document.querySelectorAll(".btn-delete").forEach(btn => {
            btn.addEventListener("click", function() {
                const id = btn.getAttribute("data-id");
                if (confirm("Are you sure you want to delete this user permanently?")) {
                    const fd = new FormData();
                    fd.append("id", id);

                    fetch("delete_user.php", {
                            method: "POST",
                            body: fd
                        })
                        .then(res => res.text())
                        .then(res => {
                            if (res.trim() === "success") {
                                const row = btn.closest("tr");
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

        // ----- UPDATE RANKS -----
        function updateRanks() {
            const rows = document.querySelectorAll("#usersTable tbody tr");
            if (rows.length === 0) {
                document.querySelector("#usersTable tbody").innerHTML = "<tr><td colspan='6' class='no-data'>No users found</td></tr>";
            } else {
                rows.forEach((r, i) => {
                    r.querySelector(".rank").innerText = i + 1;
                });
            }
        }

        // ----- EDIT USER (optional, can connect to update_user.php) -----
        const modal = document.getElementById("editModal");
        const editForm = document.getElementById("editForm");
        document.querySelectorAll(".btn-edit").forEach(btn => {
            btn.addEventListener("click", function() {
                const row = btn.closest("tr");
                modal.style.display = "flex";
                document.getElementById("edit-id").value = row.dataset.id;
                document.getElementById("edit-name").value = row.querySelector(".u-name").innerText;
                document.getElementById("edit-email").value = row.querySelector(".u-email").innerText;
            });
        });
        document.getElementById("cancelEdit").addEventListener("click", () => modal.style.display = "none");
    </script>
</body>

</html>