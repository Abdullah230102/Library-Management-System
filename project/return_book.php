<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: user_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrowed_book_id = mysqli_real_escape_string($conn, $_POST['borrowed_book_id']);

    $query = "SELECT book_id FROM borrowed_books WHERE id = '$borrowed_book_id' AND user_id = '{$_SESSION['user_id']}'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $book_id = $row['book_id'];
        
        // Remove from borrowed_books
        $delete_query = "DELETE FROM borrowed_books WHERE id = '$borrowed_book_id'";
        mysqli_query($conn, $delete_query);

        // Update book availability
        $update_query = "UPDATE books SET availability = 'available' WHERE id = '$book_id'";
        mysqli_query($conn, $update_query);

        header("location: user_dashboard.php");
        exit();
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request.";
}
?>
