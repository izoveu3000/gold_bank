<?php

include('dashboard_admin_data.php');
// / --- Final Step: Prepare and send the single JSON response ---

// Create an associative array with all the variables
$response_data = [

    'deposit_total'=> $deposit_total,
    'deposit_amount' => $deposit_amount,
    'withdraw_total' => $withdraw_total,
    'withdraw_amount' => $withdraw_amount,
    'buy_gold_total' => $buy_gold_total,
    'buy_gold_amount' => $buy_gold_amount,
    'sell_gold_total' => $sell_gold_total,
    'sell_gold_amount' => $sell_gold_amount,
    'gold_transaction_fee' =>$gold_transaction_fee,
    'actual_coin_balance' => $actual_coin_balance,
    'actual_gold_balance' => $actual_gold_balance,
    'base_buy_price' => $base_buy_price,
    'base_sell_price' =>$base_sell_price
    
];

// Set the content-type header to 'application/json'
header('Content-Type: application/json');

// Encode the PHP array into a JSON string and echo it
echo json_encode($response_data);






?>