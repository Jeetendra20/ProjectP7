<?php
session_start();
include "db.php";


if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = mysqli_query($conn, "SELECT id, username, email, firstname, lastname, profile_pic FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body{
        height: 135vh;
    }
        .container { max-width: 900px; width: 95%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; color: #764ba2; }
        .avatar-sm { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .btn-action { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.8rem; color: #fff; margin-right: 5px; }
        .btn-view { background: #3498db; }
        .btn-edit { background: #f1c40f; }
        .btn-delete { background: #e74c3c; }
        .btn-action:hover { opacity: 0.8; }
    </style>
</head>
<body>
<div class="container">
    <h2>User Management</h2>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><img src=" uploads\<?php echo  $row['profile_pic']; ?>" class="avatar-sm"></td>
                <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                <td>@<?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="view_user.php?id=<?php echo $row['id']; ?>" class="btn-action btn-view">Show</a>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">Edit</a>
                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
                       class="btn-action btn-delete" 
                       onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <a href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>



