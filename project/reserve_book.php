<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    header("location: user_login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);

  
    $check_query = "SELECT * FROM reservations WHERE book_id = '$book_id' AND status = 'reserved'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        $query = "INSERT INTO reservations (user_id, book_id) VALUES ('$user_id', '$book_id')";
        if (mysqli_query($conn, $query)) {
            echo "Book reserved successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "This book is already reserved.";
    }
}
?>
<button onclick="window.location.href='user_dashboard.php'">Back</button>
