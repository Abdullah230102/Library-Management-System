<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    
    $end_subscription_query = "UPDATE users SET subscription_status = 'ended' WHERE id = '$user_id'";
    if (mysqli_query($conn, $end_subscription_query)) {
        $user_query = "SELECT email FROM users WHERE id = '$user_id'";
        $user_result = mysqli_query($conn, $user_query);
        $user = mysqli_fetch_assoc($user_result);
        $user_email = $user['email'];
        mail($user_email, "Subscription Ended", "Your subscription has been ended. Thank you for using our library services.");

        echo "Subscription ended and notification sent!";
    } else {
        echo "Error ending subscription: " . mysqli_error($conn);
    }
    header("location: admin_dashboard.php");
    exit();
}
?>
