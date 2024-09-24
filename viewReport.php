<?php
// Connect to the smart_report database
$host = 'localhost';
$dbname = 'smart_report';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search query variable
$searchQuery = '';
$learnerSelected = false; // To check if a learner is selected

// Step 1: Handle learner selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_learner'])) {
    $searchQuery = $_POST['search'];

    // Fetch learners based on search query
    $sql = "SELECT learner_id, id_number, name FROM learner";
    if (!empty($searchQuery)) {
        $sql .= " WHERE name LIKE '%$searchQuery%' OR id_number LIKE '%$searchQuery%'";
    }

    $result = $conn->query($sql);
}

// Step 2: Handle results form submission for the selected learner
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_results'])) {
    $learner_id = $_POST['learner_id'];

    // Insert or update results for the learner
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $test3 = $_POST['test3'];
    $exam = $_POST['exam'];
    $attendance = $_POST['attendance'];
    $overall_results = $_POST['overall_results'];
    $comments = $_POST['comments'];

    // Insert or update logic for results
    $sql = "INSERT INTO results (learner_id, test1, test2, test3, exam, attendance, overall_results, comments)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE test1 = VALUES(test1), test2 = VALUES(test2), 
                                    test3 = VALUES(test3), exam = VALUES(exam), 
                                    attendance = VALUES(attendance), 
                                    overall_results = VALUES(overall_results), 
                                    comments = VALUES(comments)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiisss", $learner_id, $test1, $test2, $test3, $exam, $attendance, $overall_results, $comments);
    $stmt->execute();

    // Display success message
    echo "<p>Results successfully added for learner ID $learner_id!</p>";
    $learnerSelected = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007BFF;
            text-align: center;
        }
        .search-container {
            margin-bottom: 20px;
            text-align: right;
        }
        .search-container input {
            padding: 10px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-container button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-btn {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1>Teacher Dashboard</h1>

    <!-- Step 1: Search for Learner -->
    <?php if (!$learnerSelected): ?>
    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Search by learner name or ID number..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" name="search_learner">Search</button>
        </form>
    </div>

    <!-- Display Learners -->
    <?php if (isset($result) && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Roll No</th>
                <th>ID Number</th>
                <th>Learner Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['learner_id']; ?></td>
                <td><?php echo $row['id_number']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="learner_id" value="<?php echo $row['learner_id']; ?>">
                        <button type="submit" class="action-btn" name="add_results_form">Add Results</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <?php endif; ?>

    <!-- Step 2: Add Results for Selected Learner -->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_results_form'])): ?>
        <?php $learner_id = $_POST['learner_id']; ?>
        <h2>Add Results for Learner ID: <?php echo $learner_id; ?></h2>
        <form method="POST" action="">
            <input type="hidden" name="learner_id" value="<?php echo $learner_id; ?>">
            <table>
                <tr>
                    <th>Test 1</th>
                    <td><input type="text" name="test1" placeholder="Test 1"></td>
                </tr>
                <tr>
                    <th>Test 2</th>
                    <td><input type="text" name="test2" placeholder="Test 2"></td>
                </tr>
                <tr>
                    <th>Test 3</th>
                    <td><input type="text" name="test3" placeholder="Test 3"></td>
                </tr>
                <tr>
                    <th>Exam</th>
                    <td><input type="text" name="exam" placeholder="Exam"></td>
                </tr>
                <tr>
                    <th>Attendance</th>
                    <td><input type="text" name="attendance" placeholder="Attendance"></td>
                </tr>
                <tr>
                    <th>Overall Results</th>
                    <td><input type="text" name="overall_results" placeholder="Overall Results"></td>
                </tr>
                <tr>
                    <th>Comments</th>
                    <td><input type="text" name="comments" placeholder="Comments"></td>
                </tr>
            </table>
            <br>
            <button type="submit" name="add_results" class="action-btn">Submit Results</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
