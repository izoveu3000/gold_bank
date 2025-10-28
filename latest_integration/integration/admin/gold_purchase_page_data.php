<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "goldbank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$requests = [];

// Fetch pending requests
$sql = "SELECT * FROM transaction 
        INNER JOIN users ON transaction.user_id = users.user_id
        WHERE transaction.transaction_status='pending' 
        AND (transaction.transaction_type='user_gold_buy' OR transaction.transaction_type='user_gold_sell') 
        ORDER BY date";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $date_object = new DateTime($row["date"]);
        $date_only = $date_object->format('Y-m-d');

        $transaction_type = ($row["transaction_type"]=="user_gold_buy") ? "purchase" : "withdrawal";
        if($transaction_type==="purchase"){
            $price = $row['price']+($row['price']*0.01);
        }else if($transaction_type==="withdrawal"){
            $price =$row['price'] -($row['price']*0.01);
        }
        $requests[] = [
            "transaction_id"=> $row["transaction_id"],
            "user_id"=> $row["user_id"],
            "user_name"=> $row["user_name"],
            "transaction_type"=> $transaction_type,
            "amount"=> $row["amount"],
            "price" => $price,
            "total" => $row["amount"] * $price,
            "transaction_date"=> $date_only,
        ];   
    }
}
// Handle incoming request
$data = json_decode(file_get_contents('php://input'), true);
if ($data) {
    $t_id = $data['transaction_id'];
    $u_id = $data['user_id'];
    $status = $data['transaction_status'];
    $type = $data['transaction_type'];
    $gold_amount = $data['gold_amount'];
    $total_dollar = $data['total_dollar'];
    
    

    // Update transaction status
    $sql = "UPDATE transaction SET transaction_status = ? WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $t_id);
    $stmt->execute();
    $stmt->close();

    // Wallet updates without transaction
    if ($status == 'approve' && $type == 'purchase') {

        $stmt = $conn->prepare("UPDATE user_balance SET actual_gold_balance = actual_gold_balance+?,available_gold_balance= available_gold_balance+?,actual_coin_balance = actual_coin_balance - ? WHERE user_id = ? ");
        $stmt->bind_param("dddi", $gold_amount,$gold_amount,$total_dollar, $u_id);
        $stmt->execute();
        $stmt->close();






    } elseif ($status == 'approve' && $type == 'withdrawal') {
        $stmt = $conn->prepare("UPDATE user_balance SET actual_coin_balance=actual_coin_balance + ?, available_coin_balance= available_coin_balance+?,actual_gold_balance=actual_gold_balance -? WHERE user_id = ? ");
        $stmt->bind_param("dddi", $total_dollar,$total_dollar,$gold_amount, $u_id);
        $stmt->execute();
        $stmt->close();

        


    } elseif ($status == 'reject' && $type == 'purchase') {
        $stmt = $conn->prepare("UPDATE user_balance SET available_coin_balance = available_coin_balance +? where user_id=?");
        $stmt->bind_param("di",$total_dollar,$u_id );
        $stmt->execute();
        $stmt->close();
    } elseif ($status == 'reject' && $type == 'withdrawal') {
        $stmt = $conn->prepare("UPDATE user_balance  SET available_gold_balance = available_gold_balance +? where user_id=?");
        $stmt->bind_param("di",$gold_amount,$u_id );
        $stmt->execute();
        $stmt->close();
    }
}



$conn->close();

?>
