<?php
session_start();
include "db.php";

$message = "";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
    $user = mysqli_fetch_assoc($query);

    if (!$user) {
        die("User not found.");
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname  = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    
    if ($_FILES['profile_pic']['name'] != "") {
        $target_dir = "uploads/";
        $file_ext = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
        $profile_path = $target_dir . "user_" . time() . "." . $file_ext;
        $profile_pathy = "user_" . time() . "." . $file_ext;
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_path);
        
        $sql = "UPDATE users SET username='$username', firstname='$firstname', lastname='$lastname', email='$email', profile_pic='$profile_pathy' WHERE id='$id'";
    } else {
        $sql = "UPDATE users SET username='$username', firstname='$firstname', lastname='$lastname', email='$email' WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: users.php?msg=updated");
        exit();
    } else {
        $message = "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <h2>Edit Profile</h2>
        
        <?php if($message != "") echo "<p style='color:red;'>$message</p>"; ?>

        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <div style="text-align:center; margin-bottom: 15px;">
            <img src="uploads\<?php echo $user['profile_pic']; ?>" style="width:80px; height:80px; border-radius:50%; object-fit:cover; border: 2px solid #764ba2;">
            <p style="font-size: 0.8rem; color: #666;">Current Photo</p>
        </div>

        <div class="dd">
            <input type="text" name="username" value="<?php echo $user['username']; ?>" placeholder="Username" required>
            <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" placeholder="First Name" required>
            <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" placeholder="Last Name" required>
        </div>

        <label style="font-size: 0.8rem; color: #666;">Change Profile Picture (Optional)</label>
        <input type="file" name="profile_pic" accept="image/*">

        <input type="email" name="email" value="<?php echo $user['email']; ?>" placeholder="Email" required>

        <button type="submit" name="update">Update User</button>
        
        <p style="text-align:center; margin-top:15px;">
            <a href="users.php">Cancel and Go Back</a>
        </p>
    </form>
</div>

</body>
</html>