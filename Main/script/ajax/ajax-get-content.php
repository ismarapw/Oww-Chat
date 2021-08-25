<?php
require "../../function.php";

$userId = $_GET["userId"];

// get user info from function
$getRow = getUserInfo($userId);

// get details
$userImage = $getRow['profile_image'];
$userFullName = $getRow['fullname'];

echo "
<header class='friend-profile'>
    <div class='container'>
        <div class='friend-content'>
            <div class='friend-image'>
                <img src='img/$userImage' alt='profile-image'>
            </div>
            <div class='friend-info'>
                <h3 class='name'>$userFullName</h3>
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
</section>"
?>
<!-- <div class="sent">
            <p class="message">Xiu, Can we meet up on sunday?</p>
        </div>
        <div class="reply">
            <p class="message">Sure, but for what ?</p>
        </div>
        <div class="reply">
            <p class="message">Btw, do you make money through photography?</p>
        </div>
        <div class="sent">
            <p class="message">To discuss the business that we will build</p>
        </div>
        <div class="sent">
            <p class="message">Yes, exactly i make money through photograpy every week.</p>
        </div>
        <div class="reply">
            <p class="message">Ohh, oke i see you later, give me further information for the location</p>
        </div>
        <div class="reply">
            <p class="message">Wow that’s amazing</p>
        </div>
        <div class="sent">
            <p class="message">Okey, i’ll call you back later</p>
        </div>
        <div class="sent">
            <p class="message">Xiu, Can we meet up on sunday?</p>
        </div>
        <div class="reply">
            <p class="message">Sure, but for what ?</p>
        </div>
        <div class="reply">
            <p class="message">Btw, do you make money through photography?</p>
        </div>
        <div class="sent">
            <p class="message">To discuss the business that we will build</p>
        </div>
        <div class="sent">
            <p class="message">Yes, exactly i make money through photograpy every week.</p>
        </div>
        <div class="reply">
            <p class="message">Ohh, oke i see you later, give me further information for the location</p>
        </div>
        <div class="reply">
            <p class="message">Wow that’s amazing</p>
        </div>
        <div class="sent">
            <p class="message">Okey, i’ll call you back later</p>
        </div> -->