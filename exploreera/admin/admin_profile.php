<?php
session_start();
include "connect.php";

// Check if admin is logged in
if (!isset($_SESSION["admin_email"])) {
    header("Location: admin_login.php");
    exit();
}

$admin_email = $_SESSION["admin_email"];

// Fetch admin data
$query = "SELECT * FROM admins WHERE email='$admin_email'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// If not found
if (!$admin) {
    die("Admin not found in database.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Admin Profile — ExploreEarth</title>
    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --accent: #667eea;
            --muted: #6b7280;
            --border: #e6e9ef;
            --radius: 12px;
            font-family: "Poppins", sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: linear-gradient(90deg,
                    rgba(2, 0, 36, 1) 0%,
                    rgba(146, 39, 176, 1) 15%,
                    rgba(9, 9, 121, 1) 45%,
                    rgba(66, 138, 56, 1) 100%,
                    rgba(0, 212, 255, 1) 100%);
            color: #0f172a;
            line-height: 1.4;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(253, 2, 177, 0.08);
            border: solid rgb(0, 98, 255) 8px;
            border-radius: 30px;
            margin-top: 15%;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
            padding: 24px;
            background-color: #d7d6bb;
            display: flex;
            border: solid red 4px;
            gap: 24px;
            align-items: flex-start;
        }

        .left {
            text-align: center;
            width: 260px;
        }

        .avatar-wrap {
            position: relative;
            display: inline-block;
        }

        .avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .change-btn {
            position: absolute;
            right: 0;
            bottom: 0;
            background: var(--accent);
            color: #fff;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            cursor: pointer;
            font-size: 18px;
        }

        .meta {
            margin-top: 12px;
        }

        .username {
            font-size: 20px;
            font-weight: 700;
        }

        .role {
            font-size: 13px;
            color: var(--muted);
        }

        .right {
            flex: 1;
        }

        .right h2 {
            margin: 0 0 12px 0;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field {
            background: #fbfdff;
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 10px;
        }

        .label {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .value {
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .hidden {
            display: none;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
        }

        .btn {
            padding: 10px 14px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
        }

        .btn-danger {
            background: #ef4444;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="left">
                <div class="avatar-wrap">
                    <img id="avatarImg" class="avatar" alt="Profile Photo"
                        src="https://cdn-icons-png.flaticon.com/512/847/847969.png" />
                </div>

                <div class="meta">
                    <div id="displayName" class="username">
                        <?= $admin['name'] ?>
                    </div>
                    <div class="role">Admin • ExploreEarth</div>
                </div>

                <div class="logout-note">
                    Signed in as <span id="displayEmail"><?= $admin['email'] ?></span>
                </div>
            </div>

            <div class="right">
                <h2>Your Profile</h2>

                <form method="POST">
                    <div class="grid">
                        <div class="field">
                            <div class="label">Username</div>
                            <input type="text" name="name" value="<?= $admin['name'] ?>" />
                        </div>

                        <div class="field">
                            <div class="label">Email</div>
                            <input type="email" name="email" value="<?= $admin['email'] ?>" />
                        </div>
                    </div>

                    <div class="actions">
                        <button type="submit" name="save" class="btn btn-primary">Save Changes</button>
                        <a href="index.php" class="btn btn-ghost">Back</a>
                        <a href="admin_login.php" class="btn btn-danger">Log Out</a>
                    </div>
                </form>

                <?php
                if (isset($_POST['save'])) {
                    $newName = $_POST['name'];
                    $newEmail = $_POST['email'];

                    $update = "UPDATE admin SET name='$newName', email='$newEmail' WHERE email='$admin_email'";

                    if (mysqli_query($conn, $update)) {
                        $_SESSION["admin_email"] = $newEmail; // update session
                        echo "<script>alert('Profile updated successfully'); window.location.reload();</script>";
                    } else {
                        echo "<script>alert('Update failed');</script>";
                    }
                }
                ?>

            </div>
        </div>
    </div>

</body>

</html>