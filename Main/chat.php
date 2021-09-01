<?php
session_start();
require "function.php";

if(!isset($_SESSION["currentId"])){
    header("Location:index.php");
    exit;
}

// get id friend from Get
$targetId = $_GET["user-target-id"];

// user id initialization
$currentUserId = $_SESSION["currentId"];

// get user info from function
$getRow = getUserInfo($currentUserId);

// get user target/friend info from function
$getRowFriend = getUserInfo($targetId);

// get details friend
$userFriendImage = $getRowFriend['profile_image'];
$userFriendFullName = $getRowFriend['fullname'];

// get user message
$messageContent = getMessageContent($currentUserId, $targetId);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oww Chat</title>
    <link rel="stylesheet" href="style/reset.css">
    <link rel="stylesheet" href="style/chat.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <div class="body-container">
        <main class="conversation">
            <header class='friend-profile'>
                <div class='container'>
                    <div class='friend-content'>
                        <span class="user-target-id" style="display: none;"><?php echo $targetId ?></span>
                        <i class="ri-arrow-left-line"></i>
                        <div class='friend-image'>
                            <img src='img/<?php echo $userFriendImage ?>' alt='profile-image'>
                        </div>
                        <div class='friend-info'>
                            <h3 class='name'><?php echo $userFriendFullName ?></h3>
                            <div class='status'>
                                <span class='indicator'></span>
                                <span class='indicator-desc'>Online</span>
                            </div>
                        </div>
                    </div>
                    <div class='option-toggle'>
                        <i class="ri-more-2-fill"></i>
                    </div>
                </div>
            </header>
            <section class='conversation-area'>
                <div class='container'>
                <?php if($messageContent === "no message") : ?>
                    <p style="display: flex; height:100%; justify-content:center; align-items:center; margin-top:0.25rem;">Start your message</p>
                <?php else:?>
                    <?php $messageList = $messageContent; ?>
                    <?php foreach($messageList as $message) :?>
                        <?php if($message["from_id"] === $currentUserId and $message["to_id"] === $targetId): ?>
                            <div class="sent">
                                <p class="message"><?php echo $message["text"] ?></p>
                            </div>
                        <?php else :?>
                            <div class="reply">
                                <p class="message"><?php echo $message["text"] ?></p>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
                </div>
            </section>
            <section class='send-area'>
                <div class='container'>
                    <input type='text' name='input-message' id='input-message' placeholder='Start typing your message' autocomplete='off' required>
                    <button type='button' id='submit-message'>                           
                        <i class='ri-send-plane-fill'></i>
                    </button>
                </div>
            </section>
        </main>
        <div class="message-status"></div>
        <div class="edit-status"></div>
    </div>
    <script src="script/chat.js"></script>
</body>
</html>