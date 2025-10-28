<?php
session_start();
include 'database.php'; 

header('Content-Type: application/json');

// $current_user_id = $_SESSION['user_id'];
$current_user_id = 5; 

// Check for transaction_id in POST data
$transaction_id = null;
if (isset($_POST['transaction_id']) && is_numeric($_POST['transaction_id'])) {
    $transaction_id = (int)$_POST['transaction_id'];
}

// Define the SQL based on whether a specific ID is provided
if ($transaction_id) {
    // Case 1: Mark a single transaction as read based on the provided ID
    $sql = "
        UPDATE 
            `transaction`
        SET 
            is_read = 1
        WHERE 
            user_id = ?
            AND transaction_id = ?
            AND is_read = 0; 
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $current_user_id, $transaction_id);

} else {
    // Case 2: Mark ALL eligible unread transactions as read 
    // FIXED: Using correct status values that match fetch_notifications.php
    $sql = "
        UPDATE 
            `transaction`
        SET 
            is_read = 1
        WHERE 
            user_id = ?
            AND transaction_status IN ('approve', 'reject', 'warn')  // FIXED STATUS VALUES
            AND is_read = 0;
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $current_user_id);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'updated_rows' => $stmt->affected_rows]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database update failed: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>