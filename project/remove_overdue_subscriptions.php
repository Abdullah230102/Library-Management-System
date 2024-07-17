<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}


$overdue_query = "SELECT borrowed_books.id, borrowed_books.book_id, borrowed_books.user_id 
                  FROM borrowed_books 
                  WHERE due_date < NOW()";
$overdue_result = mysqli_query($conn, $overdue_query);

while ($overdue = mysqli_fetch_assoc($overdue_result)) {
    $borrowed_book_id = $overdue['id'];
    $book_id = $overdue['book_id'];

   
    $delete_query = "DELETE FROM borrowed_books WHERE id='$borrowed_book_id'";
    mysqli_query($conn, $delete_query);

   
    $update_query = "UPDATE books SET availability='available' WHERE id='$book_id'";
    mysqli_query($conn, $update_query);
}

header("location: admin_dashboard.php");
exit();
?>
