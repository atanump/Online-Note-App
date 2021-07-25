<?php
session_start();
if(!empty($_SESSION["user_id"])){
  header("location:mainpage.php");
}
include("connection.php");
include("rememberme.php");
include("logout.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Online NoteBook</title>
    <link href="styling.css" rel="stylesheet">
  </head>
  <body>
  <!-- Navygation Bar -->
  <nav class="navbar navbar-expand-md bg-dark navbar-dark static-top">
<div class="container-fluid">
<a class="navbar-brand" href="#">Online Notes</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Help</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact us</a>
      </li>  
    </ul>
    
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="#loginModal" data-bs-toggle="modal">Login</a>
      </li> 
    </ul>
  </div>  
</div>
</nav>
<!-- Jumbotron signup button -->
<div class="jumbotron">
  <h1 class="display-4" >Online Note App</h1>
  <p class="lead" style="font-size: 25px;">Your Notes with you wherever you go</p>
  <p style="font-size: 30px;">Easy to use, protects all your notes!</p>
  <button type="button" class="btn btn-primary signup" data-bs-toggle="modal" data-bs-target="#signupModal" >Sign up</button>
</div>

<!-- Signup Model -->
<form method="POST" id="signupform">
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signup" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="signupLabel">Sign up today and start using our Online Note App!</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- signup error or successful msg -->
        <div id="signupmsg"></div>
        <form>
        <div class="mb-3">
            <input type="text" class="form-control" id="inputUserName" name="username" placeholder="Username" maxlength="20">
          </div>
          <div class="mb-3">
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email Address">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="password1" name="password1" placeholder="Choose a password">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm your password">
          </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Sign up</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- login Model -->
<form method="POST" id="loginform">
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="login" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="loginLabel">Login:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Login error or successful msg -->
      <div id="loginmsg"></div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <input type="email" class="form-control" id="loginEmail" name="loginEmail" placeholder="Email Address">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
          </div>
          <div class="mb-3">
            <label> <input type="checkbox" name="rememberme" id="rememberme"> Remember me</label>
            <a href="#forgotModal" class="float-end" data-bs-toggle="modal" data-bs-dismiss="modal">Forgot Password?</a>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary float-start" data-bs-toggle="modal" data-bs-dismiss="modal"
      data-bs-target="#signupModal" id="register">Register</button>
      <button type="submit" class="btn btn-primary">Login</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
</form>

<!-- Forgot Password Form-->
<form method="POST" id="forgotform">
<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgot" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Forgot password? Enter your Email address</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Forgot password error or successfull msg -->
      <div id="forgotpasswordmsg"></div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <input type="email" class="form-control" id="enterEmail" name="enterEmail" placeholder="Email Address">
          </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</form>



<!-- Footer -->
<div class="footer">
  <div class="container" id="footertext">
  <p>&copy; 2020 AM — Made with &#10084;for the people of the internet.</p>
  </div>
</div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="index.js"></script>
    
  </body>
</html>