<?php
session_start();
include 'database.php'; 

header('Content-Type: application/json');

// $current_user_id = $_SESSION['user_id'];
$current_user_id = 5; 

$unread_sql = "
    SELECT 
        COUNT(*) as unread_count
    FROM 
        `transaction`
    WHERE 
        user_id = ?
        AND transaction_status IN ('approve', 'reject', 'warn')
        AND is_read = 0;
";
$stmt_unread = $conn->prepare($unread_sql);
$stmt_unread->bind_param("i", $current_user_id);
$stmt_unread->execute();
$result_unread = $stmt_unread->get_result();
$unread_count = $result_unread->fetch_assoc()['unread_count'];

$display_sql = "
    SELECT 
        t.transaction_id,
        t.amount,
        t.price,
        t.transaction_type,
        t.transaction_status AS status,
        t.date,
        t.is_read
    FROM 
        `transaction` t
    WHERE 
        t.user_id = ?
        AND t.transaction_status IN ('approve', 'reject', 'warn')
        AND t.is_read = 0
    ORDER BY 
        t.date DESC
    LIMIT 10;
";

$stmt_display = $conn->prepare($display_sql);
$stmt_display->bind_param("i", $current_user_id);
$stmt_display->execute();
$result_display = $stmt_display->get_result();

$notifications = [];
while ($row = $result_display->fetch_assoc()) {
    
    // Determine the correct page to link to
    $target_page = '';
    if ($row['status'] == 'warn') {
        $target_page = 'pending(user).php';
    } else {
        $target_page = 'history(user).php'; 
    }
    
    if($row['transaction_type']==="deposit" || $row['transaction_type']==="withdraw"){
        $currency_name = "coin";
    }else if($row['transaction_type']==="user_gold_buy" || $row['transaction_type']==="user_gold_sell"){
        $currency_name="gold";
    }

    $notifications[] = [
        'id' => $row['transaction_id'],
        'type' => $row['transaction_type'],
        'status' => $row['status'],
        'amount' => $row['amount'],
        'price' => $row['price'],
        'currency' => $currency_name,
        'date' => $row['date'],
        'is_read' => $row['is_read'],
        'url' => "read_and_redirect.php?id=" . $row['transaction_id'] . "&page=" . urlencode($target_page)
    ];
}

$conn->close();

echo json_encode([
    'success' => true,
    'notifications' => $notifications,
    'unread_count' => (int)$unread_count
]);
?>