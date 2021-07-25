<?php
session_start();
include("connection.php");
$user_id = $_SESSION['user_id'];
$errors='';
$missingCurrentpassword = "<p><strong>Missing current password!</strong></p>";
$wrongCurrentpassword = "<p><strong>Wrong current current password!</strong></p>";
$missingPassword1 = "<p><strong>Enter a password!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password!</strong></p>";
$invalidPassword = "<p><strong>Your password should be 6 characters long and include one capital leter and one number!</strong></p>";
$diffPassword = "<p><strong>Password don't match!</strong></p>";

if(empty($_POST["currentpassword"])){
    $errors .= $missingCurrentpassword;
}
else{
    $currentPassword = $_POST["currentpassword"];
    $currentPassword = filter_var($currentPassword,FILTER_SANITIZE_STRING);
    $currentPassword = mysqli_real_escape_string($link,$currentPassword);
    $currentPassword = hash('sha256',$currentPassword);
    $sql = "SELECT `password` FROM users WHERE user_id = $user_id";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo "<div> There was a problam running the query!</div>";
    }
    else{
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($currentPassword != $row['password']){
            $errors .= $wrongCurrentpassword;
        }
        else{
            if(empty($_POST["newupdatepassword1"])){
                $errors .= $missingPassword1;
            }
            else if(!(strlen($_POST["newupdatepassword1"]) > 6 and preg_match("/[A-Z]/",$_POST["newupdatepassword1"]) and preg_match('/[0-9]/',$_POST["newupdatepassword1"]))){
                $errors .= $invalidPassword;
            }
            else{
                $password = filter_var($_POST["newupdatepassword1"],FILTER_SANITIZE_STRING);
                if(empty($_POST["newupdatepassword2"])){
                    $errors .= $missingPassword2;
                }
                else{
                    $password2 = filter_var($_POST["newupdatepassword2"],FILTER_SANITIZE_STRING);
                    if($password !== $password2){
                        $errors .= $diffPassword;
                    }
                }
            }
        }
    }
}

if($errors){
    $resultMessage = '<div class="alert alert-danger">'. $errors .'</div>';
    echo $resultMessage;
    exit;
}
else{
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256',$password);
    $sql = "UPDATE users SET password = '$password' WHERE user_id = $user_id";
    $result = mysqli_query($link,$sql);
    if(!$result){
        echo '<div class="alert alert-danger">The password cannot be reset</div>';
    }
    else{
        echo '<div class="alert alert-success">The password successes fully change!</div>';
    }
}
?>