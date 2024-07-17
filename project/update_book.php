<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $publication_year = mysqli_real_escape_string($conn, $_POST['publication_year']);
    
    $query = "UPDATE books SET title='$title', author='$author', genre='$genre', publication_year='$publication_year' WHERE id='$book_id'";
    
    if (mysqli_query($conn, $query)) {
        echo "Book updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
header("location: admin_dashboard.php");
?>
