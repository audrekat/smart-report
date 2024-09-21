<?php
// Include Composer's autoload file
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $id_number = $_POST['id_number'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $user_type = $_POST['user_type'];
    $password = bin2hex(random_bytes(4)); // Generate a random password

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'smart_report');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement to insert the form data
    $sql = "INSERT INTO parent (name, surname, id_number, gender, address, email, contact, username, user_type, password) 
            VALUES ('$name', '$surname', '$id_number', '$gender', '$address', '$email', '$contact', '$username', '$user_type', '$password')";

    // Execute the query and check if the insert was successful
    if ($conn->query($sql) === TRUE) {
        // Set up PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Your Gmail address
            $mail->Password = 'your-16-character-app-password'; // Your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your-email@gmail.com', 'Your Name');
            $mail->addAddress($email, "$name $surname"); // Add the parent’s email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Registration Successful';
            $mail->Body    = "Hello $name,<br><br>Your registration was successful. Your username is $username and your password is $password.<br><br>Thank you!";
            $mail->AltBody = "Hello $name,\n\nYour registration was successful. Your username is $username and your password is $password.\n\nThank you!";

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Redirect to addlearner.html
        header("Location: addlearner.html");
        exit(); // Ensure the script stops after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
