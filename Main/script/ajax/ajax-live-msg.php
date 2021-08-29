<?php
session_start();
require "../../function.php";

$currentId =  $_SESSION["currentId"];
$liveMessage = getMessageContent($currentId, $_GET["userId"]);

?>
<?php if($liveMessage === "no message") : ?>
    <p style="display: flex; height:100%; justify-content:center; margin-top:0.25rem;">Start your message</p>
<?php else:?>
    <?php $messageList = $liveMessage; ?>
    <?php foreach($messageList as $message) :?>
        <?php if($message["from_id"] === $currentId and $message["to_id"] === $_GET["userId"]): ?>
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