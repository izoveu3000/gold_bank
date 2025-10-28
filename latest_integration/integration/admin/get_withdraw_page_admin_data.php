<?php

include('withdraw_page_admin_data.php');

// Return JSON response
header('Content-Type: application/json');

$response = array();
foreach ($requests as $req) {
    $response[] = array(
        'transaction_id' => $req['transaction_id'],
        'user_id' => $req['user_id'],
        'user_name' => $req['user_name'],
        'amount' => $req['amount'],
        'total' => $req['total'],
        'price' => $req['price'],
        'account_number' => $req['account_number'],
        'bank_name' => $req['bank_name'],
        'transaction_date' => $req['transaction_date'],
        'transaction_status' => $req['transaction_status']
    );
}

echo json_encode($response);
?>