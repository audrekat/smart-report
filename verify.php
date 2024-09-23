<?php
session_start();
$mysqli = new mysqli("localhost(smart report)", "username(tshegonkomi49@gmail.com)", "password(123456789)", "otp_system"); // Replace with your DB credentials

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = 'user@example.com'; // Replace with user input
    $userInputOTP = $_POST['otp'];

    // Retrieve the OTP record
    $stmt = $mysqli->prepare("SELECT otp, expires_at FROM otps WHERE user_email = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($otp, $expiresAt);
        $stmt->fetch();
        
        if ($userInputOTP === $otp && strtotime($expiresAt) > time()) {
            echo "OTP Verified Successfully!";
            // You may want to delete the OTP from the database after successful verification
            $deleteStmt = $mysqli->prepare("DELETE FROM otps WHERE user_email = ? AND otp = ?");
            $deleteStmt->bind_param("ss", $userEmail, $otp);
            $deleteStmt->execute();
            $deleteStmt->close();
        } else {
            echo "Invalid OTP or OTP expired.";
        }
    } else {
        echo "No OTP found. Please request a new one.";
    }
    $stmt->close();
}

$mysqli->close();
?>

<form method="POST" action="">
    <label for="otp">Enter OTP:</label>
    <input type="text" name="otp" required>
    <button type="submit">Verify OTP</button>
</form>
