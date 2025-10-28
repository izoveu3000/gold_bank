<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "goldbank";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optimized SQL query to get user details, their associated wallets,
// and the unread message count using a subquery for better performance.
$sql = "SELECT 
    u.user_id,
    u.user_name,
    u.email,
    u.status,
    u.last_seen,
    w.actual_gold_balance,
    w.actual_coin_balance,
    (SELECT COUNT(*) FROM message WHERE outgoing_msg_id = u.user_id AND is_read = 0) as unread_count
FROM 
    users u
LEFT JOIN 
    user_balance w ON u.user_id = w.user_id
WHERE 
    u.user_type = 'user'
ORDER BY 
    u.user_id";

$result = $conn->query($sql);

$user_wallets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        
        // Determine status classes and dots based on status
        if ($row['status'] == "Offline now") {
            $status_class = "status-offline";
            $status_dot = "offline";
        } else {
            $status_class = "status-active";
            $status_dot = "online";
        }

        // Check if the user is already in the array
        if (!isset($user_wallets[$user_id])) {
            $user_wallets[$user_id] = [
                "user_id" => $user_id,
                "user_name" => $row["user_name"],
                "email" => $row["email"],
                "status" => $row["status"],
                "status_dot" => $status_dot,
                "status_class" => $status_class,
                "last_seen" => $row["last_seen"],
                "unread_count" => $row['unread_count'], // Correctly fetch unread_count from the main query
                "actual_gold_amount"=>$row['actual_gold_balance'],
                "actual_coin_amount"=>$row['actual_coin_balance']
            ];
        }

       
    }
}



// Re-index the array for a clean output
$final_users = array_values($user_wallets);

// Example of how to use the final array
// print_r($final_users);

// ✅ Compute totals
$total_users = count($final_users);
$total_gold = 0;
$total_dollars = 0;
$total_active = 0;

foreach ($final_users as $user) {
    $total_dollars += (float)$user['actual_coin_amount'];
    $total_gold += (float)$user['actual_gold_amount'];
    // foreach ($user['wallets'] as $wallet) {
    //     if (strtolower($wallet['currency_name']) === "gold") {
    //         $total_gold += (float)$wallet['amount'];
    //     } elseif (strtolower($wallet['currency_name']) === "dollar") {
    //         $total_dollars += (float)$wallet['amount'];
    //     }
    // }
    if ($user['status_dot'] === "online") {
        $total_active++;
    }
}



// Close the connection
$conn->close();
?>