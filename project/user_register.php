<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
    if (mysqli_query($conn, $query)) {
        echo "User registered successfully!";
        header("location: user_login.html"); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
