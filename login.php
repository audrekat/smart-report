<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root"; // Your database username
$db_password = ""; // Your database password
$dbname = "report_smart";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST['email']; // Use username or email based on your setup
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM userlogin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store session data
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header("Location: admind.html"); // Admin dashboard
            } elseif ($user['role'] == 'teacher') {
                header("Location: teacher_dashboard.php"); // Teacher dashboard
            } elseif ($user['role'] == 'parent') {
                header("Location: parent_dashboard.php"); // Parent dashboard
            }
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
}

$conn->close();
?>
