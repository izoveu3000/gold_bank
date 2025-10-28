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
$sql = "SELECT * FROM transaction,transaction_approve,users,bank WHERE transaction.transaction_id= transaction_approve.tran_id AND transaction.transaction_type='withdraw' AND transaction.transaction_status='pending' and transaction.user_id = users.user_id and transaction_approve.bank_id = bank.bank_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $requests[] = [
            "transaction_id"=> $row["transaction_id"],
            "user_id"=> $row["user_id"],
            "user_name"=> $row["user_name"],           
            "amount"=> $row["amount"],
            "price" => $row["price"],
            "total" => $row["amount"] * $row["price"],
            "transaction_date"=> $row["date"],
            "transaction_status" => $row['transaction_status'],
            "bank_name" => $row['bank_name'],
            "account_number" => $row['account_number']
        ];   
    }
}


// Handle incoming request
$data = json_decode(file_get_contents('php://input'), true);
if ($data) {
    $t_id= $data['transaction_id'];
    $u_id= $data['user_id'];
    $status= $data['transaction_status'];
    $coin_amount = floatval(preg_replace('/[^\d.]/', '', $data['amount']));
    $price = 1000;
    $note = $data['note'];
    $reference_id = $data['reference_id'];
    $image_name = $data['image_name'];

    // Update transaction status
    $sql = "UPDATE transaction SET transaction_status = ? WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $t_id);
    $stmt->execute();
    $stmt->close();

    if($status=="approve"){

        $sql = "UPDATE user_balance SET actual_coin_balance = actual_coin_balance - ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $coin_amount, $u_id);
        $stmt->execute();
        $stmt->close();

        $sql = "UPDATE transaction_approve SET reference_number =  ?, image= ? WHERE tran_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $reference_id, $image_name,$t_id);
        $stmt->execute();
        $stmt->close();


    }else if($status=="reject"){
        // 1. User dollar +
        $sql = "UPDATE user_balance SET available_coin_balance = available_coin_balance + ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $coin_amount, $u_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("insert into transaction_note (transaction_id,user_id,note) values(?,?,?)");
        $stmt->bind_param("iis",$t_id,$u_id,$note);
        $stmt->execute();
        $stmt->close();

    }

}
$conn->close();
?>