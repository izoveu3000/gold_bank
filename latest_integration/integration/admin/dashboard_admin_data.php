<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
    //database-connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "goldbank";

    // Create a new MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "select count(*) as deposit_total,sum(amount) as deposit_amount from transaction where transaction_type= 'deposit' and transaction_status= 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $deposit_total = $row['deposit_total'];
            $deposit_amount= $row['deposit_amount'];  
        }
        if($deposit_total==0){
            $deposit_amount=0;
        }
    }  
       

    $sql = "select count(*) as withdraw_total,sum(amount) as withdraw_amount from transaction where transaction_type= 'withdraw' and transaction_status= 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $withdraw_total = $row['withdraw_total'];
            $withdraw_amount= $row['withdraw_amount'];  
        }
        if($withdraw_total==0){
            $withdraw_amount=0;
        }
    }

    $sql = "select count(*) as buy_gold_total,sum(amount) as buy_gold_amount from transaction where transaction_type= 'user_gold_buy' and transaction_status= 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $buy_gold_total = $row['buy_gold_total'];
            $buy_gold_amount= $row['buy_gold_amount'];  
        }
        if($buy_gold_total==0){
            $buy_gold_amount=0;
        }
    }

    $sql = "select count(*) as sell_gold_total,sum(amount) as sell_gold_amount from transaction where transaction_type= 'user_gold_sell' and transaction_status= 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $sell_gold_total = $row['sell_gold_total'];
            $sell_gold_amount= $row['sell_gold_amount'];  
        }
        if($sell_gold_total==0){
            $sell_gold_amount=0;
        }
    }

    $sql = "select sum(amount* (price*0.01)) as gold_transaction_fee from transaction where (transaction_type = 'user_gold_buy' or transaction_type='user_gold_sell') and transaction_status= 'approve'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $gold_transaction_fee = $row['gold_transaction_fee'];

        }
    }else{
        $gold_transaction_fee=0;
    }

    $sql = "select sum(actual_coin_balance) as actual_coin_balance from user_balance ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $actual_coin_balance = $row['actual_coin_balance'];
        }
    }else{
        $actual_coin_balance=0;
    }

    $sql = "select sum(actual_gold_balance) as actual_gold_balance from user_balance ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $actual_gold_balance = $row['actual_gold_balance'];
            
        }
    }else{
        $actual_gold_balance=0;
        
    }

    $sql = "select base_buy_price,base_sell_price from gold_price_history order by changed_at desc limit 1 ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $base_buy_price = $row['base_buy_price'];
            $base_sell_price = $row['base_sell_price'];
            
        }
    }else{
        $base_sell_price=0;
        
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if ($data) {
        $new_buy_price = $data['buy_price'];
        $new_sell_price =$data['sell_price'];
        $sql = "INSERT INTO gold_price_history(base_buy_price,base_sell_price) values (?,?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("dd",$new_buy_price,$new_sell_price);
            $stmt->execute();
            $stmt->close(); 

    }
       
        










































    // $total_amount = 0;
    // //total user
    // $sql = "select  sum(amount) as total from transaction where (transaction.transaction_type ='deposit' or transaction.transaction_type= 'withdraw') and transaction.transaction_status= 'complete' and date(date)= CURRENT_DATE()";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         if($row['total']!=NULL)  {
    //             $total_amount = $row['total'];
    //         }     
    //     }
    // }
    // $today_profit = $total_amount * 0.03 ;

    // //deposit
    // $sql = "SELECT COUNT(*) AS deposit_total,TRUNCATE(SUM(amount),2) AS deposit_amount, TRUNCATE(SUM(amount*price),2) AS deposit_amount_mmk FROM transaction WHERE transaction_type='deposit' AND transaction_status='pending';";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $deposit_total = $row['deposit_total'];
    //         $deposit_amount= $row['deposit_amount'];
    //         $deposit_amount_mmk=$row['deposit_amount_mmk']; 
    //         $deposit_profit = $deposit_amount_mmk * 0.03;
    //         if($deposit_total==0){
    //             $deposit_amount= 0;
    //             $deposit_amount_mmk=0;
    //             $deposit_profit = 0;
    //         }   
    //     }
    // }

    // //withdraw
    // $sql = "SELECT COUNT(*) AS withdraw_total, TRUNCATE(SUM(amount),2) AS withdraw_amount, TRUNCATE(SUM(amount*price),2) AS withdraw_amount_mmk FROM transaction WHERE transaction_type='withdraw' AND transaction_status='pending';";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $withdraw_total = $row['withdraw_total'];
    //         $withdraw_amount= $row['withdraw_amount'];
    //         $withdraw_amount_mmk=$row['withdraw_amount_mmk'];
    //         $withdraw_profit = $withdraw_amount_mmk* 0.03;
    //         if($withdraw_total==0){
    //             $withdraw_amount= 0;
    //             $withdraw_amount_mmk=0;
    //             $withdraw_profit= 0;
    //         }   
    //     }
    // }
    // //buy gold
    // $sql = "SELECT COUNT(*) AS buy_gold_total,TRUNCATE(SUM(amount),2) AS buy_gold_amount, TRUNCATE(SUM(amount*price),2) AS buy_gold_amount_dollar FROM transaction WHERE transaction_type='buy gold' AND transaction_status='pending';";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $buy_gold_total = $row['buy_gold_total'];
    //         $buy_gold_amount= $row['buy_gold_amount'];
    //         $buy_gold_amount_dollar=$row['buy_gold_amount_dollar']; 
    //         $buy_gold_profit = $buy_gold_amount_dollar * 0.03;
    //         if($buy_gold_total==0){
    //             $buy_gold_amount= 0;
    //             $buy_gold_amount_dollar=0;
    //             $buy_gold_profit = 0;
    //         }   
    //     }
    // }

    // //sell gold
    // $sql = "SELECT COUNT(*) AS sell_gold_total,TRUNCATE(SUM(amount),2) AS sell_gold_amount, TRUNCATE(SUM(amount*price),2) AS sell_gold_amount_dollar FROM transaction WHERE transaction_type= 'sell gold' AND transaction_status='pending';";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $sell_gold_total = $row['sell_gold_total'];
    //         $sell_gold_amount= $row['sell_gold_amount'];
    //         $sell_gold_amount_dollar=$row['sell_gold_amount_dollar']; 
    //         $sell_gold_profit = $sell_gold_amount_dollar * 0.03;
    //         if($sell_gold_total==0){
    //             $sell_gold_amount= 0;
    //             $sell_gold_amount_dollar=0;
    //             $sell_gold_profit = 0;
    //         }   
    //     }
    // }
    


   
    // $sql = "SELECT SUM(dr_amount) - SUM(cr_amount) AS platform_coin_reserve FROM journal_entry WHERE account_id = 1;";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $platform_coin_reserve = $row['platform_coin_reserve'];
    //     }
    // } else {
    //     $platform_coin_reserve = 0;
    // }

    // $sql = "SELECT SUM(dr_amount) - SUM(cr_amount) AS platform_gold_inventory FROM journal_entry WHERE account_id = 2;";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $platform_gold_inventory = $row['platform_gold_inventory'];
    //     }
    // } else {
    //     $platform_gold_inventory = 0;
    // }

    // $sql = "SELECT SUM(cr_amount) - SUM(dr_amount) AS admin_capital FROM journal_entry WHERE account_id = 3;";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $admin_capital = $row['admin_capital'];
    //     }
    // } else {
    //     $admin_capital = 0;
    // }
    // //platform gold in
    // $sql = "SELECT SUM(amount) as gold_in from transaction where ( transaction_type='admin_gold_buy' or transaction_type = 'user_gold_sell' ) and transaction_status='approve' ";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $gold_in = $row['gold_in'];
    //     }
    // } else {
    //     $gold_in = 0;
    // }

    // //platform gold out
    // $sql = "SELECT SUM(amount) as gold_out from transaction where ( transaction_type='admin_gold_sell' or transaction_type = 'user_gold_buy' ) and transaction_status='approve' ";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $gold_out = $row['gold_out'];
    //     }
    // } else {
    //     $gold_out = 0;
    // }

    // $gold_inventory = $gold_in- $gold_out;

    // //currency and gold price
    // $sql = "select base_buy_price,base_sell_price from gold_price_history order by changed_at desc limit 1";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $base_buy_price= $row['base_buy_price'];
    //         $base_sell_price = $row['base_sell_price'];          
    //     }
    // } else {
    //     $base_buy_price=0;
    //     $base_sell_price = 0;
    // }
  

    // $data = json_decode(file_get_contents('php://input'), true);
    // if ($data) {
    //     //refill mmk
    //     $refill_mmk = $data['refill_mmk'];

    //     //refill dollar
    //     $refill_dollar =$data['refill_dollar'];
    //     $dollar_price = $data['dollar_price'];

    //     $type = $data['type'];

    //     //refill gold
    //     $refill_gold = $data['refill_gold'];
    //     $gold_price = $data['gold_price'];

    //     //refill mmk process
    //     if(isset($refill_mmk)){
    //         //first record in transaction table
    //         // SQL INSERT statement with placeholders
    //         $sql = "INSERT INTO transaction(user_id,currency_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?,?);";

    //         // Prepare the statement
    //         $stmt = $conn->prepare($sql);

    //         // Data to be inserted
    //         $user_id = 1;
    //         $currency_id = 3;
    //         $amount = $refill_mmk;
    //         $price = 1;
    //         $transaction_type = "refill wallet";
    //         $transaction_status = "complete";

    //         // Bind the variables to the prepared statement as parameters
    //         // 'sss' stands for three strings
    //         $stmt->bind_param("iiddss",$user_id,$currency_id,$amount,$price,$transaction_type,$transaction_status );

    //         // Execute the statement
    //         $stmt->execute();
    //         $stmt->close();

    //         //second incresae mmk amount in admin wallet

    //         // Data to be updated
    //         $amount = $refill_mmk+ $wallet['mmk'];
    //         $user_id = 1;
            
    //         // Prepare the SQL statement with placeholders
    //         $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 3;";
    //         $stmt = $conn->prepare($sql);

    //         // Bind parameters to the statement
    //         $stmt->bind_param("di", $amount,$user_id);

    //         // Execute the statement and check for success
    //         $stmt->execute();
    //         $stmt->close();
            

    //     }

    //     //refill dollar process
    //     if(isset($refill_dollar) && isset($dollar_price)){
    //         if($type == "exchange dollar"){
    //             //first record in transaction table
    //             // SQL INSERT statement with placeholders
    //             $sql = "INSERT INTO transaction(user_id,currency_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?,?);";

    //             // Prepare the statement
    //             $stmt = $conn->prepare($sql);

    //             // Data to be inserted
    //             $user_id = 1;
    //             $currency_id = 2;
    //             $amount = $refill_dollar;
    //             $price = $dollar_price;
    //             $transaction_type = $type;
    //             $transaction_status = "complete";

    //             // Bind the variables to the prepared statement as parameters
    //             // 'sss' stands for three strings
    //             $stmt->bind_param("iiddss",$user_id,$currency_id,$amount,$price,$transaction_type,$transaction_status );

    //             // Execute the statement
    //             $stmt->execute();
    //             $stmt->close();

    //             //second incresae dollar amount and decrease mmk amount in admin wallet

    //             // Data to be updated
    //             $amount = $refill_dollar+ $wallet['dollar'];
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 2;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();

    //             // Data to be updated
    //             $amount = $wallet['mmk'] - ($refill_dollar*$dollar_price);
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 3;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();
    //         }else if($type == "exchange mmk"){
    //             //first record in transaction table
    //             // SQL INSERT statement with placeholders
    //             $sql = "INSERT INTO transaction(user_id,currency_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?,?);";

    //             // Prepare the statement
    //             $stmt = $conn->prepare($sql);

    //             // Data to be inserted
    //             $user_id = 1;
    //             $currency_id = 2;
    //             $amount = $refill_dollar;
    //             $price = $dollar_price;
    //             $transaction_type = $type;
    //             $transaction_status = "complete";

    //             // Bind the variables to the prepared statement as parameters
    //             // 'sss' stands for three strings
    //             $stmt->bind_param("iiddss",$user_id,$currency_id,$amount,$price,$transaction_type,$transaction_status );

    //             // Execute the statement
    //             $stmt->execute();
    //             $stmt->close();

    //             //second incresae dollar amount and decrease mmk amount in admin wallet

    //             // Data to be updated
    //             $amount = $wallet['dollar']- $refill_dollar;
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 2;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();

    //             // Data to be updated
    //             $amount = $wallet['mmk'] + ($refill_dollar*$dollar_price);
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 3;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();
    //         }
    //     }

    //     //refill gold process
    //     if(isset($refill_gold) && isset($gold_price)){
    //         if($type== "exchange gold"){
    //             //first record in transaction table
    //             // SQL INSERT statement with placeholders
    //             $sql = "INSERT INTO transaction(user_id,currency_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?,?);";

    //             // Prepare the statement
    //             $stmt = $conn->prepare($sql);

    //             // Data to be inserted
    //             $user_id = 1;
    //             $currency_id = 1;
    //             $amount = $refill_gold;
    //             $price = $gold_price;
    //             $transaction_type = $type;
    //             $transaction_status = "complete";

    //             // Bind the variables to the prepared statement as parameters
    //             // 'sss' stands for three strings
    //             $stmt->bind_param("iiddss",$user_id,$currency_id,$amount,$price,$transaction_type,$transaction_status );

    //             // Execute the statement
    //             $stmt->execute();
    //             $stmt->close();

    //             //second incresae dollar amount and decrease mmk amount in admin wallet

    //             // Data to be updated
    //             $amount = $refill_gold+ $wallet['gold'];
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 1;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();

    //             // Data to be updated
    //             $amount = $wallet['dollar'] - ($refill_gold*$gold_price);
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 2;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();
    //         }else if($type == "exchange dollar"){
    //             //first record in transaction table
    //             // SQL INSERT statement with placeholders
    //             $sql = "INSERT INTO transaction(user_id,currency_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?,?);";

    //             // Prepare the statement
    //             $stmt = $conn->prepare($sql);

    //             // Data to be inserted
    //             $user_id = 1;
    //             $currency_id = 1;
    //             $amount = $refill_gold;
    //             $price = $gold_price;
    //             $transaction_type = $type;
    //             $transaction_status = "complete";

    //             // Bind the variables to the prepared statement as parameters
    //             // 'sss' stands for three strings
    //             $stmt->bind_param("iiddss",$user_id,$currency_id,$amount,$price,$transaction_type,$transaction_status );

    //             // Execute the statement
    //             $stmt->execute();
    //             $stmt->close();

    //             //second incresae dollar amount and decrease mmk amount in admin wallet

    //             // Data to be updated
    //             $amount =$wallet['gold'] - $refill_gold;
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 1;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();

    //             // Data to be updated
    //             $amount = $wallet['dollar'] + ($refill_gold*$gold_price);
    //             $user_id = 1;
            
    //             // Prepare the SQL statement with placeholders
    //             $sql = "UPDATE wallet SET amount = ? WHERE user_id = ? and currency_id = 2;";
    //             $stmt = $conn->prepare($sql);

    //             // Bind parameters to the statement
    //             $stmt->bind_param("di", $amount,$user_id);

    //             // Execute the statement and check for success
    //             $stmt->execute();
    //             $stmt->close();
    //         }
    //     }

    // $data = json_decode(file_get_contents('php://input'), true);
    // if ($data) {
    //     $amount = $data['amount'];
    //     $price = $data['price'];
    //     $transaction_type = $data['type'];
    //     $transaction_status= "approve";
    //     $user_id = 1;

    //     if($transaction_type === "capital_in"){
    //         //insert in transaction table
    //         $sql = "INSERT INTO transaction(user_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iddss",$user_id,$amount,$price,$transaction_type,$transaction_status );

    //         // Execute the statement
    //         $stmt->execute();
    //         $newTransactionId = $stmt->insert_id;
    //         $stmt->close();

    //         //insert in journal entry table
    //         $account_id = 1;
    //         $dr_amount= $amount;
    //         $cr_amount= 0;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();

    //         $account_id = 3;
    //         $dr_amount= 0;
    //         $cr_amount= $amount;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();
    //     }elseif($transaction_type === "capital_out"){
    //         //insert in transaction table
    //         $sql = "INSERT INTO transaction(user_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iddss",$user_id,$amount,$price,$transaction_type,$transaction_status );

    //         // Execute the statement
    //         $stmt->execute();
    //         $newTransactionId = $stmt->insert_id;
    //         $stmt->close();

    //         //insert in journal entry table
    //         $account_id = 3;
    //         $dr_amount= $amount;
    //         $cr_amount= 0;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();

    //         $account_id = 1;
    //         $dr_amount= 0;
    //         $cr_amount= $amount;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();            
    //     }elseif($transaction_type === "admin_gold_buy"){
    //         //insert in transaction table
    //         $sql = "INSERT INTO transaction(user_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iddss",$user_id,$amount,$price,$transaction_type,$transaction_status );

    //         // Execute the statement
    //         $stmt->execute();
    //         $newTransactionId = $stmt->insert_id;
    //         $stmt->close();

    //         //insert in journal entry table
    //         $account_id = 2;
    //         $dr_amount= $amount*$price;
    //         $cr_amount= 0;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();

    //         $account_id = 1;
    //         $dr_amount= 0;
    //         $cr_amount= $amount*$price;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();  

    //         $sql = "SELECT * FROM weighted_average_cost_gold_history ORDER BY changed_at DESC LIMIT 1;";
    //         $result = $conn->query($sql);

    //         if ($result->num_rows > 0) {
    //             // Output data of each row
    //             while($row = $result->fetch_assoc()) {
    //                 $gold_amount = $row['gold_amount'];
    //                 $total_cost = $row['total_cost'];
    //             }
    //         } else {
    //             $gold_amount = 0;
    //             $total_cost = 0;
    //         }
    //         $gold_amount= $gold_amount +$amount;
    //         $total_cost = $total_cost +($amount*$price);
    //         $wac_value = $total_cost / $gold_amount;
    //         $sql = "Insert into weighted_average_cost_gold_history (transaction_id,gold_amount,total_cost,wac_value) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iddd",$newTransactionId,$gold_amount,$total_cost,$wac_value);
    //         $stmt->execute();
    //         $stmt->close();

            
            
    //     }elseif($transaction_type === "admin_gold_sell"){
    //         //insert in transaction table
    //         $sql = "INSERT INTO transaction(user_id,amount,price,transaction_type,transaction_status) values (?,?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iddss",$user_id,$amount,$price,$transaction_type,$transaction_status );

    //         // Execute the statement
    //         $stmt->execute();
    //         $newTransactionId = $stmt->insert_id;
    //         $stmt->close();

    //         //insert in journal entry table
            
    //         $account_id = 1;
    //         $dr_amount= $amount*$price;
    //         $cr_amount= 0;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();  

    //         $sql = "SELECT * FROM weighted_average_cost_gold_history ORDER BY changed_at DESC LIMIT 1;";
    //         $result = $conn->query($sql);

    //         if ($result->num_rows > 0) {
    //             // Output data of each row
    //             while($row = $result->fetch_assoc()) {
    //                 $gold_amount = $row['gold_amount'];
    //                 $total_cost = $row['total_cost'];
    //                 $wac_value = $row['wac_value'];
    //             }
    //         } else {
    //             $wac_value = 0;
    //             $gold_amount = 0;
    //             $total_cost = 0;
    //         }

    //         $account_id = 6;
    //         $dr_amount= $amount*$wac_value;
    //         $cr_amount= 0;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();

    //         $account_id = 2;
    //         $dr_amount= 0;
    //         $cr_amount= $amount * $wac_value;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();

    //         $account_id = 5;
    //         $dr_amount= 0;
    //         $cr_amount= $amount*$price;
    //         $sql = "INSERT INTO journal_entry(transaction_id,account_id,dr_amount,cr_amount) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iidd",$newTransactionId,$account_id,$dr_amount,$cr_amount);
    //         $stmt->execute();
    //         $stmt->close();

    //         $gold_amount= $gold_amount -$amount;
    //         $total_cost = $total_cost -($amount*$wac_value);
    //         $wac_value = $total_cost / $gold_amount;
    //         $sql = "Insert into weighted_average_cost_gold_history (transaction_id,gold_amount,total_cost,wac_value) values (?,?,?,?);";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("iddd",$newTransactionId,$gold_amount,$total_cost,$wac_value);
    //         $stmt->execute();
    //         $stmt->close();

    //     }
    // }

    
    // }
    // Close the connection when you're done
    $conn->close();

    



?>