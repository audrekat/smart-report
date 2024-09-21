<?php
// Database connection settings
$host = 'localhost'; // Database host (usually localhost)
$db = 'userslogin'; // Name of your database
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password (leave blank if none)

// PDO connection string
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set error handling mode to Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // In case of a connection error
    die("Error! Could not connect to the database. " . $e->getMessage());
}
?>
