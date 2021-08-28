<?php
require "../../function.php";

$searchStatus =  searchUser($_GET["inputVal"]);

if($searchStatus === "not found"){
    echo "<p>User not found</p>";
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
        $userClass = "user";
        $userImageClass = "image-field";
        $userInfoClass = "info-field";
        echo "<div class=$userClass>
                <div class=$userImageClass>
                    <img src=$imagePath>
                </div>
                <div class = $userInfoClass>
                    <h1>$username</h1> 
                    <p>$fullname</p> 
                    <p class='user-id' style='display:none;'>$userid</p>
                </div>
              </div>";
    }
}

?>