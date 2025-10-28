<?php
// Set header to indicate the response is JSON
header('Content-Type: application/json');

// Assumes 'database.php' contains your $conn object
include 'database.php';

$user_id = 5; 

$response = [
    'total_gold_purchased' => 0,
    'total_transactions' => 0,
    'error' => null
];

try {
    // 1. Get Total Gold Purchased (Assuming currency_id = 1 for gold)
    $sql_gold = "
        SELECT SUM(amount) AS total_gold_oz
        FROM wallet
        WHERE user_id = ? AND currency_id = 1
    ";

    if ($stmt = $conn->prepare($sql_gold)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result_gold = $stmt->get_result();
        if ($row = $result_gold->fetch_assoc()) {
            // Use coalesce (??) to ensure a numeric value is returned
            $response['total_gold_purchased'] = $row['total_gold_oz'] ?? 0.00;
        }
        $stmt->close();
    } else {
         throw new Exception("Error preparing gold query: " . $conn->error);
    }
    
    // 2. Count Total Transactions (for completed, pending, or rejected)
    $sql_transactions = "
        SELECT COUNT(transaction_id) AS total_transactions_count
        FROM transaction
        WHERE user_id = ? AND transaction_status IN ('approved', 'rejected')
    ";

    if ($stmt = $conn->prepare($sql_transactions)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result_transactions = $stmt->get_result();
        if ($row = $result_transactions->fetch_assoc()) {
            $response['total_transactions'] = (int)$row['total_transactions_count'];
        }
        $stmt->close();
    } else {
        throw new Exception("Error preparing transaction count query: " . $conn->error);
    }
    
} catch (Exception $e) {
    // Return error message if something goes wrong
    $response['error'] = 'Database Error: ' . $e->getMessage();
} finally {
    if (isset($conn) && $conn) {
        $conn->close();
    }
}

// Output the final JSON object
echo json_encode($response);
?>