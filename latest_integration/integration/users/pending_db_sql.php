<?php

// Include the database connection
include 'database.php';

// User ID for which to fetch transactions (hardcoded to 5 as requested)
$user_id = 5;
// Admin User ID for fetching specific notes (hardcoded to 1 as requested)
$admin_id = 1; 

// SQL to fetch all pending transactions (deposit, withdrawal, gold purchase)
$sql = "SELECT
    t.transaction_id,
    t.amount,
    t.date,
    t.transaction_type,
    t.price,
    ta.reference_number,
    tn_admin.note AS admin_note,
    b.bank_name
FROM
    `transaction` t
LEFT JOIN
    `transaction_approve` ta ON t.transaction_id = ta.tran_id
LEFT JOIN
    `bank` b ON ta.bank_id = b.bank_id
LEFT JOIN
    `transaction_note` tn_admin ON t.transaction_id = tn_admin.transaction_id AND tn_admin.user_id = ?
WHERE
    t.user_id = ?
    AND (t.transaction_status = 'pending' OR t.transaction_status= 'warn' )
    AND t.transaction_type IN ('deposit','withdraw','user_gold_buy','user_gold_sell')
ORDER BY
    t.date DESC";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $admin_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// --- Start HTML Generation ---

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transaction_id = htmlspecialchars($row['transaction_id']);
        $amount = number_format($row['amount'], 2);
        
        $ori_value = $row['amount'] * $row['price'];
        
        $type = strtolower($row['transaction_type']);
        
        // Corrected service fee calculation
        if ($type === 'deposit') {
   
            $service_fee = 0;
            $adjusted_value = $ori_value + $service_fee;
        } elseif ($type === 'withdraw' ) {
       
            $service_fee =0;
            $adjusted_value = $ori_value - $service_fee;
        }   elseif ( $type === 'user_gold_buy') {
          
            $service_fee = $ori_value * 0.01;
            $adjusted_value = $ori_value + $service_fee;
            $price = ($row['price']*0.01)+$row['price'];
        }   elseif ($type === 'user_gold_sell') {
            
            $service_fee = $ori_value * 0.01;
            $adjusted_value = $ori_value - $service_fee;
            $price = $row['price']-($row['price']*0.01);
        }

        $adjusted_value = number_format($adjusted_value, 2); // Use the adjusted value here
        $date = (new DateTime($row['date']))->format('M d, Y');
        $bank_name = htmlspecialchars($row['bank_name'] ?? 'N/A');
        $reference_number = htmlspecialchars($row['reference_number'] ?? 'N/A');
        $admin_response = htmlspecialchars($row['admin_note']);
        $type_display = ucwords(str_replace('_', ' ', $type));
        
        // --- Custom content based on type
        if ($type === 'deposit') {
            $icon_html = '<div class="pending-icon" style="background:#e6f7ff;color:#0066cc;"><i data-feather="plus-circle"></i></div>';
            $title_html = 'Account Recharge';
            $amount_label = 'Request Amount (USD):';
            $amount_value = '$'.$amount;
            $Service_Name ='Service Fee';
            $service_val='+'.$service_fee . ' MMK';
            $price_label = 'Total To Transfer (MMK):';
            $price_value = $adjusted_value  . ' MMK';
            $badge_style = 'background:#e0f7fa;color:#006064;';
        } 
        elseif ($type === 'withdraw') {
            $icon_html = '<div class="pending-icon" style="background:#fff0f0;color:#cc0000;"><i data-feather="arrow-up-circle"></i></div>';
            $title_html = 'Withdrawal Request';
            $amount_label = 'Withdraw Amount (USD):';
            $amount_value = '$'.$amount;
            $Service_Name ='Service Fee';
            $service_val='-'.$service_fee . ' MMK';

            $price_label = 'You\'ll Receive (MMK):';
            $price_value = $adjusted_value . ' MMK';
            $badge_style = 'background:#ffeaea;color:#c00;';
        } 
        elseif ($type === 'user_gold_buy') {
            $icon_html = '<div class="pending-icon" style="background:#fff7e6;color:#a67c00;"><i data-feather="dollar-sign"></i></div>';
            $title_html = 'Gold Purchase';
            $amount_label = 'Gold Amount:';
            $amount_value = $amount . ' kt';
            $Service_Name = 'Buy Price';
            $service_val=$price .' Coin';

            $price_label = 'Total Cost (Coin):';
            $price_value = '$'.$adjusted_value ;
            $badge_style = 'background:#ffe8b3;color:#a67c00;';
        }elseif ($type === 'user_gold_sell') {
            $icon_html = '<div class="pending-icon" style="background:#fff7e6;color:#a67c00;"><i data-feather="dollar-sign"></i></div>';
            $title_html = 'Gold Sell';
            $amount_label = 'Gold Amount:';
            $amount_value = $amount . ' kt';
            $Service_Name = 'Sell Price';
            $service_val=$price .' Coin';

            $price_label = 'Total Cost (Coin):';
            $price_value = '$'.$adjusted_value ;
            $badge_style = 'background:#ffe8b3;color:#a67c00;';
        }
