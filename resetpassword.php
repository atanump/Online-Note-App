<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Password Reset</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <style>
            html{
                position: relative;
                height: 100%;
            }
            body{
                background-image: url("image/notebook.jpg");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
                min-height:100%; 
                position:relative;

            }
            .footer{
                margin-top: 200px;
                bottom: 0;
                position: absolute;
                color: white;

            }
            #footertext{
                float: left;
            }
            h1{
                margin-left: 120px;
                color:rgb(13,110,253);
                background-color: rgb(228,210,190);
                width: 380px;
                height: 100px;
                font-size: 40px;
                text-align: center;
                padding-top: 20px ;
            }
            .resetform{
                width: 300px;
                margin-left: 120px;
                margin-bottom: 10px;
            }
        </style>

    </head>
    <body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Reset Password:</h1>
            <div id="resultmessage"></div>


<?php


// If user id or activation key is missing show error
if(!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo "<div  class='alert alert-danger'>There was in error.
    Please click on the link received by email.</div>";
    exit;
}

$user_id = $_GET['user_id'];
$key = $_GET['key'];
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
//echo $sql;
// If query is successuful. show successes msg
if(mysqli_affected_rows($link) == 1){
    echo "<form method=POST id='passwordreset'>
    <div class='form-control resetform'>
    <input type = 'hidden' name = 'user_id' value='$user_id'>
    <input type = 'hidden' name = 'key' value='$key'>
    <input type='password' name='password1' id='password1' placeholder='Enter your password' class='form-control'>
    </div>
    <div class='form-control resetform'>
    <input type='password' name='password2' id='password2' placeholder='Confirm your password' class='form-control'>
    </div>
    <div class='resetform'>
    <input type='submit' name='resetpassword' id='resetpassword' class='btn btn-lg btn-primary'>
    </div>
    </form>";
}
else{
    echo "<div  class='alert alert-danger'>Error!Password can not be reset.</div>";
}

?>
        </div>
    </div>
</div>

<!-- Footer -->
    <div class="footer">
    <div class="container" id="footertext">
    <p>&copy; 2020 AM — Made with &#10084;for the people of the internet.</p>
    </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <!--Script for Ajax Call to storeresetpassword.php which processes form data-->
            <script>
             //Once the form is submitted
            $("#passwordreset").submit(function(event){ 
                //prevent default php processing
                event.preventDefault();
                //collect user inputs
                var datatopost = $(this).serializeArray();
            //    console.log(datatopost);
                //send them to signup.php using AJAX
                $.ajax({
                    url: "storeresetpassword.php",
                    type: "POST",
                    data: datatopost,
                    success: function(data){

                        $('#resultmessage').html(data);
                    },
                    error: function(){
                        $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

                    }

                });

            });           
            
            </script>
        </body>
</html>
