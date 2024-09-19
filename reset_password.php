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

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check token validity
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = :token AND token_expiration > NOW()");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Invalid or expired token.");
    }

    // Handle new password submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = $_POST['new_password'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password and clear the reset token
        $stmt = $pdo->prepare("UPDATE users SET password = :password, reset_token = NULL, token_expiration = NULL WHERE id = :id");
        $stmt->execute(['password' => $hashed_password, 'id' => $user['id']]);

        echo "Password has been reset successfully.";
        exit();
    }
} else {
    die("No token provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
