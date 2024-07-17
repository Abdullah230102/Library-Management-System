<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    $query = "SELECT id, name FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo "<div class='container'>";
        echo "<h2>User Details</h2>";
        echo "<p>User ID: " . $user['id'] . "</p>";
        echo "<p>User Name: " . $user['name'] . "</p>";
        echo "</div>";
    } else {
        echo "<div class='container'>";
        echo "<p>No user found with ID: $user_id</p>";
        echo "</div>";
    }
}
?>
<button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
