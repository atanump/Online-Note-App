<?php
// If the user is not logged in and remember me cookie exists
if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){
    // f1:COOKIE: $a.",".bin2hex($b)
    // f2:hash('sha256', $a)
    // extract $authentificator1 & $authentificator2 from the cookie
    list($authentificator1,$authentificator2) = explode(',',$_COOKIE['rememberme']);
    $authentificator2 = hex2bin($authentificator2);
    $f2authentificator2 = hash('sha256',$authentificator2);

    // Look for $authentificator1 in rememberme table
    $sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1'";
    $result = mysqli_query($link,$sql);
    if(!$result){
        echo "<div class='alert alert-danger'>There was an error running the query!</div>";
        exit;
    }
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo "<div class='alert alert-danger'>Remember me process failed!</div>";
        exit;
    }
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(!hash_equals($row['f2authentificator2'], $f2authentificator2)){
        echo "<div class='alert alert-danger'>hash_equals return false!</div>";
    }
    else{
        echo "no";
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
        $_SESSION['user_id'] = $row['user_id'];
        $f2authentificator2 = f2($authentificator2);
        $user_id = $_SESSION['user_id'];
        $expiration = date('Y-m-d H:i:s', time()+1296000);
        $sql = "INSERT INTO rememberme(authentificator1, f2authentificator2,user_id,expires) VALUES ('$authentificator1',
        '$f2authentificator2', '$user_id', '$expiration')";
        $result = mysqli_query($link,$sql);
        if(!$result){
            echo "<div class='alert alert-danger'>Error storing the query!</div>";
        }
        header("location:mainpage.php");
    }

}
// else{
//     echo "<div class='alert alert-danger'>".$_SESSION['user_id']."</div>";
//     echo "<div class='alert alert-danger'>".$_COOKIE['rememberme']."</div>";
// }
?>