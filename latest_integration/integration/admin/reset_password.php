<?php
require '../DB/db.php';
$token = $_GET['token'] ?? '';
$stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

$errorMsg = '';
$successMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $token = $_POST['token'] ?? $token;
    if ($newPassword !== $confirmPassword) {
        $errorMsg = 'Passwords do not match.';
    } elseif (strlen($newPassword) < 6) {
        $errorMsg = 'Password must be at least 6 characters.';
    } elseif ($user && strtotime($user['token_expires']) > time()) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expires = NULL WHERE id = ?");
        $stmt->execute([$hashedPassword, $user['id']]);
        $successMsg = 'Password successfully changed.';
        $user['reset_token'] = null;
    } else {
        $errorMsg = 'Invalid or expired token.';
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        body { background: #f7f7f7; color: #222; }
        .login-card { box-shadow: 0 2px 16px rgba(0,0,0,0.07); border-radius: 12px; max-width:560px; width:100%; margin:0 auto; }
    .reset-panel { background:#ffffff; padding:28px; border-radius:12px; border: none; }
        .reset-title { color:#111827; font-size:24px; font-weight:700; margin-bottom:8px; }
        .reset-sub { color:#586069; margin-bottom:18px; line-height:1.5 }
        .reset-sub a { color:#0366d6; text-decoration:underline; }
        .form-group { text-align:left; margin-bottom:18px; }
        label { display:block; color:#24292e; font-weight:600; margin-bottom:8px; }
        input[type=password] { width:100%; padding:12px 14px; border-radius:8px; border:1px solid #d1d5da; background:#fff; color:#24292e; }
        input[type=password]::placeholder { color:#959da5; }
        .btn-primary { display:block; width:100%; padding:12px 16px; background:#2ea44f; color:#fff; border-radius:8px; border:none; font-weight:700; font-size:16px; }
        .small-muted { color:#6a737d; font-size:13px; margin-top:10px; }
        .center { text-align:center; }
    </style>
</head>
<body>
    <div class="login-outer" style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;width:100vw;">
        <div class="login-card">
            <?php if ($user && strtotime($user['token_expires']) > time() && empty($successMsg)) : ?>
                <?php
                    // build a handle to display: use username or local part of email
                    $handle = '';
                    if (!empty($user['username'])) $handle = $user['username'];
                    else if (!empty($user['email'])) $handle = strstr($user['email'],'@',true) ?: $user['email'];
                ?>
                <div class="reset-panel center">
                    <div class="reset-title">Change password for @<?= htmlspecialchars($handle) ?></div>
                    <div class="reset-sub">Make sure it's at least 8 characters OR at least 1 characters including a number and a lowercase letter. <br></div>
                    <?php if ($errorMsg === 'Passwords do not match.') { ?>
                        <div style="color:#ff7b72; margin-bottom:10px; font-size:1rem;">Passwords do not match</div>
                    <?php } elseif (!empty($errorMsg)) { ?>
                        <div style="color:#ff7b72; margin-bottom:10px; font-size:1rem;"><?= htmlspecialchars($errorMsg) ?></div>
                    <?php } ?>

                    <form class="login-form" method="post" action="">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <div class="form-group">
                            <label for="new_password">Password</label>
                            <input id="new_password" type="password" name="new_password" placeholder="New password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm password</label>
                            <input id="confirm_password" type="password" name="confirm_password" placeholder="Confirm password" required>
                        </div>
                        <button class="btn-primary" type="submit">Change password</button>
                        <div class="small-muted">If you don't use this link within 3 hours, it will expire.</div>
                    </form>
                </div>
            <?php elseif (!empty($successMsg)) : ?>
                <div class="center" style="max-width:560px;margin:0 auto;">
                    <div style="margin-bottom:10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><path d="M20 6L9 17l-5-5"/></svg>
                        <div style="color:#28a745;font-size:1.1rem;"> <?= htmlspecialchars($successMsg) ?> </div>
                    </div>
                    <a href="login.php">Back to login</a>
                </div>
            <?php else: ?>
                <p class="center">Invalid or expired token.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
