<?php
include 'database.php';

// Static user ID
$user_id = 5;
$response_data = [];

// Handle the wallet balance query
$currency_id = isset($_GET['currency_id']) ? intval($_GET['currency_id']) : null;
if ($currency_id !== null) {
    $sql = "SELECT amount FROM wallet WHERE user_id = ? AND currency_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $currency_id);
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

// Handle the gold price query
if (isset($_GET['gold_price'])) {
    // Get latest gold price and its timestamp
    $query_latest = "SELECT price, changed_at FROM currency_price WHERE currency_id = 1 ORDER BY changed_at DESC LIMIT 1";
    $result_latest = $conn->query($query_latest);
    $latest_price_row = $result_latest->fetch_assoc();
    
    $latest_price = $latest_price_row['price'] ?? null;
    $last_updated = $latest_price_row['changed_at'] ?? null;

    // Get previous day's closing price
    $previous_price = null;
    $query_previous = "SELECT price FROM currency_price WHERE currency_id = 1 ORDER BY changed_at DESC LIMIT 1 OFFSET 1;";
    $result_previous = $conn->query($query_previous);
    $previous_price_row = $result_previous->fetch_assoc();
    $previous_price = $previous_price_row['price'] ?? null;

    // Calculate difference and percentage change
    $difference = ($latest_price && $previous_price) ? $latest_price - $previous_price : 0;
    // $percentage_change = ($previous_price > 0) ? ($difference / $previous_price) * 100 : 0;
    $is_up = $difference >= 0;

    // Add gold price data to the response array
    $response_data['price'] = $latest_price;
    $response_data['changed_at'] = $last_updated;
    $response_data['difference'] = $difference;
    // $response_data['percentage_change'] = $percentage_change;
    $response_data['is_up'] = $is_up;
}

// Handle the portfolio value query (NEW SECTION)
if (isset($_GET['portfolio_value'])) {
    // 1. Get latest Gold Price (currency_id = 1)
    $query_gold_price = "SELECT price FROM currency_price WHERE currency_id = 1 ORDER BY changed_at DESC LIMIT 1";
    $result_gold_price = $conn->query($query_gold_price);
    $gold_price = $result_gold_price->num_rows > 0 ? (float)($result_gold_price->fetch_assoc()['price']) : 0.00;

    // 2. Get User's Gold Amount (currency_id = 1)
    $query_gold_amount = "SELECT amount FROM wallet WHERE user_id = ? AND currency_id = 1";
    $stmt_gold = $conn->prepare($query_gold_amount);
    if ($stmt_gold) {
        $stmt_gold->bind_param("i", $user_id);
        $stmt_gold->execute();
        $result_gold = $stmt_gold->get_result();
        $gold_amount = $result_gold->num_rows > 0 ? (float)($result_gold->fetch_assoc()['amount']) : 0.00;
        $stmt_gold->close();
    } else { $gold_amount = 0.00; }

    // 3. Get User's Dollar Amount (currency_id = 2)
    $query_dollar_amount = "SELECT amount FROM wallet WHERE user_id = ? AND currency_id = 2";
    $stmt_dollar = $conn->prepare($query_dollar_amount);
    if ($stmt_dollar) {
        $stmt_dollar->bind_param("i", $user_id);
        $stmt_dollar->execute();
        $result_dollar = $stmt_dollar->get_result();
        $dollar_amount = $result_dollar->num_rows > 0 ? (float)($result_dollar->fetch_assoc()['amount']) : 0.00;
        $stmt_dollar->close();
    } else { $dollar_amount = 0.00; }
    
    // 4. Calculate Portfolio Value
    $portfolio_value = ($gold_amount * $gold_price) + $dollar_amount;

    $response_data['portfolio_value'] = $portfolio_value;
}

// Handle the Portfolio P&L query
if (isset($_GET['profit_loss'])) {
    
    // 1. Calculate Current Portfolio Value
    
    // 1a. Get latest Gold Price (currency_id = 1)
    $query_gold_price = "SELECT price FROM currency_price WHERE currency_id = 1 ORDER BY changed_at DESC LIMIT 1";
    $result_gold_price = $conn->query($query_gold_price);
    $gold_price = $result_gold_price->num_rows > 0 ? (float)($result_gold_price->fetch_assoc()['price']) : 0.00;

    // 1b. Get User's Gold Amount (currency_id = 1)
    $query_gold_amount = "SELECT amount FROM wallet WHERE user_id = ? AND currency_id = 1";
    $stmt_gold = $conn->prepare($query_gold_amount);
    $gold_amount = 0.00;
    if ($stmt_gold) {
        $stmt_gold->bind_param("i", $user_id);
        $stmt_gold->execute();
        $result_gold = $stmt_gold->get_result();
        $gold_amount = $result_gold->num_rows > 0 ? (float)($result_gold->fetch_assoc()['amount']) : 0.00;
        $stmt_gold->close();
    } 

    // 1c. Get User's Dollar Amount (currency_id = 2)
    $query_dollar_amount = "SELECT amount FROM wallet WHERE user_id = ? AND currency_id = 2";
    $stmt_dollar = $conn->prepare($query_dollar_amount);
    $dollar_amount = 0.00;
    if ($stmt_dollar) {
        $stmt_dollar->bind_param("i", $user_id);
        $stmt_dollar->execute();
        $result_dollar = $stmt_dollar->get_result();
        $dollar_amount = $result_dollar->num_rows > 0 ? (float)($result_dollar->fetch_assoc()['amount']) : 0.00;
        $stmt_dollar->close();
    }
    
    $current_portfolio_value = ($gold_amount * $gold_price) + $dollar_amount;

    // 2. Calculate Total Approved Withdrawals (Total Possessions Taken Out)
    // We assume the 'price' column holds the USD value for deposit/withdraw transactions.
    $query_withdrawals = "SELECT SUM(price) AS total_withdrawals FROM `transaction` WHERE user_id = ? AND transaction_type = 'withdraw' AND transaction_status = 'approved'";
    $stmt_withdrawals = $conn->prepare($query_withdrawals);
    $total_withdrawals = 0.00;
    if ($stmt_withdrawals) {
        $stmt_withdrawals->bind_param("i", $user_id);
        $stmt_withdrawals->execute();
        $result_withdrawals = $stmt_withdrawals->get_result();
        $total_withdrawals = $result_withdrawals->num_rows > 0 ? (float)($result_withdrawals->fetch_assoc()['total_withdrawals']) : 0.00;
        $stmt_withdrawals->close();
    }

    // 3. Calculate Total Approved Deposits (Total Investment Cost)
    // We assume the 'price' column holds the USD value for deposit/withdraw transactions.
    $query_deposits = "SELECT SUM(price) AS total_deposits FROM `transaction` WHERE user_id = ? AND transaction_type = 'deposit' AND transaction_status = 'approved'";
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

// Handle the 24h gold price history query (NEW BLOCK)
if (isset($_GET['gold_price_24h'])) {
    // Calculate timestamp for 24 hours ago
    $one_day_ago = date('Y-m-d H:i:s', strtotime('-24 hours'));
    
    // Query to get price history for the last 24 hours for gold (currency_id = 1)
    // Order by changed_at ASC to plot in chronological order
    $query_24h_history = "SELECT price, changed_at FROM currency_price WHERE currency_id = 1 AND changed_at >= ? ORDER BY changed_at ASC";
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
    
    // Query to get MIN and MAX price for gold (currency_id = 1) in the last 24 hours
    $query_24h_stats = "
        SELECT 
            MIN(price) AS price_low, 
            MAX(price) AS price_high
        FROM currency_price 
        WHERE currency_id = 1 AND changed_at >= ?
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