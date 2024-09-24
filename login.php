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
} 
     else {
    $error_message = "Invalid request method.";
}
?>

<!-- <?php if (isset($error_message)): ?>
    <p><?php echo $error_message; ?></p>
<?php endif; ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css"> 

<style>
    /* Basic reset */
body, h2, form, input, a {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Body styles */
body {
  font-family: Arial, sans-serif;
  background-color: azure;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-image: url(image\ copy.png);
  background-size: cover;
}

/* Container styles */
.container {
  background: skyblue;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.11);
  padding: 20px;
  width: 300px;
  max-width: 100%;
}

/* Header styles */
h2 {
  margin-bottom: 20px;
  font-size: 24px;
  color: #333;
  text-align: center;
}

/* Form group styles */
.form-group {
  margin-bottom: 15px;
}

/* Label styles */
label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  color: #333;
}

/* Input styles */
input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

/* Submit button styles */
input[type="submit"] {
  background-color:green;
  color: #fff;
  border: none;
  padding: 10px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #4cae4c;
}

/* Link styles */
a {
  color: red;
  text-decoration: none;
  font-family: Arial, Helvetica, sans-serif;
}

a:hover {
  text-decoration: underline;
}
/* .logo{
  padding-left: 20px;
} */

</style>

</head>
<body>
    <div class="main">
        <div class="icon">
          <div class="navbar">
            <div class="logo">
              
            </div>

        </div>

    </div>
    


   
    <!-- <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
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
              <a href="forgot password.html">Forgot password?</a>
          </div>
      </form>      
        
    </div> -->
    
</body>
</html> 

