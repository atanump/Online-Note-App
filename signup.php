<?php
session_start();
include("connection.php");
// Check user input
$missingUsername = "<p><strong>Please enter a username!</strong></p>";
$missingEmail = "<p><strong>Please enter a email address!</strong></p>";
$missingPassword = "<p><strong>Enter a password!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password!</strong></p>";
$invalidEmail = "<p><strong>Please enter a valid email address!</strong></p>";
$invalidPassword = "<p><strong>Your password should be 6 characters long and include one capital leter and one number!</strong></p>";
$diffPassword = "<p><strong>Password don't match!</strong></p>";
$errors =""; 
$username = "";
$email = "";
$password = "";
// Check userinput
if(empty($_POST["username"])){
    $errors .= $missingUsername;
}
else{
    $username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
}
if(empty($_POST["inputEmail"])){
    $errors .= $missingEmail;
}
else{
    $email = filter_var($_POST["inputEmail"],FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}
if(empty($_POST["password1"])){
    $errors .= $missingPassword;
}
else if(!(strlen($_POST["password1"]) > 6 and preg_match("/[A-Z]/",$_POST["password1"]) and preg_match('/[0-9]/',$_POST["password1"]))){
    $errors .= $invalidPassword;
}
else{
    $password = filter_var($_POST["password1"],FILTER_SANITIZE_STRING);
    if(empty($_POST["password2"])){
        $errors .= $missingPassword2;
    }
    else{
        $password2 = filter_var($_POST["password2"],FILTER_SANITIZE_STRING);
        if($password !== $password2){
            $errors .= $diffPassword;
        }
    }
}
if($errors){
    $resultMessage = '<div class="alert alert-danger">'. $errors .'</div>';
    echo $resultMessage;
    exit;
}

// No errors
// Prepare variables for queries
$username = mysqli_real_escape_string($link,$username);
$email = mysqli_real_escape_string($link,$email);
$password = mysqli_real_escape_string($link,$password);
$password = hash('sha256', $password);

// If email already exist in users table
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>Error running the query!</div>";
    echo "<div class='alert alert-danger'>" . mysqli_error($link) . "</div>";
    exit;
}
$result = mysqli_num_rows($result);
if($result){
    echo"<div class='alert alert-danger'>This email already registered.</div>";
    exit;
}

// If username already exist in users table
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>Error running the query!</div>";
    exit;
   
}
$result = mysqli_num_rows($result);
    if($result){
       echo "<div class='alert alert-danger'>This username already taken.</div>";
       exit;
}

// Creating activation code
$activationkey = bin2hex(openssl_random_pseudo_bytes(16));

// Insert user details in users table
$sql = "INSERT INTO users (username, email, password,activation)
VALUES ('$username','$email','$password','$activationkey')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div  class='alert alert-danger'>There was in error inserting the user details in the database!</div>";
    exit;
}

// Send the user an email with activation link
$message = "Please click on this link to activate your account:\n\n";
//$message .= "http://localhost/notebook/activate.php?email=".urlencode($email)."&key=$activationkey";
$message .= "https://www.notebook.cybrancee.com/activate.php?email=".urlencode($email)."&key=$activationkey";

$headers = "From:welcome@notebook.cybrancee.com";
if(mail($email,'Confirm your Registration',$message,$headers)){
    echo "<div class=' alert alert-success'>Thanks for your registration! A confirmation email has been 
    send to $email. Please click on the activation link to active your account. </div>";
}
else{
    echo "<div  class='alert alert-danger'>There was a error sending a mail!</div>";
}
?>