?>

<div class="pending-card <?php echo $type_class; ?>" data-id="<?php echo $transaction_id; ?>">
    
    <div class="d-flex align-items-start justify-content-between mb-3">
        
        <div class="d-flex align-items-center">
            <?php echo $icon_html; ?>
            <div style="margin-left: 60px;">
                <h4 class="fw-bold mb-0" style="color:#1a4d2e; font-size: 1.25rem;">
                    <?php echo $title_html; ?>
                    <span class="pending-badge" style="<?php echo $badge_style; ?>">PENDING</span>
                </h4>
                <p class="text-muted small mb-0">
                    TX ID: #<?php echo $transaction_id; ?> &bull; Date: <?php echo $date; ?> 
                </p>
            </div>
        </div>

        <div class="pending-actions">
            <button class="pending-edit" data-id="<?php echo $transaction_id; ?>">
                <i data-feather="edit" style="width:16px;height:16px;"></i> Edit
            </button>
            <button class="pending-cancel" data-id="<?php echo $transaction_id; ?>">
                <i data-feather="x-circle" style="width:16px;height:16px;"></i> Cancel
            </button>
        </div>
    </div>

    <div style="padding-left: 60px;">
        <p class="mb-2" style="font-size: 1.1rem; color:#333;">
            <strong><?php echo $amount_label; ?></strong> 
            <span class="fw-bold text-success" style="font-weight: 700; color:#219a43 !important;"><?php echo $amount_value; ?></span>
        </p>
         <!-- <p class="mb-2" style="font-size: 1.1rem; color:#333;">
            <strong><?php echo $Service_Name;?></strong> 
            <span class="fw-bold text-success" style="font-weight: 700; color:#219a43 !important;"><?php echo $service_val; ?></span>
        </p> -->
        <p class="mb-2" style="font-size: 1.1rem; color:#333;">
            <strong><?php echo $price_label; ?></strong> 
            <span class="fw-bold text-primary" style="font-weight: 700; color:#1a4d2e !important;"><?php echo $price_value; ?></span>
        </p>
        <p class="mb-2" style="font-size: 1rem; color:#6c8e6b;">
            <strong>Payment Bank:</strong> <?php echo $bank_name; ?>
        </p>
        <p class="mb-2" style="font-size: 1rem; color:#6c8e6b;">
            <strong>Reference No:</strong> <?php echo $reference_number; ?>
        </p>
    </div>

    <?php if (!empty($admin_response)): ?>
        <div class="pending-admin">
            <i data-feather="alert-triangle" style="width:16px;height:16px; margin-right: 6px;"></i>
            <strong>Admin Note:</strong> <?php echo nl2br($admin_response); ?>
        </div>
    <?php endif; ?>

</div>
<?php
    }

} else {
    // Message when no transactions are found
    echo '<div style="text-align:center; padding: 40px; font-size: 1.2rem; color: #6c8e6b; border: 1.5px dashed #dbeedc; border-radius: 12px; background: #f8fcf7;">
             No pending transactions here
          </div>';
}

// Close resources
$stmt->close();
$conn->close();
?>