<?php
//session_start();
include("connection.php");
//If user id or activation key is missing show error
if(!isset($_POST['user_id']) || !isset($_POST['key'])){
    echo "<div  class='alert alert-danger'>There was in error.
    Please click on the link received by email.</div>";
    echo $_GET['user_id'];
    exit;
}

$user_id = $_POST['user_id'];
$key = $_POST['key'];
$time = time()-86400;
$user_id = mysqli_real_escape_string($link,$user_id);
$key = mysqli_real_escape_string($link,$key);
// $sql = "SELECT 'user_id' FROM 'forgotpassword' WHERE 
// ('user_id' = '$user_id' AND 'key' = '$key'AND 'time' > '$time')";
$sql = "SELECT user_id FROM `forgotpassword` WHERE (`user_id` = '$user_id' AND `key` = '$key'AND `time` > '$time' AND `status`='pending')";
$result = mysqli_query($link,$sql);
//$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div  class='alert alert-danger'>There was in error inserting the user details in the database!</div>";
    exit;
}

$missingPassword1 = "<p><strong>Enter a password!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password!</strong></p>";
$invalidPassword = "<p><strong>Your password should be 6 characters long and include one capital leter and one number!</strong></p>";
$diffPassword = "<p><strong>Password don't match!</strong></p>";
$errors =""; 
$password = "";
if(empty($_POST["password1"])){
    $errors .= $missingPassword1;
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

$password = mysqli_real_escape_string($link,$password);
$password = hash('sha256', $password);
$user_id = mysqli_real_escape_string($link,$user_id);
$sql = "UPDATE users SET password = '$password' WHERE user_id='$user_id'";
$result = mysqli_query($link,$sql);
if(!$result){
   
    echo "<div class='alert alert-danger'>Error running the query!</div>";
    echo "<div class='alert alert-danger'>" . mysqli_error($link) . "</div>";
    exit;
}
$sql = "UPDATE forgotpassword SET `status` = 'used' WHERE `key`='$key' ";
$result = mysqli_query($link,$sql);
if(!$result){
    echo 1;
    echo "<div class='alert alert-danger'>Error running the query!</div>"; 
}
else{
    echo "<div class='alert alert-danger'>Your password change!<a href = 'index.php'>Login</a></div>";
    
}

?>