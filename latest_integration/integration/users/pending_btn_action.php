<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = intval($_POST['transaction_id'] ?? 0);

    if ($transaction_id > 0) {
        // Example update query
        $stmt = $conn->prepare("UPDATE transaction SET transaction_status = 'cancel' WHERE transaction_id = ?");
        $stmt->bind_param("i", $transaction_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'DB update failed']);
        }

        $stmt->close();

        
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid transaction id']);
    }

    $sql = "select * from transaction where transaction_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $transaction_id);
        $stmt->execute();
        $result = $stmt->get_result();

// --- Start HTML Generation ---

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $amount = $row['amount'];
                $price = $row['price'];
                $transaction_type = $row['transaction_type'];
                $user_id = $row['user_id'];
            }
        }
        if($transaction_type==="deposit"){

        }else if($transaction_type==="withdraw"){
            $sql = "update user_balance set available_coin_balance= available_coin_balance+? where user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di",$amount, $user_id);
            $stmt->execute();
        }else if($transaction_type==="user_gold_buy"){
            $actual_price =$price+( $price * 0.01);
            $total = $amount * $actual_price;
            $sql = "update user_balance set available_coin_balance= available_coin_balance+? where user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di",$total, $user_id);
            $stmt->execute();
        }else if($transaction_type==="user_gold_sell"){
            $sql = "update user_balance set available_gold_balance= available_gold_balance+? where user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di",$amount, $user_id);
            $stmt->execute();
        }
    
        

} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

$conn->close();
?>
