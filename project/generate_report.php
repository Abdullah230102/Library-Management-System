<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "Generate Report") {
      
        $report_query = "SELECT genre, COUNT(*) AS total FROM books GROUP BY genre";
        $report_result = mysqli_query($conn, $report_query);

        echo "<div class='container'>";
        echo "<h2>Books by Genre</h2>";
        echo "<table>";
        echo "<tr><th>Genre</th><th>Total Books</th></tr>";
        while ($row = mysqli_fetch_assoc($report_result)) {
            echo "<tr><td>" . $row['genre'] . "</td><td>" . $row['total'] . "</td></tr>";
        }
        echo "</table>";
        echo "</div>";
    }
}
?>
<button onclick="window.location.href='admin_dashboard.php'">Back</button>
