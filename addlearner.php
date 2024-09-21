<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $id_number = $_POST['id_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $grade = $_POST['grade'];
    $subjects = $_POST['subjects']; // This will be an array

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'smart_report'); // Adjust if needed

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement to insert the learner
    $sql = "INSERT INTO learner (name, surname, id_number, date_of_birth, gender, address, grade) 
            VALUES ('$name', '$surname', '$id_number', '$date_of_birth', '$gender', '$address', '$grade')";

    if ($conn->query($sql) === TRUE) {
        // Get the last inserted learner ID
        $learner_id = $conn->insert_id;

        // Insert each subject into the learner_subjects table
        foreach ($subjects as $subject) {
            $sql_subject = "INSERT INTO subjects (learner_id, subject) VALUES ('$learner_id', '$subject')";
            $conn->query($sql_subjects);
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
