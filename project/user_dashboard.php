<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);


$borrowed_books_query = "
    SELECT books.title, books.author, borrowed_books.due_date, borrowed_books.id AS borrowed_book_id
    FROM borrowed_books
    JOIN books ON borrowed_books.book_id = books.id
    WHERE borrowed_books.user_id = '$user_id'";
$borrowed_books_result = mysqli_query($conn, $borrowed_books_query);


$available_books_query = "SELECT * FROM books WHERE availability = 'available'";
$available_books_result = mysqli_query($conn, $available_books_query);


$history_query = "SELECT book_id FROM user_history WHERE user_id = '$user_id'";
$history_result = mysqli_query($conn, $history_query);

$book_ids = [];
while ($row = mysqli_fetch_assoc($history_result)) {
    $book_ids[] = $row['book_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Welcome, <?php echo $user['name']; ?></h1>

    <h2>Borrow a Book</h2>
    <form action="borrow_book.php" method="post">
        <label for="book_id">Select a Book:</label>
        <select id="book_id" name="book_id" required>
            <?php
            while ($book = mysqli_fetch_assoc($available_books_result)) {
                echo "<option value='{$book['id']}'>{$book['title']} by {$book['author']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Borrow Book">
    </form>

    <h2>Your Borrowed Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Due Date</th>
            <th>Renew</th>
            <th>Return</th>
        </tr>
        <?php
        while ($book = mysqli_fetch_assoc($borrowed_books_result)) {
            echo "<tr>
                    <td>{$book['title']}</td>
                    <td>{$book['author']}</td>
                    <td>{$book['due_date']}</td>
                    <td>
                        <form action='renew_book.php' method='post'>
                            <input type='hidden' name='borrowed_book_id' value='{$book['borrowed_book_id']}'>
                            <input type='number' name='renew_days' min='1' placeholder='Days' required>
                            <input type='submit' value='Renew'>
                        </form>
                    </td>
                    <td>
                        <form action='return_book.php' method='post'>
                            <input type='hidden' name='borrowed_book_id' value='{$book['borrowed_book_id']}'>
                            <input type='submit' value='Return'>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <h2>Recommended Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
        </tr>
        <?php
        if (!empty($book_ids)) {
            $book_ids_str = implode(",", $book_ids);
            $recommend_query = "SELECT * FROM books WHERE id NOT IN ($book_ids_str) LIMIT 5";
            $recommend_result = mysqli_query($conn, $recommend_query);

            while ($recommend = mysqli_fetch_assoc($recommend_result)) {
                echo "<tr>
                        <td>{$recommend['title']}</td>
                        <td>{$recommend['author']}</td>
                      </tr>";
            }
        } else {
            echo "<tr>
                    <td colspan='2'>No recommendations available.</td>
                  </tr>";
        }
        ?>
    </table>

    <button onclick="window.location.href='user_logout.php'">Logout</button>
</div>
</body>
</html>
