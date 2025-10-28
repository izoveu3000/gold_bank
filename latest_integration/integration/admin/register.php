<?php
$success = false;
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../DB/db.php';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $agree = isset($_POST['agree']);
    if ($name && $email && $password && $agree) {
    // Check if email already exists
    // Database uses `user_id` as primary key; alias it to `id` so existing code continues to work
    $stmt = $conn->prepare('SELECT user_id AS id FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $errorMsg = 'Email already registered.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // The `users` table uses `user_name` for the name column and has several NOT NULL
            // columns (user_type, status, last_seen, img, phone_number). Provide sensible
            // defaults here so the INSERT succeeds.
            $insert = $conn->prepare(
                'INSERT INTO users (user_name, email, password, user_type, status, last_seen, img, phone_number)
                 VALUES (:user_name, :email, :password, :user_type, :status, :last_seen, :img, :phone_number)'
            );
            $insert->execute([
                'user_name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'user_type' => 'user',
                'status' => 'Active now',
                'last_seen' => date('Y-m-d H:i:s'),
                'img' => 'vip.jpg',
                'phone_number' => ''
            ]);
            $success = true;
        }
    } else {
        $errorMsg = 'Please fill all fields and agree to the terms.';
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-outer" style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;width:100vw;">
      <div class="login-card">
        <?php if ($success): ?>
            <div class="login-title">Account created!</div>
            <div style="text-align:center;color:#2e4d3a;margin-bottom:18px;">You can now <a href="login.php">log in</a>.</div>
        <?php else: ?>
            <div class="login-title">Create an account</div>
            <?php if ($errorMsg): ?>
                <div style="color:red;text-align:center;margin-bottom:10px;"> <?php echo htmlspecialchars($errorMsg); ?> </div>
            <?php endif; ?>
            <form class="login-form" method="post">
              <div class="input-row">
                <input type="text" name="name" placeholder="your name" required>
              </div>
              <input type="email" name="email" placeholder="Email" required>
              <input type="password" name="password" placeholder="Enter your password" required>
              <div class="checkbox-row">
                <input type="checkbox" id="agree" name="agree" required>
                <label for="agree">I agree to the Terms & Conditions</label>
              </div>
              <button class="login-btn" type="submit">Create account</button>
              <div class="login-subtitle">Already have an account? <a href="login.php">Log in</a></div>
            </form>
        <?php endif; ?>
      </div>
      <!-- Google sign up button removed -->
    </div>
</html>