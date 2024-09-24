<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root"; // Your database username
$db_password = ""; // Your database password
$dbname = "smart_report";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST['email']; 
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
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin_dashboard.php"); // Admin dashboard
                    break;
                case 'teacher':
                    header("Location: teacher_dashboard.php"); // Teacher dashboard
                    break;
                case 'parent':
                    header("Location: parent_dashboard.php"); // Parent dashboard
                    break;
                default:
                    echo "Invalid role!";
                    break;
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
