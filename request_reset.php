<?php
session_start();
$host = 'localhost';
$db = 'smart_report';
$user = 'your_username';
$pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

    if (empty($username)) {
        $error = "Please enter your username.";
    } else {
        $stmt = $pdo->prepare("SELECT id, email FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate a reset token
            $reset_token = bin2hex(random_bytes(16));
            $token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store token and expiration in the database
            $stmt = $pdo->prepare("UPDATE users SET reset_token = :reset_token, token_expiration = :token_expiration WHERE id = :id");
            $stmt->execute([
                'reset_token' => $reset_token,
                'token_expiration' => $token_expiration,
                'id' => $user['id']
            ]);

            // Send email with reset link
            $reset_link = "http://yourdomain.com/reset_password.php?token=$reset_token";
            // Use mail() function or an email service here
            mail($user['email'], "Password Reset Request", "Click here to reset your password: $reset_link");

            echo "Reset link has been sent to your email.";
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Password Reset</title>
</head>
<body>
    <form action="request_reset.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit">Request Reset</button>
        <?php if (!empty($error)) echo "<div>$error</div>"; ?>
    </form>
</body>
</html>
