<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Learners</title>
    <link rel="stylesheet" href="style.css">
    <!-- <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons button {
            margin-right: 5px;
        }
    </style> -->
</head>
<body>
<!-- Header -->
<div class="header">
        <div>
            <img src="logo.png" alt="Logo" class="logo">
        </div>
        <div>
            <h1>List of All Teachers</h1>
        </div>
        <div class="admin-dashboard">
            <h1>Admin Dashboard</h1>
        </div>
    </div>

    <!-- Search bar and Back button -->
    <div class="search-bar">
        <a href="admin-dashboard.html" class="back-button">Back</a>
        <input type="text" placeholder="Search for teachers...">
        
    </div>    

<h1>List of Learners</h1>

<table>
    <thead>
        <tr>
            <th>Learner ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>ID Number</th>
            <th>Grade</th>
            <th>Parent ID</th>
            <th>Date of Birth</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "smart_report";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Query to fetch all learners
        $query = "SELECT * FROM Learner";
        $result = mysqli_query($conn, $query);

        // Check if any records are found
        if (mysqli_num_rows($result) > 0) {
            // Loop through each learner and display them in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['Learner_id']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Surname']}</td>
                        <td>{$row['ID_number']}</td>
                        <td>{$row['Grade']}</td>
                        <td>{$row['Parent_id']}</td>
                        <td>{$row['Date_of_birth']}</td>
                        <td class='action-buttons'>
                            <button class='edit-button'>Edit</button>
                            <button class='delete-button'>Delete</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No learners found</td></tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </tbody>
</table>

</body>
</html>
