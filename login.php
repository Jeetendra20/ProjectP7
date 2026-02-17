<?php
session_start();
include "db.php";

$message = ""; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    
    
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($identifier) && !empty($password)) {
        
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$identifier' OR username='$identifier' LIMIT 1");
        
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php");
                exit(); 
            } else {
                $message = "Incorrect password!";
            }
        } else {
            $message = "Account not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <form method="POST" action="login.php">
        <h2>Welcome Back</h2>

        <?php if($message != ""): ?>
            <p style="color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 8px; text-align: center; margin-bottom: 15px; font-size: 0.85rem; border: 1px solid #fecaca;">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <input type="text" name="identifier" placeholder="Email or Username" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" name="login">Sign In</button>

        <p style="text-align:center; margin-top:20px; font-weight:500">
            New here? <a href="signup.php">Create an account</a>
        </p>
    </form>
</div>

</body>
</html>