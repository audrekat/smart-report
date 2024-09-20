<!-- <?php
// Start the session to track login state
session_start();

// Hardcoded username and password for demonstration purposes
$valid_username = 'user';
$valid_password = 'password';

// Function to sanitize user input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve user input
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    
    // Validate the credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Set session variable and redirect to a protected page
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password.";
    }
} else {
    $error_message = "Invalid request method.";
}
?>

<?php if (isset($error_message)): ?>
    <p><?php echo $error_message; ?></p>
<?php endif; ?>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="login-container">
        <h2>Login to Smart Report</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html> -->
@{
newPassword = Request["newPassword"];
confirmPassword = Request["confirmPassword"];
token = Request["token"];
if IsPost
{
    // input testing is ommitted here to save space
    retunValue = ResetPassword(token, newPassword);
}
}
<h1>Change Password</h1>

<form method="post" action="">

<label for="newPassword">New Password:</label>
<input type="password" id="newPassword" name="newPassword" title="New password" />

<label for="confirmPassword">Confirm Password:</label>
<input type="password" id="confirmPassword" name="confirmPassword" title="Confirm new password" />

<label for="token">Pasword Token:</label>
<input type="text" id="token" name="token" title="Password Token" />

<p class="form-actions">
<input type="submit" value="Change Password" title="Change password" />
</p>

</form>
