<?php
session_start();
$mysqli = new mysqli("localhost", "username", "password", "otp_system"); // Replace with your DB credentials

function generateOTP($length = 6) {
    $digits = '0123456789';
    return substr(str_shuffle(str_repeat($digits, $length)), 0, $length);
}

$userEmail = 'user@example.com'; // Replace with user input
$otp = generateOTP();
// $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes')); // 5 minutes expiration

// Insert OTP into the database
$stmt = $mysqli->prepare("INSERT INTO otps (user_email, otp, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $userEmail, $otp, $expiresAt);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Send OTP via email
    $subject = 'Your OTP Code';
    $message = "Your OTP is: " . $otp;
    $headers = 'From: noreply@yourdomain.com' . "\r\n";
    
    if (mail($userEmail, $subject, $message, $headers)) {
        echo "OTP sent successfully!";
    } else {
        echo "Failed to send OTP.";
    }
} else {
    echo "Error saving OTP.";
}

$stmt->close();
$mysqli->close();
?>

