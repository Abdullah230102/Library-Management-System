<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user']))
 {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    
    $query = "DELETE FROM books WHERE id='$book_id'";
    
    if (mysqli_query($conn, $query)) 
    {
        echo "Book deleted successfully!";
    } 
    else 
    {
        echo "Error: " . mysqli_error($conn);
    }
}
header("location: admin_dashboard.php");
?>
