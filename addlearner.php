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
    $subjects = $_POST['subjects']; // This will be an array of subjects from the form

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'report_smart'); // Adjust if needed

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the learner data into the learner table
    $sql = "INSERT INTO learner (name, surname, id_number, date_of_birth, gender, address, grade) 
            VALUES ('$name', '$surname', '$id_number', '$date_of_birth', '$gender', '$address', '$grade')";

    if ($conn->query($sql) === TRUE) {
        // Get the last inserted learner ID
        $learner_id = $conn->insert_id;

        // Insert each subject into the subjects table
        foreach ($subjects as $subject) {
            // Insert subject with learner_id into subjects table
            $sql_subject = "INSERT INTO subjects (learner_id, subject) VALUES ('$learner_id', '$subject')";
            if (!$conn->query($sql_subject)) {
                echo "Error inserting subject: " . $conn->error;
            }
        }

        // Redirect to the addlearner.html page upon success
        header("Location: addlearner.html");
        exit(); // Ensure the script stops after redirection

    } else {
        // Handle the error if learner insertion fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
