<?php
require "../../function.php";

// call login function
$loginStatus = login($_POST["username"], $_POST["password"]);

if($loginStatus === "found"){
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
    echo $loginStatus;
}


?>