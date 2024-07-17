<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT id, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        header("location: user_dashboard.php");
        exit();
    } else {
        echo "Your Email or Password is invalid";
    }
}
?>