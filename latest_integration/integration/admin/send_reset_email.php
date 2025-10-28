<?php
require '../DB/db.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
    die('PHPMailer is not installed or autoloaded. Run "composer require phpmailer/phpmailer" in your project root.');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        $resetLink = "http://localhost/goldbank/pages(user)/reset_password.php?token=$token";
        $subject = "Password Reset";
        // HTML email body (simple GitHub-style card with button)
        $body = '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head><body style="font-family:Arial,Helvetica,sans-serif;background:#f6f8fa;padding:24px;">'
            . '<div style="max-width:680px;margin:0 auto;">'
            . '<div style="text-align:center;margin:24px 0;">'
            . '<svg width="48" height="48" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="color:#222;"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2 .37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82a7.5 7.5 0 012.01-.27c.68 0 1.36.09 2.01.27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.28.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.19 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/></svg>'
            . '</div>'
            . '<div style="background:#fff;border-radius:6px;padding:28px;border:1px solid #e1e4e8;">'
            . '<h2 style="margin-top:0;margin-bottom:8px;font-size:20px;text-align:center;">Password Configuration</h2>'
            . '<p style="color:#24292e;line-height:1.4;margin-top:0;text-align:center;">We heard that you lost your password. Use the button below to reset it.</p>'
            . '<div style="text-align:center;margin:24px 0;">'
            . '<a href="' . htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8') . '" style="display:inline-block;padding:12px 20px;background:#2ea44f;color:#fff;border-radius:6px;text-decoration:none;font-weight:600;">Reset your password</a>'
            . '</div>'
            . '<p style="font-size:13px;color:#6a737d;text-align:center;">If you don\'t use this link within 1 hour, it will expire.</p>'
            . '<p style="font-size:13px;color:#6a737d;margin-bottom:0;text-align:center;">Thanks,<br>The GoldBank Team</p>'
            . '</div>'
            . '<p style="text-align:center;color:#6a737d;font-size:12px;margin-top:12px;">You\'re receiving this email because a password reset was requested for your account.</p>'
            . '</div></body></html>';

        $mail = new PHPMailer(true);
        try {
            // Enable verbose debug output for diagnosis (will be logged to PHP error log)
            $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
            // Capture debug output into a variable via closure so we can display a short summary
            $smtpDebugLog = '';
            $mail->Debugoutput = function($str, $level) use (&$smtpDebugLog) {
                $entry = sprintf("[%s] %s\n", $level, $str);
                error_log('PHPMailer debug: ' . $entry);
                $smtpDebugLog .= $entry;
            };
            // SMTP config
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thisnotforschool@gmail.com';
            $mail->Password = 'tffl amqk ywex ehfc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('thisnotforschool@gmail.com', 'GoldBank');
            $mail->addAddress($email);
            $mail->Subject = $subject;
            // Send HTML email and provide a plain-text alternative
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Body = $body;
            $mail->AltBody = "Reset your password\n\nUse this link: $resetLink\n\nIf you don't use this link within 3 hours, it will expire.\n\nThanks,\nGoldBank";

            $mail->send();
            $message = "Password reset link has been sent. Please check your email.";
        } catch (Exception $e) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
            // Append a short slice of SMTP debug for quick diagnostics (avoid huge dumps)
            if (!empty($smtpDebugLog)) {
                $slice = substr($smtpDebugLog, -2000); // last 2000 chars
                $error .= "\nSMTP debug (last lines):\n" . htmlspecialchars($slice);
            }
        }
    } else {
        $error = "Email not found.";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        body { background: #f7f7f7; }
        .login-card { box-shadow: 0 2px 16px rgba(0,0,0,0.07); border-radius: 12px; text-align: center; }
        /* center all text inside the card */
        .login-card, .login-card * { text-align: center; }
        .login-title { font-size: 1.4rem; font-weight: 600; margin-bottom: 18px; }
        .login-form { text-align: center; }
        .login-form label { display:block; margin-bottom:6px; }
        .login-form input { margin: 8px auto 12px; display:block; text-align:center; }
        .login-btn { width: 100%; margin: 0 auto; display: inline-block; }
    </style>
</head>
<body>
    <div class="login-outer" style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;width:100vw;">
        <div class="login-card" style="text-align:center;">
            <?php if (!empty($message)) { ?>
                <div style="margin-bottom:10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><path d="M20 6L9 17l-5-5"/></svg>
                    <div style="color:#28a745;font-size:1.1rem;"> <?= htmlspecialchars($message) ?> </div>
                </div>
            <?php } ?>
            <?php if (!empty($error)) { ?>
                <div style="color:#d9534f;margin-bottom:10px;"> <?= htmlspecialchars($error) ?> </div>
            <?php } ?>
            <div class="login-subtitle"><a href="login.php">Back to login</a></div>
        </div>
    </div>
</body>
</html>
