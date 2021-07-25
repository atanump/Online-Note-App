<?php
session_start();
include("connection.php");
// Get the user id
$user_id = $_SESSION['user_id'];
// Run query to delete empty note
$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error running the query!</div>";
    exit;
}
// Run query to look for notes corresponding to user_id
$sql = "SELECT * FROM `notes` WHERE user_id = '$user_id' ORDER BY `time` DESC";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error running the query!</div>";
    exit;
}

if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
        // Show notes
        $note_id = $row['id'];
        $note = $row['note'];
        $time = $row['time'];
        $time = date("F d,Y h:i:s A", $time);
        echo "<div class='note' style = 'width:100%'>
        <div class='noteheader' id='$note_id'>
        <div class='text'>$note</div>
        <div class='timetext'>$time</div>
        </div>
        <div class='delete'>
        <button class='btn-lg btn-danger'>delete</button>
        </div>
        </div>";
    }
}
else{
    echo "<div class='text'>You did not create any note!</div>";
}

?>