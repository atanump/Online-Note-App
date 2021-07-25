<?php
session_start();
include("connection.php");
// Geting user id
$user_id = $_SESSION['user_id'];
$time = time();
$sql = "INSERT INTO notes (`user_id`,`note`,`time`) VALUES ($user_id,'','$time')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "error";
    exit;
}
echo mysqli_insert_id($link);
?>