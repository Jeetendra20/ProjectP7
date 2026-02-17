<?php
include "db.php";
session_start();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if($id == $_SESSION['user_id']) {
        echo "<script>alert('You cannot delete yourself!'); window.location='users.php';</script>";
        exit();
    }

    $delete = mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");

    if($delete) {
        header("Location: users.php?msg=deleted");
    } else {
        echo "Error deleting record.";
    }
}
?>