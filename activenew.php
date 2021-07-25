?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Acount Activation</title>
    <link href="active.css" rel="stylesheet">
  </head>
  <body>
      <div>
          <h1>Acount Activation</h1>
      </div>
    <!-- Footer -->
    <div class="footer">
    <div class="container" id="footertext">
    <p>&copy; 2020 AM — Made with &#10084;for the people of the internet.</p>
    </div>
    </div>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    
  </body>
</html>
<?php
session_start();
include('connection.php');

// If email or activation key is missing show error
if(!isset($_GET['email']) || !isset($_GET['key']) || !isset($_GET['newemail'])){
    echo "<div class='container msg'><div  class='alert alert-danger'>There was an error.
    Please click on the activation link received by email.</div>
    <div><a class='btn btn-lg btn-primary'href='index.php'>Goto-Mainpage</a></div></div></div>";
    exit;
}

$email = $_GET['email'];
$newemail = $_GET['newemail'];
$key = $_GET['key'];
$newemail = mysqli_real_escape_string($link,$newemail);
$key = mysqli_real_escape_string($link,$key);
$sql = "UPDATE users SET email = '$newemail',activation2='0' WHERE 
(email = '$email' AND activation2 = '$key') LIMIT 1";
$result = mysqli_query($link,$sql);
// If query is successuful. show successes msg
if(mysqli_affected_rows($link) == 1){
    session_destroy();
    setcookie("rememberme","",time()-3600);
    echo "<div class='container msg'><div  class='alert alert-success'>Your email has been updated.</div>
    <div><a class='btn btn-lg btn-success'href='index.php'>Login</a></div></div>";
}
else{
    echo "<div class='container msg'><div  class='alert alert-danger'>Error! we are unable to change your email.</div>
    <div><a class='btn btn-lg btn-primary'href='index.php'>Goto-Mainpage</a></div></div></div>";
}

?>