<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);

 
    $update_query = "UPDATE books SET availability = 'available' WHERE id = '$book_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "Book marked as available successfully!";
    } else {
        echo "Error updating book availability: " . mysqli_error($conn);
    }
}
header("location: admin_dashboard.php");
?>
