<?php
    include 'partials/_dbconnect.php';
    ?>
<?php
session_start();


echo '<nav class="navbar navbar-expand-lg" style="background-color:rgb(76, 4, 144)">
<div class="container-fluid py-1">
  <a class="navbar-brand text-white fw-bold fs-3 px-2" href="#">fcc</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse pt-1 px-2" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item px-1">
        <a class="nav-link active text-white " aria-current="page" href="index.php">Home</a>
      </li>
      <li class="nav-item px-1">
        <a class="nav-link text-white" href="about.php">About</a>
      </li>
      <li class="nav-item px-1">
        <a class="nav-link text-white" href="sessions.php">Sessions</a>
      </li>
      <li class="nav-item px-1">
        <a class="nav-link text-white" href="blog.php">blog</a>
      </li>
      <li class="nav-item px-1">
        <a class="nav-link text-white" href="contact.php">Contact</a>
      </li>
      <li class="nav-item px-1">
        <a class="nav-link text-white" href="feedback.php">Feedback</a>
      </li>
      
    </ul>
    ';


    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '
      <form class="d-flex" role="search" method="get" action="search.php">
      <input class="form-control me-2" name="search" type="search" action="search.php" placeholder="Search" aria-label="Search">
      <button class="btn btn-success bg-secondary" type="submit">Search</button>
        
      </form>    
      <p class="text-white mt-3 mx-2"> '.$_SESSION['useremail'].' </p>
      
      <a href="partials/_logout.php" class="btn btn-outline-dark bg-dark text-white mx-2">Logout </a>';
    }
    else{
    echo '<form class="d-flex" role="search">
    <input class="form-control me-2" name="search" type="search" placeholder="Login required" aria-label="Search">
    <button class="btn btn-success bg-secondary" type="submit">Search</button>
  </form>
  <button class="btn btn-outline-dark bg-dark mx-2 text-white" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
    <button class="btn btn-outline-dark bg-dark text-white" data-bs-toggle="modal" data-bs-target="#signupmodal">SignUp</button>';}

  echo '</div>
</div>
</nav>';

include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '
  <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Successfull!</strong> Signup Successfull.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
  ';
}
else if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
  echo '
  <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Unsuccessfull!</strong> Signup unsuccessfull.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
  ';
}

if(isset($_GET['loginsuccessfull']) && $_GET['loginsuccessfull']=="true"){
  echo '
  <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Successfull!</strong> Login Successfull.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
  ';
}
else if(isset($_GET['loginsuccessfull']) && $_GET['loginsuccessfull']=="false"){
  echo '
  <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Unsuccessfull!</strong> Login unsuccessfull.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
  ';
}

if(isset($_GET['logout']) && $_GET['logout']=="true"){
  echo '
  <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Successfull!</strong> Logout Successfull.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
  ';
}


?>