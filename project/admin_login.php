<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT id, password FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['admin_user'] = $username;
        header("location: admin_dashboard.php");
        exit();
    } else {
        echo "Your Username or Password is invalid";
    }
}
?>
