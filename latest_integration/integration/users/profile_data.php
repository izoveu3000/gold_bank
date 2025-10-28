<?php
// -------------------
// Database Connection
// -------------------
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "goldbank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

session_start();

// In real app, use logged-in user's id from session
$user_id = 5;

// -------------------
// Handle AJAX (JSON)
// -------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['action'])) {
    echo json_encode(['success' => false, 'message' => 'No action provided.']);
    exit;
  }

  $action = $data['action'];

  // -------------------
  // 1️⃣ Add Bank
  // -------------------
  if ($action === 'add_bank') {
    $account_holder = $conn->real_escape_string($data['account_holder']);
    $account_number = $conn->real_escape_string($data['account_number']);
    $bank_name      = $conn->real_escape_string($data['bank_name']);

    // Check for duplicate account number
    $check = $conn->query("SELECT * FROM bank WHERE account_number='$account_number' AND bank_name='$bank_name' AND active= 1 AND user_id='$user_id'");
    if ($check->num_rows > 0) {

      echo json_encode(['success' => false, 'message' => 'This account number already exists.']);
      exit;
    }
    $update= false;
    $check = $conn->query("SELECT * FROM bank WHERE account_number='$account_number' AND bank_name='$bank_name' AND active= 0 AND user_id='$user_id'");
    if ($check->num_rows > 0) {
      $update= true;
    }
    if($update){
        $sql = "UPDATE  bank set active= 1 where user_id='$user_id' and bank_name='$bank_name' and account_number='$account_number'";

    if ($conn->query($sql)) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to insert bank info.']);
    }
    exit;
    }else{
        $sql = "INSERT INTO bank (user_id, account_holder, account_number, bank_name) 
            VALUES ('$user_id', '$account_holder', '$account_number', '$bank_name')";

    if ($conn->query($sql)) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to insert bank info.']);
    }
    exit;
    }
    
  }

  // -------------------
  // 2️⃣ Remove Bank
  // -------------------
  if ($action === 'remove_bank') {
    $account_number = $conn->real_escape_string($data['account_number']);
    $bank_name = $conn->real_escape_string($data['bank_name']);
    $sql = "UPDATE  bank set active= 0 where user_id='$user_id' and bank_name='$bank_name' and account_number='$account_number'";


    if ($conn->query($sql)) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to remove bank.']);
    }
    exit;
  }

  // -------------------
  // 3️⃣ Update Profile Info
  // -------------------
  if ($action === 'update_profile') {
    $user_name    = $conn->real_escape_string($data['user_name']);
    $phone_number = $conn->real_escape_string($data['phone_number']);

    $sql = "UPDATE users SET user_name='$user_name', phone_number='$phone_number' WHERE user_id='$user_id'";

    if ($conn->query($sql)) {
      echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
    }
    exit;
  }

  // -------------------
  // 4️⃣ Change Password
  // -------------------
  if ($action === 'change_password') {
    $current_password = $data['current_password'];
    $new_password     = $data['new_password'];

    // Fetch current password hash
    $res = $conn->query("SELECT password FROM users WHERE user_id='$user_id'");
    $row = $res->fetch_assoc();

    if (!$row) {
      echo json_encode(['success' => false, 'message' => 'User not found.']);
      exit;
    }

    $hashedPassword = $row['password'];

    if (!password_verify($current_password, $hashedPassword)) {
      echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
      exit;
    }

    $newHashed = password_hash($new_password, PASSWORD_DEFAULT);
    $conn->query("UPDATE users SET password='$newHashed' WHERE user_id='$user_id'");
    echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
    exit;
  }

  echo json_encode(['success' => false, 'message' => 'Unknown action.']);
  exit;
}

// -------------------
// Handle GET (fetch banks)
// -------------------
if (isset($_GET['action']) && $_GET['action'] === 'get_banks') {
  $banks = [];
  $result = $conn->query("SELECT account_holder, account_number, bank_name FROM bank WHERE user_id='$user_id' and active=1");
  while ($row = $result->fetch_assoc()) {
    $banks[] = $row;
  }
  echo json_encode(['banks' => $banks]);
  exit;
}

// -------------------
// Initial profile data for PHP include
// -------------------
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
  $user_name    = $user['user_name'];
  $email        = $user['email'];
  $phone_number = $user['phone_number'];
  $img          = $user['img'] ?: '../assets/img/default-avatar.png';
} else {
  $user_name = $email = $phone_number = '';
  $img = '../assets/img/default-avatar.png';
}

// Fetch banks for initial page render
$banks = [];
$bank_result = $conn->query("SELECT account_holder, account_number, bank_name FROM bank WHERE user_id='$user_id' and active=1");
while ($b = $bank_result->fetch_assoc()) {
  $banks[] = $b;
}

$conn->close();
?>
