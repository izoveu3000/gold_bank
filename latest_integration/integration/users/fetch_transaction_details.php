<?php
include 'database.php';

header('Content-Type: application/json');

if (!isset($_GET['transaction_id']) || empty($_GET['transaction_id'])) {
    echo json_encode(['success' => false, 'error' => 'No transaction ID provided.']);
    exit;
}

$transaction_id = intval($_GET['transaction_id']);

try {
    // Get transaction details first to determine type and user
    $sql = "
        SELECT 
            t.transaction_id,
            t.amount,
            t.price,
            t.transaction_type,
            t.user_id,
            ta.bank_id,
            ta.reference_number,
            ta.image,
            b.bank_name,
            b.account_number,
            GROUP_CONCAT(tn.note ORDER BY tn.note_id DESC SEPARATOR '|||') AS notes
        FROM 
            `transaction` t
        LEFT JOIN 
            transaction_approve ta ON t.transaction_id = ta.tran_id
        LEFT JOIN 
            bank b ON ta.bank_id = b.bank_id
        LEFT JOIN
            transaction_note tn ON t.transaction_id = tn.transaction_id
        WHERE 
            t.transaction_id = ?
        GROUP BY 
            t.transaction_id
        LIMIT 1;
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $transaction = $result->fetch_assoc();
        $base_amount = (float)$transaction['amount'] * (float)$transaction['price'];
        
        $transaction_type = strtolower($transaction['transaction_type']);
        
        // Apply service fee based on transaction type
        if ($transaction_type === 'deposit') {
            // For deposit and gold purchase, ADD the service fee
            $service_fee = 0;
            $adjusted_value = $base_amount + $service_fee;
        } elseif ($transaction_type === 'withdraw') {
            // For withdrawal and sell gold, SUBTRACT the service fee
            $service_fee = 0;
            $adjusted_value = $base_amount - $service_fee;
        }   elseif ($transaction_type === 'user_gold_buy') {
            // For withdrawal and sell gold, SUBTRACT the service fee
            $service_fee = $base_amount * 0.01;
            $adjusted_value = $base_amount + $service_fee;
        }   elseif ($transaction_type === 'user_gold_sell' ) {
            // For withdrawal and sell gold, SUBTRACT the service fee
            $service_fee = $base_amount * 0.01;
            $adjusted_value = $base_amount - $service_fee;
        }
        
        // Add calculated values to the response WITH COMMA FORMATTING
        $transaction['base_amount'] = number_format($base_amount, 2, '.', ',');
        $transaction['service_fee'] = number_format($service_fee, 2, '.', ',');
        $transaction['total_adjusted'] = number_format($adjusted_value, 2, '.', ',');
        $transaction['total_mmk'] = number_format($adjusted_value, 2, '.', ','); // Keep for backward compatibility
        
        // Also format the original amount and price with commas
        $transaction['amount_formatted'] = number_format($transaction['amount'], 2, '.', ',');
        $transaction['price_formatted'] = number_format($transaction['price'], 2, '.', ',');
        
        // Fetch banks based on transaction type
        if ($transaction_type === 'withdraw') {
            // For withdrawals, only get user's banks (user_id = 5)
            $banks_sql = "SELECT bank_id, bank_name, account_number FROM bank WHERE user_id = 5 ORDER BY bank_id";
        } else {
            // For deposits, get all banks (user_id = 1)
            $banks_sql = "SELECT bank_id, bank_name, account_number FROM bank WHERE user_id = 1 ORDER BY bank_id";
        }
        
        $banks_result = $conn->query($banks_sql);
        $banks = [];
        while ($row = $banks_result->fetch_assoc()) {
            $banks[] = $row;
        }

        // Clean up and combine data
        $transaction['notes'] = !empty($transaction['notes']) ? explode('|||', $transaction['notes']) : [];
        $transaction['all_banks'] = $banks;

        echo json_encode(['success' => true, 'data' => $transaction]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Transaction not found.']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>