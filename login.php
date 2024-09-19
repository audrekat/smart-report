<?php
$host = "localhost"; // or your host
$user = "your_username"; // your database username
$pass = "your_password"; // your database password
$dbname = "smart_report"; // your database name

session_start();
$page_tittle ="Login form";
   
      include("login.php");
      include("login.php");
      $user_data = check_login($con);

     if($_SERVER['REQUEST_METHOD'] == "POST")
     {
        //something was posted
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if(!empty($user_name) && empty($password) && !is_numeric($user_name))
        {
            //read from datadase
            $user_id = random_num(20);
            $query = "select * from users where user_name = '$user_name' limit 1";
            $result = mysqli_query($con, $query);

            if($result)
            {
              
              if($result && mysqli_num_rows($result) > 0)
              {
                $user_data = mysqli_fetch_assoc($result);
            
              if($user_data['password'] === $password)
              {
                $_SESSION[ 'user_id'] = $user_data['user_id'];
                header("Location: dashboard.php");
                die;
              }
            }

          }
          echo "wrong username or password";    
          
        }else
        {
          echo "wrong username or password";
        }
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="login-container">
        <h2>Login to Smart Report</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

