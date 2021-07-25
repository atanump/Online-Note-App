<?php
session_start();
include("connection.php");
$user_id = $_SESSION['user_id'];
$newemail = $_POST['newemail'];
$sql = "SELECT * FROM users WHERE email = '$newemail'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);
if($count>0){
    echo "<div class='alert alert-danger'>This email already exist!</div>";
    exit;
}
$sql = "SELECT * FROM users WHERE user_id=$user_id";
  $result = mysqli_query($link,$sql);
  $count = mysqli_num_rows($result);
  if($count == 1){
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $email = $row['email'];
      $username = $row['username'];
  }
  else{
    echo "There was an error retrieving the email";
  }
$activationkey = bin2hex(openssl_random_pseudo_bytes(16));
$sql = "UPDATE users SET activation2 = '$activationkey' WHERE user_id = $user_id";
$result = mysqli_query($link,$sql);
if(!$result){
    echo "<div class=' alert alert-danger'>There is an error entering in database</div>";
}
else{
    // Send the user an email with activation link
$message = "Please click on this link to activate your account:\n\n";
$message .= "http://localhost/notebook/activenew.php?email=".urlencode($email)."&newemail=".urlencode($newemail)."&key=$activationkey";
// $message .= "https://www.notebook.cybrancee.com/activenew.php?email=".urlencode($email)."&newemail=".urlencode($newemail)."&key=$activationkey";
//$headers = "From:atanu3432@gmail.com";
$headers = "From:welcome@notebook.cybrancee.com";
if(mail($newemail,'Confirm your Registration',$message,$headers)){
    echo "<div class=' alert alert-danger'>Thanks for your registration! A confirmation email has been 
    send to $newemail. Please click on the activation link to active your account. </div>";
}
else{
    echo "<div  class='alert alert-danger'>There was a error sending a mail!</div>";
}
}

?>