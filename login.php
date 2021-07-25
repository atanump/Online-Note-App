<?php
session_start();
include("connection.php");

// Error message
$missingEmail = "<p><strong>Please enter your email address!</strong></p>";
$missingPassword = "<p><strong>Please enter your password!</strong></p>";

// Getting emain and password from form
$email = "";
$password = "";
$errors = "";
if(empty($_POST["loginEmail"])){
    $errors .= $missingEmail;
}
else{
    $email = filter_var($_POST["loginEmail"],FILTER_SANITIZE_EMAIL);
}
if(empty($_POST["password"])){
    $errors .= $missingPassword;
}
else{
    $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
}
if($errors){
    $resultMessage = '<div class="alert alert-danger">'. $errors .'</div>';
    echo $resultMessage;
    exit;
}

// No errors
// Prepare variables for queries
$email = mysqli_real_escape_string($link,$email);
$password = mysqli_real_escape_string($link,$password);
$password = hash('sha256', $password);

// Check email and password exist and is account activated
$sql = "SELECT * FROM users WHERE email = '$email' AND password ='$password' AND activation = 'activated'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>Error running the query!</div>";
    echo "<div class='alert alert-danger'>" . mysqli_error($link) . "</div>";
    exit;
}
$count = mysqli_num_rows($result);
if($count !== 1){
    echo"<div class='alert alert-danger'>Wrong username or password.</div>";
}
else{
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];
    if(empty($_POST["rememberme"])){
        echo 'success';
    }
    else{
        $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
        $authentificator2 = openssl_random_pseudo_bytes(20);
        // Store then in a cookie
        function f1($a, $b){
            $c = $a .",". bin2hex($b);
            return $c;
        }
        $cookieValue = f1($authentificator1, $authentificator2);
        setcookie(
            "rememberme",
            $cookieValue,
            time() + 1296000,

        );
        // Run query to store in remember table
        function f2($a){
            return hash('sha256', $a);
        }
        $f2authentificator2 = f2($authentificator2);
        $user_id = $_SESSION['user_id'];
        $expiration = date('Y-m-d H:i:s', time()+1296000);
        $sql = "INSERT INTO rememberme(authentificator1, f2authentificator2,user_id,expires) VALUES ('$authentificator1',
        '$f2authentificator2', '$user_id', '$expiration')";
        $result = mysqli_query($link,$sql);
        if(!$result){
            echo "<div class='alert alert-danger'>Error storing the query!</div>";
        }
        else{
            echo "success";
        }
    }

}

?>