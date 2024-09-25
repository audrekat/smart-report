<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "report-smart"; 

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

if (!$user) {
    $sql_teacher = "SELECT * FROM teacher WHERE username = '$username'";
    $result_teacher = mysqli_query($conn, $sql_teacher);
    $user = mysqli_fetch_assoc($result_teacher);
}

// If not found in teacher, check the admin table
if (!$user) {
    $sql_admin = "SELECT * FROM admin WHERE username = '$username'";
    $result_admin = mysqli_query($conn, $sql_admin);
    $user = mysqli_fetch_assoc($result_admin);
}

if ($user) {
    // Directly compare plain text passwords
    if (password_verify($password, $user['password']))
    {
        // Password is correct
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];

         // Redirect based on user_type
         switch ($user['user_type']) {
            case 'admin':
                header("Location: admind.html"); // Redirect to admin dashboard
                break;
            case 'teacher':
                header("Location: teacherdashboard.php"); // Redirect teacher dashboard
                break;
            case 'parent':
                header("Location: parentdashboard.php"); // Redirect to parent dashboard
                break;}
        // header("Location: parentdashboard.php "); // Redirect to the dashboard
        // exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username.";
}

$conn->close();
?>
