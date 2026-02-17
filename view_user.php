<?php
include "db.php";
$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="text-align: center;">
        <img src="uploads\<?php echo $user['profile_pic']; ?>" style="width:120px; height:120px; border-radius:50%; object-fit:cover;">
        <h2><?php echo $user['firstname'] . " " . $user['lastname']; ?></h2>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Username:</strong> @<?php echo $user['username']; ?></p>
        <p><strong>DOB:</strong> <?php echo $user['dob']; ?></p>
        <br>
        <a href="users.php">Back to List</a>
    </div>
</body>
</html>