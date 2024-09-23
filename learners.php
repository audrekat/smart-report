<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Learners</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Header styling */
        .header {
            background-color: #0056b3;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .header h1 {
            margin: 0;
        }

        .logo {
            width: 60px;
            height: 60px;
        }

        .dashboard h1 {
            text-align: center;
            color: white;
        }

        /* Button styles */
        .back-button {
            background-color: #0056b3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        /* Search form styling */
        .search-container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .search-container input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-container button {
            padding: 10px 15px;
            background-color:  #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: white;
            color:  #007bff;
        }

        /* Table styling */
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #0056b3;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Button styles */
        button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-button {
            background-color:  #007bff; /* Green for Edit */
            color: white;
        }

        .delete-button {
            background-color: #dc3545; /* Red for Delete */
            color: white;
            margin-left: 5px; /* Spacing between buttons */
        }

        .edit-button:hover {
            background-color: white;
            color:  #007bff;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
        h1{
            color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div>
            <img src="logo.png" alt="Logo" class="logo">
        </div>
        <div class="dashboard">
            <h1>Name of the School</h1>
        </div>
    </div>

    <div class="search-container">
        <a href="admind.html" class="back-button">Back</a>
        <h1>List of Learners</h1>
        <form action="search_learners.php" method="get">
            <input type="text" placeholder="Search for learners..." name="search" required>
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Learner ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>ID Number</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "smart_report";  // Make sure the database name matches your setup

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Query to fetch all learners
            $query = "SELECT * FROM learner";
            $result = mysqli_query($conn, $query);

            // Check if any records are found
            if (mysqli_num_rows($result) > 0) {
                // Loop through each learner and display them in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['learner_id']) . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['surname']) . "</td>
                            <td>" . htmlspecialchars($row['id_number']) . "</td>
                            <td>" . htmlspecialchars($row['date_of_birth']) . "</td>
                            <td>" . htmlspecialchars($row['gender']) . "</td>
                            <td>" . htmlspecialchars($row['address']) . "</td>
                            <td>" . htmlspecialchars($row['grade']) . "</td>
                            <td>
                                <a href='edit_learner.html?id=" . $row['learner_id'] . "'>
                                    <button class='edit-button'>Edit</button>
                                </a>
                                <a href='deletelearner.php?id=" . $row['learner_id'] . "' onclick='return confirm(\"Are you sure you want to delete this learner?\");'>
                                    <button class='delete-button'>Delete</button>
                                </a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No learner found</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>
