<?php
include 'db.php'; // Include your database connection file
session_start();

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    // Retrieve user_id associated with the token from the database
    $query = "SELECT user_id FROM password_resets WHERE token = '$token' AND created_at >= NOW() - INTERVAL 1 HOUR";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Process password update if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

            if ($password === $confirm_password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";

                if (mysqli_query($conn, $update_query)) {
                    // Remove the token from password_resets table after password reset
                    $delete_query = "DELETE FROM password_resets WHERE user_id = '$user_id'";
                    mysqli_query($conn, $delete_query);

                    echo "Password reset successfully. <a href='user_login.html'>Login now</a>";
                    exit();
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            } else {
                echo "Passwords do not match.";
            }
        }
    } else {
        echo "Invalid or expired token. Please request a new password reset.";
    }
} else {
    echo "Token not provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="" method="post">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <input type="submit" value="Reset Password">
        </form>
        <p>Remember your password? <a href="user_login.html">Log in here</a>.</p>
    </div>
</body>
</html>
