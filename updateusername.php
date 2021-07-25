<?php
session_start();
$missingUsername = "<p><strong>Please enter a username!</strong></p>";
$errors='';
include("connection.php");
$user_id = $_SESSION['user_id'];
if(empty($_POST["newusername"])){
    $errors .= $missingUsername;
}
if($errors){
    $resultMessage = '<div class="alert alert-danger">'. $errors .'</div>';
    echo $resultMessage;
    exit;
}
$username = $_POST['newusername'];
$sql = "UPDATE users SET username = '$username' WHERE user_id='$user_id'";
$result = mysqli_query($link,$sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error running the query!</div>";
    exit;
}
?>