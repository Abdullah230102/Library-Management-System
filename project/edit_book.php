<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    
   
    $query = "SELECT * FROM books WHERE id = '$book_id'";
    $result = mysqli_query($conn, $query);
    $book = mysqli_fetch_assoc($result);
    
    if ($book) {
       
        echo "<div class='container'>";
        echo "<h2>Edit Book</h2>";
        echo "<form action='update_book.php' method='post'>";
        echo "<input type='hidden' name='book_id' value='" . $book['id'] . "'>";
        echo "<label for='title'>Title:</label>";
        echo "<input type='text' id='title' name='title' value='" . $book['title'] . "' required>";
        echo "<label for='author'>Author:</label>";
        echo "<input type='text' id='author' name='author' value='" . $book['author'] . "' required>";
        echo "<label for='genre'>Genre:</label>";
        echo "<input type='text' id='genre' name='genre' value='" . $book['genre'] . "' required>";
        echo "<label for='publication_year'>Publication Year:</label>";
        echo "<input type='number' id='publication_year' name='publication_year' value='" . $book['publication_year'] . "'>";
        echo "<input type='submit' name='action' value='Update Book'>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "Book not found.";
    }
}
?>
<button onclick="window.location.href='admin_dashboard.php'">Back</button>
