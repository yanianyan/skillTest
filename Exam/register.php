<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: index.php");
    include "logic.php";
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <?php
    if (isset($_POST["submit"])) {
     $userName = $_POST["username"];
     $email = $_POST["email"];
     $password = $_POST["password"];
     $confirmPassword = $_POST["confirm_password"];

     $passwordHash = password_hash($password, PASSWORD_DEFAULT);
     $errors = array();

     
     if (empty($userName) OR empty($email) OR empty($password) OR empty($confirmPassword)) {
        array_push($errors,"All fields are Required");
     }
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not Valid");
     }
     if (strlen($password)<8) {
        array_push($errors, "Password must be at least 8 characters long.");
     }
     if ($password!==$confirmPassword) {
        array_push($errors, "Password does not Match.");
     }
     require_once "database.php";
     $sql = "SELECT * FROM users WHERE email = '$email'";
     $result = mysqli_query($conn, $sql);
     $rowCount = mysqli_num_rows($result);
     if($rowCount>0){
        array_push($errors, "Email already Exists!"); 
     }
     if(count($errors)>0){
        foreach($errors as $error){
            echo"<div class='alert alert-danger'>$error</div>";
      
     }
     }else{
        
        $sql = "INSERT INTO users (userName, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if($prepareStmt){
                mysqli_stmt_bind_param($stmt,"sss",$userName, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are Registered Successfully!</div>";
        }else{
            die("Something went Wrong.");
        }
        }
    }

    
?>

<nav class="navbar navbar-expand-lg navbar fixed-top navbar-dark bg-dark">
  <a class="navbar-brand" href="#">MiniBlog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link text" href="#">Home <span class="sr-only"></span></a>
      </li>
     
    </ul>
  </div>
</nav>
<h1 class="text-center">Registration</h1>
    <div class="container">
        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <input type="password" name="password"  class="form-control" id="password" placeholder="Enter Password" >
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div><p>Already Registered? <a href="login.php">Login Here</a></p></div>
    </div>
    <script src="js\index.js"></script>
</body>
</html>