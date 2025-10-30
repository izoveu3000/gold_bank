<?php
include 'database.php';

// Static user ID
$user_id = 5;

$requests = [];

//getting coin balance
$sql = "select available_coin_balance from user_balance where user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $available_coin_balance = $row['available_coin_balance'];     
    }
}

//getting today withdraw amount
$sql = "SELECT SUM(amount) as amount FROM `transaction` WHERE transaction.user_id = 5 AND transaction.transaction_type= 'withdraw' AND date(transaction.date )= CURRENT_DATE();";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $withdraw_amount = $row['amount'];     
    }
}else{
    $withdraw_amount = 0;
}



$requests =[
    "available_coin_balance" => $available_coin_balance,
    "withdraw_amount" => $withdraw_amount,
];

// Handle incoming request
$data = json_decode(file_get_contents('php://input'), true);
if ($data) {
    $amount =floatval(preg_replace('/[^\d.]/', '', $data['amount']));  
    $bank_id = $data['bank_id'];
    $type = "withdraw";
    $status= "pending";
    $price = 1;

    $stmt = $conn->prepare("INSERT INTO transaction(user_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?);");
    $stmt->bind_param("iddss",$user_id,$amount,$price,$type,$status );
    $stmt->execute();
    $newTransactionId = $stmt->insert_id; 
    $stmt->close();

    

    $stmt = $conn->prepare("INSERT INTO transaction_approve(tran_id,bank_id) values (?,?);");
    $stmt->bind_param("ii",$newTransactionId,$bank_id);
    $stmt->execute();
    $stmt->close();


    $stmt = $conn->prepare("UPDATE user_balance SET available_coin_balance = available_coin_balance - ? WHERE user_id = ?");
    $stmt->bind_param("di", $amount, $user_id);
    $stmt->execute();
    $stmt->close();

    

}

$conn->close();

// Return a single JSON response
header('Content-Type: application/json');
echo json_encode($requests);





?>