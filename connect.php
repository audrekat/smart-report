<?php
// Include the Composer autoload file
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
$password = '1234teacher'; // Set a default password
$user_type = 'teacher'; // Define user type

// Corrected SQL query
$sql_query = "INSERT INTO `parent`(`name`, `surname`, `id_number`, `gender`, `email`, `contact`, `password`, `user_type`, `username`) VALUES ('$name', '$surname', '$id_number', '$gender', '$email', '$contact','$password','$user_type','$username')";
$sql_query = "INSERT INTO `teacher`(`Teacher_ID`, `Name`, `Surname`, `Email`, `Subject_ID`, `Contact`, `registration_date`, `gender`) VALUES ('$name', '$surname', '$email', '$contact','$registrastion_date','$gender')";

if ($conn->query($sql_query) === TRUE) {
    echo "New teacher registered successfully<br>";

    // Send confirmation email
    $mail = new PHPMailer(true);
    
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'audreymmakaepea@gmail.com'; 
        $mail->Password = 'ttxn rwfb uevr mbbr'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        // Recipients
        $mail->setFrom('your-email@example.com', 'Your Name'); 
        $mail->addAddress($email, "$name $surname"); 

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Registration Successful';
        $mail->Body = "Hi $name,<br><br>Thank you for registering as a teacher! Use your name as username and 1234parent as your password.<br>Best regards,<br>Your Organization";

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
