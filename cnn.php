<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';
// Database configuration
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "smart_report"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$surname = mysqli_real_escape_string($conn, $_POST['surname']);
$id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
$gender = mysqli_real_escape_string($conn, $_POST['Gender']); // Check form field name
$email = mysqli_real_escape_string($conn, $_POST['Email']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$password = '1234parent'; // Set a default password
$user_type = 'parent'; // Define user type

// Corrected SQL query
$sql_query = "INSERT INTO `parent`(`name`, `surname`, `id_number`, `gender`, `email`, `contact`, `password`, `user_type`, `username`) VALUES ('$name', '$surname', '$id_number', '$gender', '$email', '$contact','$password','$user_type','$username')";

if ($conn->query($sql_query) === TRUE) {
    echo "New parent registered successfully<br>";

    // Send confirmation email
    $mail = new PHPMailer(true);
    
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; 
        $mail->Password = 'your-email-password'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        // Recipients
        $mail->setFrom('your-email@example.com', 'Your Name'); 
        $mail->addAddress($email, "$name $surname"); 

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Registration Successful';
        $mail->Body = "Hi $name,<br><br>Thank you for registering as a parent! Use your name as username and 1234parent as your password.<br>Best regards,<br>Your Organization";

        $mail->send();
        echo 'Confirmation email has been sent.';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    echo "Error: " . $sql_query . "<br>" . $conn->error;
}

$conn->close();
?>
