<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    
    $delete_user_query = "DELETE FROM users WHERE id = '$user_id'";
    if (mysqli_query($conn, $delete_user_query)) {
        echo "User removed successfully!";
    } else {
        echo "Error removing user: " . mysqli_error($conn);
    }
    header("location: admin_dashboard.php");
    exit();
}
?>
