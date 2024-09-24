<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $id_number = $_POST['id_number'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "smart_report");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the data
    $sql = "INSERT INTO teacher (name, surname, id_number, gender, email, contact) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $surname, $id_number, $gender, $email, $contact);

    // Execute the query and check for success
    if ($stmt->execute()) {
        $success_message = "Teacher registered successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a Teacher</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Header -->
  <div class="header">
    <div>
        <img src="1.jpg" alt="Logo" class="logo">
    </div>
    <div class="dashboard">
        <h1>DIOPONG PRIMARY SCHOOL</h1>
    </div>
</div>

    <form action="" method="post">
        <div class="addcontainer">
          <h1>Register a Teacher</h1>
          
          <!-- Display success or error messages -->
          <?php if (isset($success_message)) { echo "<p style='color:green;'>$success_message</p>"; } ?>
          <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
        
          <hr>
      
          <label for="name"><b>Name(s):</b></label>
          <input type="text" placeholder="Enter name" name="name" id="name" required>
    
          <label for="surname"><b>Surname:</b></label>
          <input type="text" placeholder="Enter surname" name="surname" id="surname" required>
    
          <label for="id_number"><b>ID Number:</b></label>
          <input type="text" placeholder="Enter ID number" name="id_number" id="id_number" required>

          <label for="gender"><b>Gender:</b></label>
          <select name="gender" id="gender" required>
            <option value="female">Female</option>
            <option value="male">Male</option>
            <option value="other">Other</option>
          </select>

          <label for="email"><b>Email Address:</b></label>
          <input type="email" placeholder="Enter Email address" name="email" id="email" required>
    
          <label for="contact"><b>Contact:</b></label>
          <input type="text" placeholder="+27 123 456 7890" name="contact" id="contact" required>
 
          <hr>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      </form>

</body>
</html>