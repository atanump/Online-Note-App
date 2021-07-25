<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("location:index.php");
}
// Connect database
include("connection.php");
// Retrieve user id
$user_id = $_SESSION['user_id'];
// Perform sql query and retrieve data
$sql = "SELECT * FROM users WHERE user_id=$user_id";
$result = mysqli_query($link,$sql);
$count = mysqli_num_rows($result);
if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $email = $row['email'];
    $username = $row['username'];
}
else{
  echo "There was an error retrieving the username and email";
}
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
    <link href="mainpage.css" rel="stylesheet">
  </head>
  <body>
  <!-- Navygation Bar -->
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
<div class="container-fluid">
<a class="navbar-brand" href="#">Online Notes</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Help</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact us</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" href="mainpage.php">My Notes</a>
      </li>   
    </ul>
    
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="#loginas" data-bs-toggle="modal">Login as <strong><?php echo $username?></strong></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?logout=1" data-bs-toggle="modal">Log out</a>
    </li> 
    </ul>
  </div>  
</div> 
</nav>

<!-- Notes -->
<div class="container position-fixed" id="container">
  <!-- Alert message -->
  <div id="alert" class="alert alert-danger collapse">
    <a class='close' data-bs-dismiss="alert">&times;</a>
    <p id="alertContent"></p>
  </div>
  <div class="row justify-content-md-center">
     <div class="col-md-8">
       <div>
       <button type="button" class="btn btn-lg" id="addnotes">Add Notes</button>
       <button type="button" class="btn btn-lg" id="allnotes">All Notes</button>
       <button type="button" class="btn btn-lg" id="edit">Remove</button>
       <button type="button" class="btn btn-lg" id="done">Done</button>
       </div>
       <div class="mt-4 col-md-12" id="notepad">
         <textarea rows="10" class="form-control" id="textarea"></textarea>
       </div>
       <div class='notes' id="notes">
         <!-- Ajax call for notes -->
       </div>
     </div>
  </div>
</div>

  <!-- Footer-->
  <div class="footer">
    <div class="container" id="footertext">
    <p>&copy; 2020 AM — Made with &#10084;for the people of the internet.
    </p>
    </div>
  </div>

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="mynotes.js"></script>
  </body>

</html>