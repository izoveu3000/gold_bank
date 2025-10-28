<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        body { background: #f7f7f7; }
        .login-card { box-shadow: 0 2px 16px rgba(0,0,0,0.07); border-radius: 12px; }
        .login-title { font-size: 1.4rem; font-weight: 600; margin-bottom: 18px; }
        .login-form input { margin-bottom: 12px; }
        .login-btn { width: 100%; }
    </style>
</head>
<body>
    <div class="login-outer" style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;width:100vw;">
        <div class="login-card">
            <div class="login-title">Forgot your password?</div>
            <form class="login-form" method="post" action="send_reset_email.php">
                <div class="login-subtitle" style="margin-bottom:14px;">Enter your email to receive reset password link</div>
                <input type="email" name="email" placeholder="Enter your email" required>
                <button class="login-btn" type="submit">Send Reset Link</button>
            </form>
            <div class="login-subtitle"><a href="login.php">Back to login</a></div>
        </div>
    </div>
</body>
</html>
