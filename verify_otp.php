<?php
session_start();

// Check if the OTP session variable is set
if (!isset($_SESSION['otp'])) {
    echo "No OTP has been generated. Please login again.";
    exit(); // Stop the script if OTP is not set
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    
    // Check if entered OTP is correct
    if ($entered_otp == $_SESSION['otp']) {
        // Redirect to the respective dashboard based on user role
        switch ($_SESSION['role']) {
            case 'parent':
                header("Location: parentdashboard.php");
                break;
            case 'teacher':
                header("Location: teacherdashboard.php");
                break;
            case 'admin':
                header("Location: admindashboard.php");
                break;
            default:
                echo "Unknown user role.";
        }
        exit();
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login_container">
        <form action="" method="post"> 
            <h2>Verify OTP</h2>
            <div class="form-group">
                <label for="otp">Enter OTP:</label>
                <input type="text" id="otp" name="otp" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Verify">
            </div>
        </form>
    </div>
</body>
</html>
