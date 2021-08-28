<?php
session_start();

require "../../function.php";
$currentId = $_SESSION["currentId"];
$userId = $_GET["userId"];

// get user info from function
$getRow = getUserInfo($userId);

// get details
$userImage = $getRow['profile_image'];
$userFullName = $getRow['fullname'];

// get user message
$messageContent = getMessageContent($currentId, $userId);

?>
<header class='friend-profile'>
    <div class='container'>
        <div class='friend-content'>
            <div class='friend-image'>
                <img src='img/<?php echo $userImage ?>' alt='profile-image'>
            </div>
            <div class='friend-info'>
                <h3 class='name'><?php echo $userFullName ?></h3>
                <div class='status'>
                    <span class='indicator'></span>
                    <span class='indicator-desc'>Online</span>
                </div>
            </div>
        </div>
        <div class='option-toggle'>
            <div class='three-dots'></div>
            <div class='three-dots'></div>
            <div class='three-dots'></div>
        </div>
    </div>
</header>
<section class='conversation-area'>
    <div class='container'>
    <?php if($messageContent === "no message") : ?>
        <p>Start your message</p>
    <?php else:?>
        <?php $messageList = $messageContent; ?>
        <?php foreach($messageList as $message) :?>
            <?php if($message["from_id"] === $currentId and $message["to_id"] === $userId): ?>
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
        <form method='POST' class='message-form'>
            <input type='text' name='input-message' id='input-message' placeholder='Start typing your message' autocomplete='off' required>
            <button type='button' id='submit-message'>                           
                <i class='ri-send-plane-fill'></i>
            </button>
        </form>
    </div>
</section>