<?php
session_start();
include('connection.php');
// Define Error message
$missingEmail = "<p><strong>Please enter a email address!</strong></p>";
$invalidEmail = "<p><strong>Please enter a valid email address!</strong></p>";

// Getting emain and password from form
$email = "";
$errors = "";
if(empty($_POST["enterEmail"])){
    $errors .= $missingEmail;
}
else{
    $email = filter_var($_POST["enterEmail"],FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}
if($errors){
    $resultMessage = '<div class="alert alert-danger">'. $errors .'</div>';
    echo $resultMessage;
    exit;
}

// No errors
// Prepare variables for queries
$email = mysqli_real_escape_string($link,$email);

// If email already exist in users table
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>Error running the query!</div>";
    echo "<div class='alert alert-danger'>" . mysqli_error($link) . "</div>";
    exit;
}
$count = mysqli_num_rows($result);
if($count != 1){
    echo"<div class='alert alert-danger'>This email does not exist!</div>";
    exit;
}

$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$user_id = $row['user_id'];


// Creating activation code
$activationkey = bin2hex(openssl_random_pseudo_bytes(16));
$time = time();
$status = 'pending';
// Insert user details in users table
// $sql = "INSERT INTO forgotpassword (user_id, key, time,status)
// VALUES ('$user_id','$activationkey','$time','$status')";

$sql = "INSERT INTO `forgotpassword`(`user_id`, `key`, `time`, `status`) VALUES ('$user_id','$activationkey','$time','$status')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div  class='alert alert-danger'>There was in error inserting the user details in the database!</div>";
    exit;
}

// Send the user an email with activation link
$message = "Please click on this link to reset your password:\n\n";
$message .= "http://localhost/notebook/resetpassword.php?user_id=$user_id&key=$activationkey";
// $message .= "https://www.notebook.cybrancee.com/resetpassword.php?user_id=$user_id&key=$activationkey";
$headers = "From:welcome@notebook.cybrancee.com";
if(mail($email,'Reset your password',$message,$headers)){
    echo "<div class=' alert alert-success'>Thanks for your submission! A confirmation email has been 
    send to $email. Please click on the link to reset your password. </div>";
}
else{
    echo "<div  class='alert alert-danger'>There was a error sending a mail!</div>";
}

?>