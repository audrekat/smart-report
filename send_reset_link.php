<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Generate a secure token
    $resetToken = bin2hex(random_bytes(50));
    $expiry = time() + 3600; // 1 hour expiration

    // Store the token in the database (example SQL)
    // UPDATE users SET reset_token='$resetToken', token_expiry='$expiry' WHERE email='$email';

    // Send the email
    $resetLink = "https://yourwebsite.com/reset-password.php?token=$resetToken";
    $subject = "Password Reset Request";
    $message = "Click this link to reset your password: $resetLink";
    $headers = 'From: no-reply@yourwebsite.com';

    mail($email, $subject, $message, $headers);
    
    echo "If your email exists, you'll receive a password reset link shortly.";
}
?>
