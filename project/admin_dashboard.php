<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

$book_count_query = "SELECT COUNT(*) AS total_books FROM books";
$book_count_result = mysqli_query($conn, $book_count_query);
$total_books = mysqli_fetch_assoc($book_count_result)['total_books'];

$user_count_query = "SELECT COUNT(*) AS total_users FROM users";
$user_count_result = mysqli_query($conn, $user_count_query);
$total_users = mysqli_fetch_assoc($user_count_result)['total_users'];

$overdue_count_query = "SELECT COUNT(*) AS overdue_books FROM borrowed_books WHERE due_date < NOW()";
$overdue_count_result = mysqli_query($conn, $overdue_count_query);
$overdue_books = mysqli_fetch_assoc($overdue_count_result)['overdue_books'];

$genres_query = "SELECT DISTINCT genre FROM books";
$genres_result = mysqli_query($conn, $genres_query);

$users_query = "SELECT * FROM users";
$users_result = mysqli_query($conn, $users_query);


$checked_out_books_query = "SELECT * FROM books WHERE availability = 'checked_out'";
$checked_out_books_result = mysqli_query($conn, $checked_out_books_query);

echo "<div class='container'>";
echo "<h1>Welcome to the Admin Dashboard, " . $_SESSION['admin_user'] . "</h1>";
echo "<h2>Quick Stats</h2>";
echo "<div class='stats'>";
echo "<div class='stat-item'><p>Total Books: $total_books</p></div>";
echo "<div class='stat-item'><p>Total Users: $total_users</p></div>";
echo "<div class='stat-item'><p>Overdue Books: $overdue_books</p></div>";
echo "</div>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Manage Books</h2>
        <form action="manage_books.php" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Title" required>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" placeholder="Author" required>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" placeholder="Genre" required>
            <label for="publication_year">Publication Year:</label>
            <input type="number" id="publication_year" name="publication_year" placeholder="Publication Year">
            <input type="submit" name="action" value="Add Book">
        </form>

        <h2>Books by Genre</h2>
        <div class="genre-section">
        <?php
        while ($genre = mysqli_fetch_assoc($genres_result)) 
        {
            echo "<h3>" . $genre['genre'] . "</h3>";

            $genre_books_query = "SELECT * FROM books WHERE genre = '" . $genre['genre'] . "'";
            $genre_books_result = mysqli_query($conn, $genre_books_query);

            echo "<table>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publication Year</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>";
            while ($book = mysqli_fetch_assoc($genre_books_result)) 
            {
                echo "<tr>
                        <td>" . $book['title'] . "</td>
                        <td>" . $book['author'] . "</td>
                        <td>" . $book['publication_year'] . "</td>
                        <td>" . $book['availability'] . "</td>
                        <td>
                            <form action='edit_book.php' method='post' style='display:inline;'>
                                <input type='hidden' name='book_id' value='" . $book['id'] . "'>
                                <input type='submit' value='Edit'>
                            </form>
                            <form action='delete_book.php' method='post' style='display:inline;'>
                                <input type='hidden' name='book_id' value='" . $book['id'] . "'>
                                <input type='submit' value='Delete'>
                            </form>
                        </td>
                      </tr>";
            }
            echo "</table>";
        }
        ?>
        </div>

        <h2>Manage Users</h2>
        <form action="manage_users.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="submit" name="action" value="Add User">
        </form>

        <h2>Existing Users</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php
            while ($user = mysqli_fetch_assoc($users_result)) 
            {
                echo "<tr>
                        <td>" . $user['name'] . "</td>
                        <td>" . $user['email'] . "</td>
                        <td>
                            <form action='edit_user.php' method='post' style='display:inline;'>
                                <input type='hidden' name='user_id' value='" . $user['id'] . "'>
                                <input type='submit' value='Edit'>
                            </form>
                            <form action='remove_user.php' method='post' style='display:inline;'>
                                <input type='hidden' name='user_id' value='" . $user['id'] . "'>
                                <input type='submit' value='Remove'>
                            </form>
                            <button onclick='endSubscription(" . $user['id'] . ")'>End Subscription</button>
                        </td>
                      </tr>";
            }
            ?>
        </table>

        <h2>Checked-Out Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Publication Year</th>
                <th>Action</th>
            </tr>
            <?php
            while ($book = mysqli_fetch_assoc($checked_out_books_result))
             {
                echo "<tr>
                        <td>" . $book['title'] . "</td>
                        <td>" . $book['author'] . "</td>
                        <td>" . $book['publication_year'] . "</td>
                        <td>
                            <form action='mark_available.php' method='post' style='display:inline;'>
                                <input type='hidden' name='book_id' value='" . $book['id'] . "'>
                                <input type='submit' value='Mark as Available'>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </table>

        <h2>Generate Reports</h2>
        <form action="generate_report.php" method="post">
            <input type="submit" name="action" value="Generate Report">
        </form>

        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <script>
    function endSubscription(userId)
     {
        fetch('end_subscription.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
</body>
</html>
