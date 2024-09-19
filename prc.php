<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers List</title>
    <link rel="stylesheet" href="style.css">
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

<table>
    <thead>
        <tr>
            <th>Teacher ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Contact</th>
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

        // Query to get teacher data
        $query = "SELECT * FROM Teacher";
        $result = mysqli_query($conn, $query);

        // Check if results are returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch and display each row of data
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['Teacher_ID']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Surname']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['Contact']}</td>
                        <td class='action-buttons'>
                            <button class='edit-button'>Edit</button>
                            <button class='delete-button'>Delete</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </tbody>
</table>

</body>
</html>
