<?php
include 'database.php';

// Static user ID
$user_id = 5;
$response_data = [];

// Handle the wallet balance query (using user_balance table)
$currency_id = isset($_GET['currency_id']) ? intval($_GET['currency_id']) : null;
if ($currency_id !== null) {
    // For currency_id = 1 (gold), get actual_gold_balance
    // For currency_id = 2 (coin), get actual_coin_balance
    if ($currency_id == 1) {
        $sql = "SELECT actual_gold_balance AS amount FROM user_balance WHERE user_id = ?";
    } else if ($currency_id == 2) {
        $sql = "SELECT actual_coin_balance AS amount FROM user_balance WHERE user_id = ?";
    }
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response_data['amount'] = $row['amount'];
        } else {
            $response_data['amount'] = 0;
        }
        $stmt->close();
    }
}

// Handle the gold price query (using gold_price_history table)
if (isset($_GET['gold_price'])) {
    // Get latest gold price from gold_price_history
    $query_latest = "SELECT base_sell_price AS price, changed_at FROM gold_price_history ORDER BY changed_at DESC LIMIT 1";
    $result_latest = $conn->query($query_latest);
    $latest_price_row = $result_latest->fetch_assoc();
    
    $latest_price = $latest_price_row['price'] ?? null;
    $last_updated = $latest_price_row['changed_at'] ?? null;

    // Get previous day's closing price
    $previous_price = null;
    $query_previous = "SELECT base_sell_price AS price FROM gold_price_history ORDER BY changed_at DESC LIMIT 1 OFFSET 1";
    $result_previous = $conn->query($query_previous);
    $previous_price_row = $result_previous->fetch_assoc();
    $previous_price = $previous_price_row['price'] ?? null;

    // Calculate difference
    $difference = ($latest_price && $previous_price) ? $latest_price - $previous_price : 0;
    $is_up = $difference >= 0;

    // Add gold price data to the response array
    $response_data['price'] = $latest_price;
    $response_data['changed_at'] = $last_updated;
    $response_data['difference'] = $difference;
    $response_data['is_up'] = $is_up;
}

// Handle the portfolio value query
if (isset($_GET['portfolio_value'])) {
    // 1. Get latest Gold Price from gold_price_history
    $query_gold_price = "SELECT base_sell_price AS price FROM gold_price_history ORDER BY changed_at DESC LIMIT 1";
    $result_gold_price = $conn->query($query_gold_price);
    $gold_price = $result_gold_price->num_rows > 0 ? (float)($result_gold_price->fetch_assoc()['price']) : 0.00;

    // 2. Get User's Gold Balance and Coin Balance
    $query_balance = "SELECT actual_gold_balance, actual_coin_balance FROM user_balance WHERE user_id = ?";
    $stmt_balance = $conn->prepare($query_balance);
    $gold_amount = 0.00;
    $coin_amount = 0.00;
    
    if ($stmt_balance) {
        $stmt_balance->bind_param("i", $user_id);
        $stmt_balance->execute();
        $result_balance = $stmt_balance->get_result();
        if ($result_balance->num_rows > 0) {
            $balance_row = $result_balance->fetch_assoc();
            $gold_amount = (float)$balance_row['actual_gold_balance'];
            $coin_amount = (float)$balance_row['actual_coin_balance'];
        }
        $stmt_balance->close();
    }
    
    // 3. Calculate Portfolio Value: (Gold Balance * Gold Price) + Coin Balance
    $portfolio_value = ($gold_amount * $gold_price) + $coin_amount;

    $response_data['portfolio_value'] = $portfolio_value;
}

