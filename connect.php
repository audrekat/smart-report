<?php
// Database configuration
$servername = "localhost"; // or your server IP
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "smart_report"; // your database name

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
$gender = mysqli_real_escape_string($conn, $_POST['Gender']);
$email = mysqli_real_escape_string($conn, $_POST['Email']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);

// Corrected SQL query
$sql_query = "INSERT INTO `parent`(`parent_id`, `name`, `surname`, `id_number`, `gender`, `email`, `contact`, `password`, `user_type`, `username`) VALUES ('$name', '$surname', '$id_number', '$gender', '$email', '$contact','$password','$user_type','$username')";

if ($conn->query($sql_query) === TRUE) {
    echo "New teacher registered successfully<br>";

    // Send confirmation email
    $mail = new PHPMailer(true);
    
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Your email address
        $mail->Password = 'your-email-password'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS or SSL
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('your-email@example.com', 'Your Name'); // Sender
        $mail->addAddress($email, "$name $surname"); // Recipient

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Registration Successful';
        $mail->Body = "Hi $name,<br><br>Thank you for registering as a parent!
        use your name as username and 1234parent as your password<br>Best regards,<br>Your Organization";

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
