<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['user_id'])) {
    echo json_encode(['error' => 'Missing user_id']);
    exit;
}

$user_id = intval($data['user_id']); // Secure input

$conn = new mysqli("localhost", "root", "", "goldbank");

$sql= "SELECT * FROM users WHERE user_id = {$user_id}";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$status_class = ($user['status'] == "Active now") ? "active" : "offline";

$sql= "SELECT COUNT(*) as total_transactions FROM transaction WHERE user_id= {$user_id}";
$result = $conn->query($sql);
$total_transactions = $result->fetch_assoc()['total_transactions'] ?? 0;

$wallet = ['gold' => 0, 'dollar' => 0];
$sql= "select * from user_balance where user_id= {$user_id}";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $wallet['gold'] = $row['actual_gold_balance'];
    $wallet['dollar'] = $row['actual_coin_balance'];
}
$bank= array();
    $bank['KBZ']= "";
    $bank['AYA']="";
    $bank['CB']="";
    $sql= "SELECT bank_name,account_number FROM users,bank WHERE users.user_id=bank.user_id AND users.user_id={$user_id}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $bank[$row['bank_name']]= $row['account_number'];
        }
    }   


$transactions = [];
$sql= "SELECT transaction_type, date 
       FROM transaction 
       WHERE user_id={$user_id} ORDER BY date DESC LIMIT 5";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

$conn->close();

echo json_encode([
    "total_transactions"=> $total_transactions,
    "status" => $user['status'],
    "status_class" => $status_class,
    "wallet" => $wallet,
    "transactions" => $transactions,
    "bank" =>$bank
]);
?>