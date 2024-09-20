<?php
session_start();

// Dummy user data for demonstration purposes (replace this with your database logic)
$users = [
    'user1' => 'password1',
    'user2' => 'password2',
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists and the password matches
    if (array_key_exists($username, $users) && $users[$username] === $password) {
        // Store username in session and redirect to a protected page
        $_SESSION['username'] = $username;
        header('Location: admind.html');
        exit();
    } else {
        // Invalid credentials
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login_container">
        <form action="login.php" method="post">
            <h2>Login</h2>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
            <div class="form-group">
                <a href="forgot_password.html">Forgot password?</a>
            </div>
        </form>
    </div>
</body>
</html>
