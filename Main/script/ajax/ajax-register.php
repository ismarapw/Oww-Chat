<?php
require "../../function.php";

// call register function
$registerStatus = register($_POST["fullname"],$_POST["email"],$_POST["username"], $_POST["password"], $_FILES["profile-image"]);

if($registerStatus === "inserted"){
    // get user id
    $currentUser = $_POST["username"];
    $query = "SELECT user_id from users where username = '$currentUser'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $currentId = $row["user_id"];

    // make new session
    session_start();
    $_SESSION["currentId"] = $currentId;
}else {
    // show error status
    echo $registerStatus;
}


?>