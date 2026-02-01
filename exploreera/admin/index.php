<?php
include "connect.php";

// stats
$countUsersQ = "SELECT COUNT(*) as c FROM users";
$r = mysqli_query($conn, $countUsersQ);
$c = mysqli_fetch_assoc($r)['c'] ?? 0;

// recent users
$recentQ = "SELECT id,name,email,created_at FROM users ORDER BY id DESC LIMIT 5";
$recent = mysqli_query($conn, $recentQ);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
            <div class="sidebar-footer">Logged in as: <strong>Admin</strong></div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="search">Welcome back, <strong>Admin</strong></div>
                <div class="top-actions">
                    <button class="icon-btn" title="Notifications">🔔</button>
                    <button class="icon-btn" title="Settings">⚙️</button>
                </div>
            </header>

            <section class="page">
                <h1 class="page-title">Dashboard</h1>

                <div class="cards">
                    <div class="card card-blue">
                        <div class="card-title">Total Users</div>
                        <div class="card-value" id="usersCount"><?= htmlspecialchars($c) ?></div>
                    </div>

                    <div class="card card-green">
                        <div class="card-title">Quick Actions</div>
                        <div class="card-value">
                            <a class="btn" href="users.php">Manage Users</a>
                        </div>
                    </div>

                    <div class="card card-purple">
                        <div class="card-title">Live</div>
                        <div class="card-value">No live alerts</div>
                    </div>
                </div>

                <div class="panel">
                    <h2>Recent users</h2>
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent && mysqli_num_rows($recent) > 0): $i = 1;
                                while ($row = mysqli_fetch_assoc($recent)): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= isset($row['created_at']) ? htmlspecialchars($row['created_at']) : '-' ?></td>
                                    </tr>
                                <?php endwhile;
                            else: ?>
                                <tr>
                                    <td colspan="4">No recent users</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>

    <script src="app.js"></script>
</body>

</html>