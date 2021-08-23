<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/reset.css">
    <link rel="stylesheet" href="style/index.css">
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
                    <h1 class="auth-desc">Hey,<br>Login Now.</h1>
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
                    <h1 class="welcoming-text">Welcome Back</h1>
                    <p class="welcoming-desc">Enter your credentials to access your account</p>
                </div>
                <div class="login-form">
                    <form action="" method="POST" class="login-form" id="form-inputs">
                        <div class="username-field">
                            <label for="username" class="label-username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="password-field">
                            <label for="password" class="label-password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="cookie-field">
                            <input type="checkbox" name="cookie" id="cookie">
                            <label for="cookie" class="label-cookie">Remember me?</label>
                        </div>
                        <div class="button-field">
                            <button type="button" name="button" id="submit-button">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <div class="status"></div>
    </div> 
    <script src="script/index.js"></script>    
</body>
</html>