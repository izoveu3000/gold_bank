<?php
session_start();
require_once '../DB/db.php';
$errorMsg = '';
$passwordError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
	if ($email) {
	// Normalize email and retrieve user_type so we can route to the correct dashboard
	$normEmail = mb_strtolower(trim($email));
	// `users` table uses `user_id` as primary key; alias it to `id` for compatibility with session keys
	$stmt = $conn->prepare('SELECT user_id AS id, password, user_type FROM users WHERE LOWER(TRIM(email)) = ? LIMIT 1');
		$stmt->execute([$normEmail]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$user) {
			$errorMsg = 'Email not registered.';
		} else {
			$stored = $user['password'];
			$verified = false;
			// Normal hashed password
			if (password_verify($password, $stored)) {
				$verified = true;
			} else {
				// Legacy: stored password may be plain text (not hashed). Accept it and migrate to a secure hash.
				if ($stored === $password) {
					$verified = true;
					try {
						$newHash = password_hash($password, PASSWORD_DEFAULT);
						$upd = $conn->prepare('UPDATE users SET password = ? WHERE user_id = ?');
						$upd->execute([$newHash, $user['id']]);
					} catch (PDOException $e) {
						error_log('Failed to migrate plaintext password for user_id ' . $user['id'] . ': ' . $e->getMessage());
						// proceed with login even if migration fails
					}
				}
			}

			if (!$verified) {
				$passwordError = 'Incorrect password.';
			} else {
				$_SESSION['user_id'] = $user['id'];
				// store type for later use
				$_SESSION['user_type'] = $user['user_type'] ?? '';
				// Redirect based on user_type
				if (isset($user['user_type']) && strtolower($user['user_type']) === 'user') {
					header('Location: ../users/dashboard(user).php');
				} else {
					header('Location: ../admin/dashboard(admin).php');
				}
				exit;
			}
		}
    } else {
        $errorMsg = 'Please enter your email.';
    }
}
?>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login</title>
		<link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
		
		<div class="login-outer" style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;width:100vw;">
			<div class="login-card">
				<div class="login-title">Sign in to your account</div>
				<form class="login-form" method="post" action="" onsubmit="showLoginSpinner(event)">
					<input type="email" name="email" placeholder="Email" require="required" value="<?php echo isset($_COOKIE['remembered_email']) ? htmlspecialchars($_COOKIE['remembered_email']) : ''; ?>">
					<input type="password" name="password" placeholder="Enter your password" require="required">
					<?php if (!empty($passwordError)) : ?>
					<div style="color:red; font-size:0.98rem; margin-bottom:6px; text-align:left;">Incorrect password.</div>
					<?php endif; ?>
					<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
						<div class="checkbox-row">
							<input type="checkbox" id="remember" name="remember" <?php echo isset($_COOKIE['remembered_email']) ? 'checked' : ''; ?>>
							<label for="remember">Remember me</label>
						</div>
						<a href="forgot_password.php" style="font-size:0.98rem; color:#4fa06b; text-decoration:none; font-weight:500;">Forgot password?</a>
					</div>
					<button class="login-btn" type="submit" id="loginBtn">Sign in</button>
					<div id="loginSpinner" style="display:none; justify-content:center; align-items:center; margin-top:12px;">
						<div style="width:32px; height:32px; border:4px solid #4fa06b; border-top:4px solid #fff; border-radius:50%; animation:spin 1s linear infinite;"></div>
					</div>
</form>
<style>
@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}
</style>
<script>
function showLoginSpinner(e) {
		var btn = document.getElementById('loginBtn');
		var spinner = document.getElementById('loginSpinner');
		btn.disabled = true;
		spinner.style.display = 'flex';
}
</script>
					<div class="login-subtitle">Don't have an account? <a href="register.php">Register</a></div>
					<div class="divider" style="margin:2px 0 2px 0; display:flex; align-items:center; justify-content:center;">
					<!-- Google button and divider removed -->
				</form>
			</div>
			
		</div>
</body>
</html>
`