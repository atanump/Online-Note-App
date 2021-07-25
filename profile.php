<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("location:index.php");
}
  include("connection.php");
  $user_id = $_SESSION['user_id'];
  
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
    <!-- CSS stylesheet -->
    <link href="profile.css" rel="stylesheet">
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
        <a class="nav-link" href="#">Profile</a>
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
        <a class="nav-link" href="#loginas" data-bs-toggle="modal">Login as  <strong><?php echo $username?></strong></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?logout=1" data-bs-toggle="modal">Log out</a>
    </li> 
    </ul>
  </div>  
</div> 
</nav>

<!-- My profile table -->
<div class="container position-fixed" id="container">
  <div class="row justify-content-md-center col-md-6">
  <h1>General Account Seting:</h1>
     <div class="table-responsive">
         <table class="table table-hover table-bordered">
             <tr data-bs-target="#updateusername" data-bs-toggle="modal">
                 <td >Username:</td>
                 <td><?php echo $username?></td>
             </tr>
             <tr data-bs-target="#updateemail" data-bs-toggle="modal">
                 <td>Email:</td>
                 <td><?php echo $email?></td>
             </tr>
             <tr data-bs-target="#updatepassword" data-bs-toggle="modal">
                 <td>Password</td>
                 <td>********</td>
             </tr>
         </table>
     </div>
  </div>
  <div><p class='container' style="color: red; font-size:20px">* To change Username, Email or Password click on item in Table</p></div>
</div>


<!-- Update User Name Model -->
<form method="POST" id="updateusernameform">
<div class="modal fade" id="updateusername" tabindex="-1" aria-labelledby="mymodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="updateusernameLabel">Update Username:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Update username error or successfull msg -->
      <div id="updateusernamemsg"></div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <input type="text" class="form-control" id="newusername" name="newusername" placeholder="New username" maxlength="20">
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

<!-- Update email Model -->
<form method="POST" id="updateemailform">
<div class="modal fade" id="updateemail" tabindex="-1" aria-labelledby="mymodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="updateemailLabel">Update your Email:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Update email error or successfull msg -->
      <div id="updateemailmsg"></div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <input type="email" class="form-control" id="newemail" name="newemail" placeholder="Enter new email">
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

<!-- update Password Model-->
<form method="POST" id="updatepasswordform">
<div class="modal fade" id="updatepassword" tabindex="-1" aria-labelledby="mymodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatepasswordLabel">Upadate your password:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Update password error or successfull msg -->
      <div id="updatepasswordmsg"></div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current password">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="newupdatepassword1" name="newupdatepassword1" placeholder="New password">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="newupdatepassword2" name="newupdatepassword2" placeholder="Confirm new password">
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
    <div class="container">
    <p>&copy; 2020 AM — Made with &#10084;for the people of the internet.
    </p>
    </div>
  </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="profile.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>

</html>