<?php
session_start();

require "../../function.php";
$currentId = $_SESSION["currentId"];
$fullnameVal = $_POST["fullname"];
$emailVal = $_POST["email"];
$usernameVal = $_POST["username"];
$picVal = $_FILES["image-input"];

$editStatus = editProfile($currentId, $fullnameVal, $emailVal, $usernameVal, $picVal);

if($editStatus === "updated"){
    echo "";
}else {
    echo $editStatus;
}

?>