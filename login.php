<?php
session_start();
include 'db.php'; // Database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Password matches, set session and redirect to dashboard
        $_SESSION['user_id'] = $user['id'];
        header("Location: admind.html");
        exit();
    } else {
        // Invalid credentials
        echo "Invalid email or password.";
    }
}
?>
