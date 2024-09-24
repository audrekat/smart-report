<!DOCTYPE html>
<html lang="en">
<?php
    $message=
    "logged in successfully...redirecting to dashboard";

    session_start();
    if(isset($_SESSION["logged_in"])){
        header("Location:admind.html");
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $con=mysqli_connect('localhost',
            'mapula',
            '123456789','smart_report');

        if($con);
        else
            echo "failed to connect to database";
        $username1=$_POST['username'];
        $prefix="_";
        $username=$prefix.$username1;
        $password=$_POST['Password'];

        $sql = "SELECT id,username, password FROM 1_user";
        $result = $con->query($sql); 

        if ($result->num_rows > 0) {
            $fnd=0;
            while($row = $result->fetch_assoc()) {

                /* echo "<br> id: ". $row["id"]. 
                " - username= ". $row["username"]. 
                " password= " . $row["password"] . "<br>"; */

                if($row["username"]==$username and 
                    $row["password"]==$password) {    
                    
                    $_SESSION["username"] = $username;
                    $_SESSION["login-going-on"]="0";
                    $fnd=1;
                    $_SESSION["logged_in"]="1";
                    echo '<div class="alert alert-success" 
                        role="alert">'.$message.'</div>';

                    echo 
"<script>setTimeout(\"location.href = 'admind.html';\",3000);</script>";
                }
            }
            if($fnd==0)
                echo(
"<script>alert('username password not matches')</script>");

        }
        else {
            echo(
"<script>alert('username password not matches')</script>");
        }
        $con->close();
    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" 
        href="css/style.css" media="screen" />

    <!--  Adding bootstrap  -->
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity=
"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity=
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous">
    </script>
    
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous">
    </script>
    
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous">
    </script>
    
    <!-- <div class="nav-bar">
        <div class="title">
            <h3>Login</h3>
        </div>
    </div> -->
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css"> 

<style>
    /* Basic reset */
body, h2, form, input, a {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Body styles */
body {
  font-family: Arial, sans-serif;
  background-color: azure;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-image: url(image\ copy.png);
  background-size: cover;
}

/* Container styles */
.container {
  background: skyblue;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.11);
  padding: 20px;
  width: 300px;
  max-width: 100%;
}

/* Header styles */
h2 {
  margin-bottom: 20px;
  font-size: 24px;
  color: #333;
  text-align: center;
}

/* Form group styles */
.form-group {
  margin-bottom: 15px;
}

/* Label styles */
label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  color: #333;
}

/* Input styles */
input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

/* Submit button styles */
input[type="submit"] {
  background-color:green;
  color: #fff;
  border: none;
  padding: 10px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #4cae4c;
}

/* Link styles */
a {
  color: red;
  text-decoration: none;
  font-family: Arial, Helvetica, sans-serif;
}

a:hover {
  text-decoration: underline;
}
/* .logo{
  padding-left: 20px;
} */

</style>
</head>

<body>
    <!-- <form class="form-login" action="index.php" method="POST">
        <div class="form-group">
            <label>username</label>
            <input type="text" class="form-control" 
                name="username" id="username" 
                aria-describedby="emailHelp"
                placeholder="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" 
                name="Password" id="Password" 
                placeholder="Password" required>
        </div>

        <button type="submit" 
            class="btn btn-primary btn-lg">Login
        </button>
        
        <button type="button" 
            class="btn btn-warning btn-lg" 
            id="Login-button">
            login
        </button>
    </form> -->
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
          <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" id="username" name="username" required>
          </div>
          <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required>
          </div>
          <div class="form-group">
              <input type="submit" value="Login">
          </div>
          <div class="form-group">
              <a href="forgot password.html">Forgot password?</a>
          </div>
      </form>      
        
    </div>
    <script>
            $("#Login-button").click(function () {
                window.location.replace("admind.html");
            });
    </script>
</body>

</html>
