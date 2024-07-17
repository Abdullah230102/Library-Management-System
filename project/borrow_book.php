<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']))
 {
    header("location: user_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
    $user_id = $_SESSION['user_id'];
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    
    $due_date = date('Y-m-d H:i:s', strtotime('+14 days'));


    $borrow_query = "INSERT INTO borrowed_books (user_id, book_id, due_date) VALUES ('$user_id', '$book_id', '$due_date')";
    if (mysqli_query($conn, $borrow_query))
     {
   
        $update_query = "UPDATE books SET availability = 'checked_out' WHERE id = '$book_id'";
        if (mysqli_query($conn, $update_query)) 
        {
            echo "Book borrowed successfully!";
        } 
        else 
        {
            echo "Error updating book availability: " . mysqli_error($conn);
        }
    } 
    else 
    {
        echo "Error borrowing book: " . mysqli_error($conn);
    }
}
header("location: user_dashboard.php");
?>
