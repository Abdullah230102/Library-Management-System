<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: user_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $borrowed_book_id = mysqli_real_escape_string($conn, $_POST['borrowed_book_id']);
    $renew_days = (int)$_POST['renew_days'];
    
 
    $renew_query = "UPDATE borrowed_books SET due_date = DATE_ADD(due_date, INTERVAL $renew_days DAY) WHERE id = '$borrowed_book_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $renew_query)) {
        echo "Book renewed successfully!";
    } else {
        echo "Error renewing book: " . mysqli_error($conn);
    }
}
header("location: user_dashboard.php");
?>