// Handle the Portfolio P&L query
if (isset($_GET['profit_loss'])) {
    // 1. Calculate Current Portfolio Value
    
    // 1a. Get latest Gold Price
    $query_gold_price = "SELECT base_sell_price AS price FROM gold_price_history ORDER BY changed_at DESC LIMIT 1";
    $result_gold_price = $conn->query($query_gold_price);
    $gold_price = $result_gold_price->num_rows > 0 ? (float)($result_gold_price->fetch_assoc()['price']) : 0.00;

    // 1b. Get User's Gold and Coin Balance
    $query_balance = "SELECT actual_gold_balance, actual_coin_balance FROM user_balance WHERE user_id = ?";
    $stmt_balance = $conn->prepare($query_balance);
    $gold_amount = 0.00;
    $coin_amount = 0.00;
    
    if ($stmt_balance) {
        $stmt_balance->bind_param("i", $user_id);
        $stmt_balance->execute();
        $result_balance = $stmt_balance->get_result();
        if ($result_balance->num_rows > 0) {
            $balance_row = $result_balance->fetch_assoc();
            $gold_amount = (float)$balance_row['actual_gold_balance'];
            $coin_amount = (float)$balance_row['actual_coin_balance'];
        }
        $stmt_balance->close();
    }
    
    $current_portfolio_value = ($gold_amount * $gold_price) + $coin_amount;

    // 2. Calculate Total Approved Withdrawals
    $query_withdrawals = "SELECT SUM(amount) AS total_withdrawals FROM `transaction` WHERE user_id = ? AND transaction_type = 'withdraw' AND transaction_status = 'approved'";
    $stmt_withdrawals = $conn->prepare($query_withdrawals);
    $total_withdrawals = 0.00;
    if ($stmt_withdrawals) {
        $stmt_withdrawals->bind_param("i", $user_id);
        $stmt_withdrawals->execute();
        $result_withdrawals = $stmt_withdrawals->get_result();
        $total_withdrawals = $result_withdrawals->num_rows > 0 ? (float)($result_withdrawals->fetch_assoc()['total_withdrawals']) : 0.00;
        $stmt_withdrawals->close();
    }

    // 3. Calculate Total Approved Deposits
    $query_deposits = "SELECT SUM(amount) AS total_deposits FROM `transaction` WHERE user_id = ? AND transaction_type = 'deposit' AND transaction_status = 'approved'";
    $stmt_deposits = $conn->prepare($query_deposits);
    $total_deposits = 0.00;
    if ($stmt_deposits) {
        $stmt_deposits->bind_param("i", $user_id);
        $stmt_deposits->execute();
        $result_deposits = $stmt_deposits->get_result();
        $total_deposits = $result_deposits->num_rows > 0 ? (float)($result_deposits->fetch_assoc()['total_deposits']) : 0.00;
        $stmt_deposits->close();
    }
    
    // 4. Calculate Final P&L: (Current Portfolio Value + Total Withdrawn) - Total Deposited
    $profit_loss = ($current_portfolio_value + $total_withdrawals) - $total_deposits;

    $response_data['profit_loss'] = $profit_loss;
}

// Handle the 24h gold price history query
if (isset($_GET['gold_price_24h'])) {
    // Calculate timestamp for 24 hours ago
    $one_day_ago = date('Y-m-d H:i:s', strtotime('-24 hours'));
    
    // Query to get price history for the last 24 hours from gold_price_history
    $query_24h_history = "SELECT base_sell_price AS price, changed_at FROM gold_price_history WHERE changed_at >= ? ORDER BY changed_at ASC";
    $stmt_24h = $conn->prepare($query_24h_history);
    $price_history = [];
    
    if ($stmt_24h) {
        $stmt_24h->bind_param("s", $one_day_ago);
        $stmt_24h->execute();
        $result_24h = $stmt_24h->get_result();
        
        while ($row = $result_24h->fetch_assoc()) {
            $price_history[] = [
                'price' => (float)$row['price'],
                'time' => $row['changed_at']
            ];
        }
        $stmt_24h->close();
    }
    
    $response_data['price_history'] = $price_history;
}

// Handle the 24h gold price stats query (Low/High)
if (isset($_GET['gold_price_stats_24h'])) {
    $one_day_ago = date('Y-m-d H:i:s', strtotime('-24 hours'));
    
    // Query to get MIN and MAX price from gold_price_history in the last 24 hours
    $query_24h_stats = "
        SELECT 
            MIN(base_sell_price) AS price_low, 
            MAX(base_sell_price) AS price_high
        FROM gold_price_history 
        WHERE changed_at >= ?
    ";
    $stmt_24h_stats = $conn->prepare($query_24h_stats);
    $stats_data = [
        'price_low' => null,
        'price_high' => null
    ];
    
    if ($stmt_24h_stats) {
        $stmt_24h_stats->bind_param("s", $one_day_ago);
        $stmt_24h_stats->execute();
        $result_24h_stats = $stmt_24h_stats->get_result();
        
        if ($row = $result_24h_stats->fetch_assoc()) {
            $stats_data['price_low'] = (float)$row['price_low'];
            $stats_data['price_high'] = (float)$row['price_high'];
        }
        $stmt_24h_stats->close();
    }
    
    $response_data['price_stats_24h'] = $stats_data;
}

$conn->close();

// Return a single JSON response
header('Content-Type: application/json');
echo json_encode($response_data);
?>