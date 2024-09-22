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
    
    // Generate a random password and hash it
    $password = bin2hex(random_bytes(4)); // Generate a random password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Set registration date
    $registration_date = date('Y-m-d H:i:s');

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'smart_report');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Begin transaction to ensure both inserts happen together
    $conn->begin_transaction();

    try {
        // Prepare and bind the SQL statement to insert the parent form data
        $sql_parent = "INSERT INTO parent (name, surname, id_number, gender, address, email, contact, username, user_type, password, registration_date) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_parent = $conn->prepare($sql_parent);
        $stmt_parent->bind_param('sssssssssss', $name, $surname, $id_number, $gender, $address, $email, $contact, $username, $user_type, $hashed_password, $registration_date);
        
        // Execute the insert query for parent
        if (!$stmt_parent->execute()) {
            throw new Exception("Error inserting into parent table: " . $stmt_parent->error);
        }

        // Insert the same username, hashed password, and role into the userslogin table
        $sql_userlogin = "INSERT INTO userlogin (email, password, role) VALUES (?, ?, ?)";
        $stmt_userlogin = $conn->prepare($sql_userlogin);
        $stmt_userlogin->bind_param('sss', $username, $hashed_password, $user_type);
        
        // Execute the insert query for userslogin
        if (!$stmt_userlogin->execute()) {
            throw new Exception("Error inserting into userlogin table: " . $stmt_userlogin->error);
        }

        // Commit the transaction
        $conn->commit();

        // Set up PHPMailer to send the email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'malemamahlatse70@gmail.com'; // Your Gmail address
            $mail->Password = 'cdbhkiurykowykqw'; // Your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('malemamahlatse70@gmail.com', 'Mahlatse');
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

    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $conn->rollback();
        echo $e->getMessage();
    }

    // Close the connections
    $stmt_parent->close();
    $stmt_userlogin->close();
    $conn->close();
}
?>
