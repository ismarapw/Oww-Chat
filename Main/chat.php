<?php
session_start();
require "function.php";

if(!isset($_SESSION["currentId"])){
    header("Location:index.php");
    exit;
}

// user id initialization
$currentUserId = $_SESSION["currentId"];

// get user info from function
$getRow = getUserInfo($currentUserId);

// get user list from function

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
        <aside class="persons-chat">
            <header class="profile">
                <div class="container">
                    <div class="profile-content">
                        <div class="profile-image">
                            <img src="img/<?php echo $getRow["profile_image"]; ?>" alt="profile-image">
                        </div>
                        <div class="profile-info">
                            <h3 class="name"><?php echo $getRow["fullname"]; ?></h3>
                            <div class="status">
                                <span class="indicator"></span>
                                <span class="indicator-desc">Online</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-edit-toggle">
                        <i class="ri-edit-2-line"></i>
                    </div>
                </div>
            </header>
            <section class="search">
                <div class="container">
                    <div class="search-box">
                        <i class="ri-search-line"></i>
                        <input type="text" name="search-input" id="search-input" placeholder="Find Someone" autocomplete="off">
                    </div>
                    <div class="search-result"></div>
                </div>
            </section>
            <section class="friends">
                <div class="container">
                     <!-- <div class="friend-content">
                        <div class="friend-image">
                            <img src="img/user-friend.png" alt="friend-image">
                        </div>
                        <div class="friend-last-chat">
                            <h3 class="name">Missxiu</h3>
                            <p class="last-message">Okey, i’ll call you back later</p>
                        </div>
                    </div> -->
                </div>
            </section>
            <nav class="edit-profile">
                <div class="container">
                    <header>
                        <div class="title">
                            <h1 class="main-title">Edit Profile</h1>
                            <p class="desc-title">Change your profile details</p>
                        </div>
                        <div class="close-btn">
                            <i class="ri-close-line"></i>
                        </div>
                    </header>
                    <section class="profile-edit">
                        <div class="edit-form">
                            <form action="" method="POST">
                                <div class="image-field">
                                    <div class="user-image">
                                        <img src="img/<?php echo $getRow["profile_image"]; ?>" alt="user-profile">
                                        <label for="image-input" class="upload-image">Choose a file</label>
                                    </div>
                                    <input type="file" name="image-input" id="image-input" style="display: none;">
                                </div>
                                <div class="fullname-field">
                                    <label for="fullname" class="label-fullname">Fullname</label>
                                    <input type="text" name="fullname" id="fullname" placeholder="Fullname" required value="<?php echo $getRow["fullname"]; ?>">
                                </div>
                                <div class="email-field">
                                    <label for="email" class="label-email">Email</label>
                                    <input type="email" name="email" id="email" placeholder="Email" required value="<?php echo $getRow["email"]; ?>">
                                </div>
                                <div class="username-field">
                                    <label for="username" class="label-username">Username</label>
                                    <input type="username" name="username" id="username" placeholder="username" required value="<?php echo $getRow["username"]; ?>">
                                </div>
                                <div class="submit-btn">
                                    <button type="button" class="submit">Edit</button>
                                    <button type="button" class="discard">Discard</button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </nav>
        </aside>
        <main class="conversation"></main>
        <div class="message-status"></div>
    </div>
    <script src="script/chat.js"></script>
</body>
</html>