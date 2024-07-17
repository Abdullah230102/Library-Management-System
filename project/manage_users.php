<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $action = $_POST['action'];

    if ($action == 'Add User') {
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            echo "User added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif ($action == 'Edit User') {
        
    } elseif ($action == 'Remove User') {
       
    }
}
header("location: admin_dashboard.php");
?>
