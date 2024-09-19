<?php
// Database configuration
$servername = "localhost"; // or your server IP
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "smart_report"; // your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$surname = mysqli_real_escape_string($conn, $_POST['surname']);
$id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
$gender = mysqli_real_escape_string($conn, $_POST['Gender']);
$email = mysqli_real_escape_string($conn, $_POST['Email']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);

// Corrected SQL query
$sql_query = "INSERT INTO `teacher`(`Name`, `surname`, `id_number`, `gender`, `Email`, `contact`)
VALUES ('$name', '$surname', '$id_number', '$gender', '$email', '$contact')";

if ($conn->query($sql_query) === TRUE) {
    echo "New teacher registered successfully";
} else {
    echo "Error: " . $sql_query . "<br>" . $conn->error;
}

$conn->close();
?>
