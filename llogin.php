<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "smart_report"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password']; // User input

// SQL query to check user credentials
$sql = "SELECT * FROM parent WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Debugging line to check user data
var_dump($user); // Check the user fetched from DB

if ($user) {
    // Directly compare plain text passwords
    if (password_verify($password, $user['password']))
    {
        // Password is correct
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: admind.html"); // Redirect to the dashboard
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username.";
}

$conn->close();
?>
