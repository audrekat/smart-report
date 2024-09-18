<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parent List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <h1>Parent List</h1>
    <table>
        <thead>
            <tr>
                <th style="color: black;">ID</th>
                <th style="color: black;">First Name</th>
                <th style="color: black;">Last Name</th>
                <th style="color: black;">Email</th>
                <th style="color: black;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example learner data; replace with dynamic content -->
            <tr>
                <td>1</td>
                <td>Allen</td>
                <td>Morrel</td>
                <td>Allen.M@example.com</td>
                <td>
                    <a href="edit_learner.html?id=1"><button>Edit</button></a>
                    <form action="delete_learner.php" method="POST" style="display:inline;">
                        <input type="hidden" name="learner_id" value="1">
                        <button style="background-color: red;" type="submit" onclick="return confirm('Are you sure you want to delete this learner?');">Delete</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Olen</td>
                <td>Morgan</td>
                <td>Morgan.M@example.com</td>
                <td>
                    <a href="edit_learner.html?id=2"><button>Edit</button></a>
                    <form action="delete_learner.php" method="POST" style="display:inline;">
                        <input type="hidden" name="learner_id" value="2">
                        <button style="background-color: red;" type="submit" onclick="return confirm('Are you sure you want to delete this learner?');">Delete</button>
                    </form>
                </td>
            </tr>
            <!-- Repeat for other Parent -->
        </tbody>
    </table>
    <a href="#">Add New Parent</a>
    
</body>
</html>
