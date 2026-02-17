<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo ucwords($user['username']); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>

        .profile-info {
            text-align: left;
            margin-top: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #666;
        }
        .value {
            color: #333;
        }
        .logout-btn {
            display: inline-block;
            width: 100%;
            text-align: center;
            background: #ff4b2b; /* Distinct color for logout */
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            margin-top: 30px;
            padding: 12px;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        .logout-btn:hover {
            opacity: 0.9;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div style="text-align: center;">
        <div style="font-size: 50px; margin-bottom: 10px;">👤</div>
        <div style="text-align: center;">
     <img src="uploads/<?php echo $user['profile_pic']; ?>" 
         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #764ba2;">
    <h2>Welcome, <?php echo ucwords($user['firstname']); ?>!</h2>
</div>
        <p style="color: #888;">Manage your profile details below.</p>
    </div>

    <div class="profile-info">
        <div class="info-row">
            <span class="label">Username</span>
            <span class="value">@<?php echo $user['username']; ?></span>
        </div>
        <div class="info-row">
            <span class="label">Full Name</span>
            <span class="value"><?php echo ucwords($user['firstname'] . " " . $user['lastname']); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Email</span>
            <span class="value"><?php echo $user['email']; ?></span>
        </div>
        <div class="info-row">
            <span class="label">Birthday</span>
            <span class="value"><?php echo date("M d, Y", strtotime($user['dob'])); ?></span>
        </div>
        <a href="users.php"><h1>Show all</h1></a>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>