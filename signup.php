<?php
include "db.php";

$message = "";

if(isset($_POST['signup'])) {

    $username  = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $dob       = $_POST['dob'];
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if($password !== $confirm){
        $message = "Passwords do not match!";
    } elseif(strlen($password) < 6){
        $message = "Password must be at least 6 characters!";
    } else {

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $message = "Email already exists!";
        } else {
            $profile_name = "default.png"; 
            if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $target_dir = "uploads/";                
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $file_ext = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
                $profile_name = "user_" . time() . "." . $file_ext;
                $target_file = $target_dir . $profile_name;

                move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO users (username, firstname, lastname, dob, profile_pic, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $insert->bind_param("sssssss", $username, $firstname, $lastname, $dob, $profile_name, $email, $hashed_password);
 
            if($insert->execute()){
                header("Location: login.php?signup=success");
                exit(); 
            } else {
                $message = "Something went wrong during registration!";
            }
            $insert->close();
        }
        $stmt->close();
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <h2>Sign Up</h2>

        <?php if($message != "") echo "<p style='color:red; text-align:center;'>$message</p>"; ?>

        <div class="dd">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
        </div>

        <label style="font-size: 0.8rem; color: #666; margin-left: 5px;">Date of Birth</label>
        <input type="date" name="dob" required>
        
        <label style="font-size: 0.8rem; color: #666; margin-left: 5px;">Profile Picture</label>
        <input type="file" name="profile_pic" accept="image/*">

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit" name="signup">Register</button>

        <p style="text-align:center; margin-top:15px; font-weight:bolder">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </form>
</div>

</body>
</html>