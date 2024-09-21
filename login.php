<?php
session_start();

// Database connection details
$host = 'localhost';
$dbname = 'userslogin';
$username = 'root'; // Change if necessary
$password = ''; // Change if necessary

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
/*
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];

    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE email = :email"; // Assuming you're using email
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $input_email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password
        if (password_verify($input_password, $user['password'])) {
            // Password is correct
            $_SESSION['username'] = $user['email']; // or $user['username'] if you prefer
            header("Location: admind.html"); // Redirect to a dashboard or home page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }
}
    */
?>
