<?php
// Connect to database
$link = mysqli_connect("localhost","root","","onlinenotes");
if(mysqli_connect_error()){
    die("Error".mysqli_connect_error());
}
?>