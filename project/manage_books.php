<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $publication_year = mysqli_real_escape_string($conn, $_POST['publication_year']);
    $action = $_POST['action'];

    if ($action == 'Add Book') {
        $query = "INSERT INTO books (title, author, genre, publication_year) VALUES ('$title', '$author', '$genre', '$publication_year')";
        if (mysqli_query($conn, $query)) {
            echo "Book added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif ($action == 'Edit Book') {
        
    } elseif ($action == 'Delete Book') {
       
    }
}
header("location: admin_dashboard.php");
?>
