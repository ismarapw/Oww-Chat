<?php
session_start();
require "../../function.php";

$currentId = $_SESSION["currentId"];

$searchStatus =  searchUser($_GET["inputVal"],$currentId);

if($searchStatus === "not found"){
    echo "<p>Username not found</p>";
}else if($searchStatus === "blank value"){
    echo "";
}else {
    $userList = $searchStatus;
    foreach($userList as $user){
        $userid = $user["user_id"];
        $username = $user["username"];
        $fullname = $user["fullname"];
        $userImg = $user["profile_image"];
        $imagePath = "img/$userImg";
        $href = "chat.php?user-target-id=$userid";
        $userClass = "user";
        $userImageClass = "image-field";
        $userInfoClass = "info-field";
        echo "<a class=$userClass href=$href>
                <div class=$userImageClass>
                    <img src=$imagePath>
                </div>
                <div class = $userInfoClass>
                    <h1>$username</h1> 
                    <p>$fullname</p> 
                </div>
              </>";
    }
}

?>