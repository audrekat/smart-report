<?php
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

    echo("post");
    // Sanitize and retrieve user input
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    
    // Validate the credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Set session variable and redirect to a protected page
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: admind.php');
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password.";
    }
} else {
    $error_message = "Invalid request method.";
}
// ?>

<?php if (isset($error_message)): ?>
    <p><?php echo $error_message; ?></p>
<?php endif; ?>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.7);
            max-width: 300px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: yellow;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        
    </div>
</body>
</html> 

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

</form> -->
