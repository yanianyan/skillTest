<?php
session_start();
if (isset($_SESSION["user"])){
    header("Location: index.php");
    
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar fixed-top navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">MiniBlog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
      </li>
     
    </ul>
  </div>
</nav>
    <div class="container">
        <?php
        if(isset($_POST["login"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user){
                if (password_verify($password, $user["password"])){
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                }else{
                    echo "<div class= 'alert alert-danger'> Password does not Match!</div>";
                }
            }else{
                echo "<div class= 'alert alert-danger'> Email does not Match!</div>";
                

            }
        }
    ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter your Email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter your Password" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class= "btn btn-primary">
            </div>
        </form>
        <div><p>Not Registered Yet? <a href="register.php">Register Here</a></p></div>
    </div>
    
</body>
</html>