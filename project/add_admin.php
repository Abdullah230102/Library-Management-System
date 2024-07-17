<?php
include 'db.php';

$username = 'admin'; 
$password = 'admin123'; 

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$check_query = "SELECT * FROM admins WHERE username = '$username'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0)
 {
    
    $query = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')";
    if (mysqli_query($conn, $query)) 
    {
        echo "Admin user created successfully!";
    } 
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
} 
else 
{
    echo "Admin user already exists.";
}
?>
