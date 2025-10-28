<?php
// get_recent_transactions.php
header('Content-Type: application/json');
include 'database.php';

$user_id = 5; // Replace with actual user ID from session

$response = ['transactions' => [], 'error' => null];

try {
    $sql = "
        SELECT 
            t.transaction_id,
            t.user_id,
            t.amount,
            t.price,
            t.transaction_type,
            t.transaction_status,
            t.date,
            ta.reference_number
        FROM transaction t
        LEFT JOIN transaction_approve ta ON t.transaction_id = ta.tran_id
        WHERE t.user_id = ? AND transaction_status IN ('approve', 'reject','pending','cancel','warn')
        ORDER BY t.date DESC
        LIMIT 6
    ";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $response['transactions'][] = $row;
        }
        
        $stmt->close();
    } else {
        throw new Exception("Error preparing query: " . $conn->error);
    }
    
} catch (Exception $e) {
    $response['error'] = 'Database Error: ' . $e->getMessage();
} finally {
    if (isset($conn) && $conn) {
        $conn->close();
    }
}

echo json_encode($response);
?>