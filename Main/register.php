<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Style/reset.css">
    <link rel="stylesheet" href="Style/register.css">
</head>
<body>
    <div class="body-container">
        <aside class="side-content">
            <div class="container">
                <div class="brand">
                    <h1 class="brand-name">oww.</h1>
                    <p class="brand-sub-name">Chat Application</p>
                </div>
                <div class="auth">
                    <h1 class="auth-desc">New User,<br>Register Now.</h1>
                    <div class="auth-option">
                        <a class="login" href="index.php">Login</a>
                        <a class="sign-up" href="register.php">Sign Up</a>
                    </div>
                </div>
                <div class="owner">
                    <h3 class="owner-desc">Copyright 2021 by @ismarapw</h3>
                </div>
            </div>
        </aside>
        <main class="main-content">
            <div class="container">
                <div class="welcoming">
                    <h1 class="welcoming-text">Welcome to Oww Chat.</h1>
                    <p class="welcoming-desc">Enter your credentials to register your account</p>
                </div>
                <div class="register-form">
                    <form action="" method="POST">
                        <div class="image-field">
                            <div class="image-upload">
                                <img src="img/user-default.svg" alt="user-default">
                                <label for="profile-image" class="upload-img">Choose a file</label>
                            </div>
                            <input type="file" name="profile-image" id="profile-image" placeholder="profile-image" style="display:none;">
                        </div>
                        <div class="fullname-field">
                            <label for="fullname" class="label-fullname">Fullname</label>
                            <input type="text" name="fullname" id="fullname" placeholder="Fullname" required>
                        </div>
                        <div class="email-field">
                            <label for="email" class="label-email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email" required>
                        </div>
                        <div class="username-field">
                            <label for="username" class="label-username">Username</label>
                            <input type="username" name="username" id="username" placeholder="username" required>
                        </div>
                        <div class="password-field">
                            <label for="password" class="label-password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="button-field">
                            <button type="button" name="button" class="sign-up">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div> 
    <script src="Script/index.js"></script>    
</body>
</html>