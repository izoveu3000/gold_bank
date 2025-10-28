<?php
include 'database.php';

// Static user ID
$user_id = 5;
$bank_account = [];
$requests = [];

// //getting gold balance
// $sql = "SELECT * FROM wallet WHERE wallet.user_id= $user_id AND wallet.currency_id = 1";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // Output data of each row
//     while($row = $result->fetch_assoc()) {
//         $gold_balance = $row['amount'];     
//     }
// }else{
//     $gold_balance = 0;
// }
    $sql = "select * from user_balance where user_id = $user_id";
    $result = $conn -> query($sql);
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()) {
            $available_coin_balance = $row['available_coin_balance'];
            $available_gold_balance = $row['available_gold_balance'];
            
        }
       
    }else{
        $available_coin_balance = 0;
        $available_gold_balance = 0;
       
    }

// //getting dollar balance
// $sql = "SELECT * FROM wallet WHERE wallet.user_id= $user_id AND wallet.currency_id = 2";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // Output data of each row
//     while($row = $result->fetch_assoc()) {
//         $dollar_balance = $row['amount'];     
//     }
// }else{
//     $dollar_balance = 0;
// }

//getting today buy gold amount
$sql = "SELECT SUM(amount) as amount FROM `transaction` WHERE transaction.user_id =  $user_id and transaction.transaction_type= 'user_gold_buy' AND date(transaction.date )= CURRENT_DATE();";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $buy_gold_amount = $row['amount'];     
    }
}else{
    $buy_gold_amount = 0;
}

//getting today sell gold amount
$sql = "SELECT SUM(amount) as amount FROM `transaction` WHERE transaction.user_id = $user_id AND transaction.transaction_type= 'user_gold_sell' AND date(transaction.date )= CURRENT_DATE();";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $sell_gold_amount = $row['amount'];     
    }
}else{
    $sell_gold_amount = 0;
}

//getting gold price 
// $sql = "SELECT * FROM currency,currency_price WHERE currency.currency_id= currency_price.currency_id AND currency.currency_id = 1 ORDER BY changed_at DESC LIMIT 1";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // Output data of each row
//     while($row = $result->fetch_assoc()) {
//         $gold_price = $row['price'];     
//     }
// }else{
//     $gold_price = 0;
// }
//getting base_buy_price and base_sell_price
    $sql = "select base_buy_price,base_sell_price from gold_price_history order by changed_at desc limit 1";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row= $result->fetch_assoc()){
            $base_buy_price= $row['base_buy_price'];
            $base_sell_price = $row['base_sell_price'];
        }
    }


$requests =[
    // "gold_balance" => $gold_balance,
    // "dollar_balance" => $dollar_balance,
    "sell_gold_amount" => $sell_gold_amount,
    "buy_gold_amount" => $buy_gold_amount,
    // "gold_price" => $gold_price
    'available_coin_balance' => $available_coin_balance,
    'available_gold_balance' => $available_gold_balance,
    'base_buy_price' => $base_buy_price,
    'base_sell_price' => $base_sell_price
];



// Handle incoming request
$data = json_decode(file_get_contents('php://input'), true);
if ($data) {
    $amount =floatval(preg_replace('/[^\d.]/', '', $data['amount']));  
    $price =floatval(preg_replace('/[^\d.]/', '', $data['price'])); 
    $type =  $data['type'];
    $status= "pending";

    $stmt = $conn->prepare("INSERT INTO transaction(user_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?);");
    $stmt->bind_param("iddss",$user_id,$amount,$price,$type,$status );
    $stmt->execute();
    $stmt->close();

    
    if($type == "user_gold_sell"){
        // 1. User gold -
        $stmt = $conn->prepare("UPDATE user_balance SET available_gold_balance = available_gold_balance - ? WHERE user_id = ? ");
        $stmt->bind_param("di", $amount, $user_id);
        $stmt->execute();
        $stmt->close();

    }else if($type == "user_gold_buy"){
        // 1. User dollar -
        $dollar = $amount * ($price+($price*0.01));
        $stmt = $conn->prepare("UPDATE user_balance SET available_coin_balance = available_coin_balance - ? WHERE user_id = ? ");
        $stmt->bind_param("di", $dollar, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    

}


$conn->close();

// Return a single JSON response
header('Content-Type: application/json');
echo json_encode($requests);





?>