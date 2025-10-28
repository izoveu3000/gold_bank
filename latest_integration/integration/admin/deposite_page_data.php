<?php
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
$sql = "SELECT * FROM transaction,transaction_approve,users WHERE transaction.transaction_id= transaction_approve.tran_id AND transaction.transaction_type='deposit' AND transaction.transaction_status='pending' and transaction.user_id = users.user_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $requests[] = [
            "transaction_id"=> $row["transaction_id"],
            "user_id"=> $row["user_id"],
            "user_name"=> $row["user_name"],           
            "amount"=> $row["amount"],
            "total" => $row["amount"] * $row["price"],
            "transaction_date"=> $row["date"],
            "transaction_status" => $row['transaction_status'],
            "reference_number" => $row['reference_number'],
            "image" => $row['image']
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
    $note = $data['note'];

    // Update transaction status
    $sql = "UPDATE transaction SET transaction_status = ? WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $t_id);
    $stmt->execute();
    $stmt->close();

    if($status=="approve"){
        //insert in journal entry table
            
            $sql = "UPDATE user_balance SET actual_coin_balance = actual_coin_balance + ?, available_coin_balance = available_coin_balance +? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ddi", $coin_amount,$coin_amount, $u_id);
            $stmt->execute();
            $stmt->close();



    }else if($status =="warn"){
        $stmt = $conn->prepare("insert into transaction_note (transaction_id,user_id,note) values(?,?,?)");
        $stmt->bind_param("iis",$t_id,$u_id,$note);
        $stmt->execute();
        $stmt->close();

    }else if($status=="reject"){
        $stmt = $conn->prepare("insert into transaction_note (transaction_id,user_id,note) values(?,?,?)");
        $stmt->bind_param("iis",$t_id,$u_id,$note);
        $stmt->execute();
        $stmt->close();

    }


}
$conn->close();
?>