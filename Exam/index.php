<?php
session_start();
if (!isset($_SESSION["user"])){
    header("Location: login.php");
}
include "logic.php";
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
        <li>
        <a href="logout.php" class="btn btn-warning float-right">Logout</a>
        </li>
     
    </ul>
  </div>
</nav>
    <div class="container">
        <h1> Welcome to the Homepage!</h1>
        
    </div>
    <div class="container mt-5">

<!-- Display any info -->
<?php if(isset($_REQUEST['info'])){ ?>
    <?php if($_REQUEST['info'] == "added"){?>
        <div class="alert alert-success" role="alert">
            Post has been added successfully
        </div>
    <?php }?>
<?php } ?>

<!-- Create a new Post button -->
<div class="text-center">
    <a href="create.php" class="btn btn-outline-dark">+ Create a new post</a>
</div>

<!-- Display posts from database -->
<div class="row">
    <?php foreach($query as $q){ ?>
        <div class="col-12 col-lg-4 d-flex justify-content-center">
            <div class="card text-white bg-dark mt-5" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $q['title'];?></h5>
                    <p class="card-text"><?php echo substr($q['content'], 0, 50);?>...</p>
                    <a href="view.php?id=<?php echo $q['id']?>" class="btn btn-light">Read More <span class="text-danger">&rarr;</span></a>
                </div>
            </div>
        </div>
    <?php }?>
</div>

</div>
</div>
</body>
</html>