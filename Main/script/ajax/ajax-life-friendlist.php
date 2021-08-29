<?php
session_start();

require "../../function.php";
$currentId = $_SESSION["currentId"];

$getRowFriendList = getUserFriendList($currentId);


?>
<?php if($getRowFriendList === "no friend yet") : ?>
    <p style="display: flex; height:100%; justify-content:center; margin-top:1rem;">No chat list yet</p>
<?php else : ?>
    <?php foreach($getRowFriendList as $friend) :?>
        <div class="friend-content">
            <div class="friend-image">
                <img src="img/<?php echo $friend["profile_image"] ?>" alt="friend-image">
            </div>
            <div class="friend-last-chat">
                <h3 class="name"><?php echo $friend["fullname"] ?></h3>
                <?php  $lastMessage = getLastMessage($currentId, $friend["user_id"]); ?>
                <p class="last-message"><?php echo $lastMessage ?></p>
            </div>
            <div class="user-id" style="display: none;"><?php echo $friend["user_id"] ?></div>
        </div>
    <?php endforeach ?>
<?php endif ?>