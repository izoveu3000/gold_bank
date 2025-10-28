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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];  // <-- This is how you get POST data

    $sql= "select * from users where user_id = {$user_id}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $user_name = $row['user_name'];
            $phone_number = $row['phone_number'];
            $email = $row['email'];
            $created_at = $row['created_at'];
            $status = $row['status'];
            if($status =="Active now"){
                $status_class = "active";
            }else{
                $status_class = "offline";
            }

        }
    }

    $sql= "SELECT COUNT(*) as total_transactions FROM transaction,users WHERE transaction.user_id = users.user_id AND users.user_id= {$user_id}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $total_transactions= $row['total_transactions'];

        }
    }
    $wallet = ['gold' => 0, 'dollar' => 0];
$sql= "select * from user_balance where user_id= {$user_id}";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $wallet['gold'] = $row['actual_gold_balance'];
    $wallet['dollar'] = $row['actual_coin_balance'];
}
    $bank= array();
    $bank['KBZ']= "";
    $bank['AYA']="";
    $bank['CB']="";
    $sql= "SELECT bank_name,account_number FROM users,bank WHERE users.user_id=bank.user_id AND users.user_id={$user_id}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $bank[$row['bank_name']]= $row['account_number'];
        }
    }   
    $transation = array();
$sql= "SELECT transaction_type, transaction.date 
       FROM transaction, users 
       WHERE transaction.user_id=users.user_id 
       AND users.user_id={$user_id} 
       ORDER BY transaction.date DESC 
       LIMIT 5";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $transation[] = array(
            'type' => $row['transaction_type'],
            'date' => $row['date']
        );
    }
}


} else {
    echo "No POST data received.";

}
// Close the connection when you're done
    $conn->close();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - John Smith</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f9f7f0 0%, #e6dfcb 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        
        .container {
            width: 98%;
            max-width: 1600px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 10px;
        }
        
        .header {
            background: linear-gradient(90deg, #bf953f 0%, #fcf6ba 33%, #b38728 66%, #fbf5b7 100%);
            color: #333;
            padding: 25px 30px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        
        .titles h1 {
            font-weight: 700;
            font-size: 32px;
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.5);
        }
        
        .titles h2 {
            color: #5a4a21;
            font-weight: 500;
            font-size: 20px;
            margin-top: 5px;
        }
        
        .back-button {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 10px 20px;
            border: 1px solid #d4af37;
            color: #5a4a21;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            background: #fcf6ba;
            transform: translateY(-2px);
        }
        
        .back-button i {
            margin-right: 8px;
        }
        
        .user-details-container {
            padding: 30px;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 1200px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }
        
        .personal-info-section {
            background: #fffbf0;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e1dcc1;
            position: relative;
        }
        
        .balance-stats-section {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        .section {
            background: #fffbf0;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e1dcc1;
        }
        
        .section-title {
            font-size: 22px;
            color: #b38728;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #fcf6ba;
            font-weight: 600;
        }
        
        .info-item {
            margin-bottom: 15px;
            display: flex;
        }
        
        .info-label {
            font-size: 16px;
            color: #7f8c8d;
            width: 140px;
            flex-shrink: 0;
        }
        
        .info-value {
            font-size: 18px;
            font-weight: 500;
            color: #2c3e50;
            flex-grow: 1;
        }
        
        .gold-value {
            color: #b38728;
            font-weight: 600;
        }
        
        .money-value {
            color: #27ae60;
            font-weight: 600;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #d4af37 50%, transparent 100%);
            margin: 25px 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .stat-label {
            font-size: 16px;
            color: #7f8c8d;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: 600;
            color: #b38728;
        }
        
        .activity-list {
            list-style: none;
        }
        
        .activity-item {
            padding: 15px;
            background: white;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #b38728;
        }
        
        .activity-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .activity-date {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        .active{
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .offline{
            background-color: #ffecb3;
            color: #f57c00;
        }
        
        .verification-status {
            display: flex;
            align-items: center;
        }
        
        .verification-status i {
            color: #2e7d32;
            margin-right: 8px;
        }
        
        .message-button {
            position: absolute;
            top: 25px;
            right: 25px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            background-color: #b38728;
            color: white;
            display: flex;
            align-items: center;
        }
        
        .message-button:hover {
            background-color: #9c7424;
            transform: translateY(-2px);
        }
        
        .message-button i {
            margin-right: 8px;
        }
        
        .recent-activity {
            margin-top: 30px;
        }


        /* Add this new block to your existing <style> section */
.stat-item img {
    height: 30px;      /* Set a fixed height for the image */
    width: auto;       /* Maintain the image's aspect ratio */
    margin-right: 15px; /* Add some space between the image and the text */
}

/* Optional: Modify the flexbox of the parent to better align items */
.stat-item {
    display: flex;
    align-items: center; /* Vertically align image and text */
    justify-content: flex-start; /* Align all items to the start */
    padding: 12px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.stat-item .stat-label {
    flex-grow: 1; /* Allows the label to take up remaining space */
}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="titles">
                    <h1>User Details</h1>
                    <h2 id="title_name"><?php echo $user_name; ?></h2>
                </div>
                <button class="back-button" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </button>
            </div>
        </div>
        
        <div class="user-details-container">
            <div class="main-content">
                <div class="personal-info-section">
                    <button class="message-button">
                        <i class="fas fa-comment"></i> Message
                    </button>
                    
                    <h3 class="section-title">Personal Information</h3>
                    
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><?php echo $user_name; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Join Date</div>
                        <div class="info-value"><?php echo $created_at; ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?php echo $email;?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value"><?php echo $phone_number;?></div>
                    </div>

                    <div class="divider"></div>
                    
                    <h3 class="section-title">Account Status</h3>
                    
                    
                    <div class="info-item">
                        <div class="info-label">Total Transactions</div>
                        <div id="total_transactions" class="info-value"><?php echo $total_transactions; ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value" id="status">
                            <span  class="status-badge <?php echo $status_class;?>"><?php echo $status;?></span>
                        </div>
                    </div>
                    
                   <div class="info-item">
                        <div class="info-label">RYC Status</div>
                        <div class="info-value">
                            <div class="verification-status">
                                <i class="fas fa-check-circle"></i> Verified
                            </div>
                        </div>
                    </div>

                    
                    
                </div>
                
                <div class="balance-stats-section">
                    <div class="section">
                        <h3 class="section-title">Account Balance</h3>
                        
                        <div class="info-item">
                            <div class="info-label">Gold Holdings</div>
                            <div id="gold_balance" class="info-value gold-value"><?php echo $wallet['gold'];?> kt</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Cash Balance</div>
                            <div id="dollar_balance" class="info-value money-value"><?php echo $wallet['dollar'];?> coin</div>
                        </div>
                    </div>
                    
                    <div class="section">
                        <h3 class="section-title">Bank Accounts</h3>
                        
                        <div class="stats-grid">
                            <div class="stat-item">
                                <img src="KBZ.png" alt="">
                                <div class="stat-label">KBZ Bank</div>
                                <div id="KBZ_num" class="stat-value"><?php echo $bank['KBZ'];?></div>
                            </div>
                            
                            <div class="stat-item">
                                <img src="CB.png" alt="">
                                <div class="stat-label">CB Bank</div>
                                <div id="CB_num" class="stat-value"><?php echo $bank['CB'];?></div>
                            </div>
                            
                            <div class="stat-item">
                                <img src="AYA.png" alt="">
                                <div class="stat-label">AYA Bank</div>
                                <div id="AYA_num" class="stat-value"><?php echo $bank['AYA'];?></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="recent-activity">
                <div class="section">
                    <h3 class="section-title">Recent Activity</h3>
                    
                    <ul class="activity-list" id="recent_transactions">
    <?php if (!empty($transation)): ?>
        <?php foreach ($transation as $t): ?>
            <li class="activity-item">
                <div class="activity-title"><?php echo htmlspecialchars($t['type']); ?></div>
                <div class="activity-date"><?php echo htmlspecialchars($t['date']); ?></div>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="activity-item">
            <div class="activity-title">No recent activity</div>
        </li>
    <?php endif; ?>
</ul>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Functionality for the message button
        document.querySelector('.message-button').addEventListener('click', function() {
            const user_id = <?php echo $user_id;?>;
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'user_chat.php';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_id';
                    input.value = user_id;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
        });

      
    


    </script>
    <script>
const userId = <?php echo $user_id; ?>;

async function refreshData() {
    try {
        const response = await fetch("get_user_detail_data.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ user_id: userId })
        });

        const data = await response.json();

        // ✅ update status
        document.getElementById("status").innerHTML =
            `<span class="status-badge ${data.status_class}">${data.status}</span>`;

        document.getElementById("total_transactions").innerHTML=data.total_transactions;

        // ✅ update balances
        document.getElementById("gold_balance").textContent = data.wallet.gold + " oz";
        document.getElementById("dollar_balance").textContent = data.wallet.dollar + " $";

        document.getElementById("KBZ_num").innerHTML= data.bank.KBZ;
        document.getElementById("CB_num").innerHTML= data.bank.CB;
        document.getElementById("AYA_num").innerHTML= data.bank.AYA;


        // ✅ update transactions
        const list = document.getElementById("recent_transactions");
        list.innerHTML = "";
        if (data.transactions.length > 0) {
            data.transactions.forEach(t => {
                
                list.innerHTML += `<li class="activity-item">
                <div class="activity-title">${t.transaction_type}</div>
                <div class="activity-date">${t.date}</div>
            </li>`;
            });
        } else {
            list.innerHTML = `<li>No recent activity</li>`;
        }

    } catch (err) {
        console.error("Refresh error:", err);
    }
}

setInterval(refreshData, 5000);
</script>

   
</body>

</html>