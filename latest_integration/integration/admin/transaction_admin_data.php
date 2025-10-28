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

    //create a new MySQLi connection
    $conn = new mysqli($servername,$username,$password,$dbname);
    

    //first all retreive all transactions
    $transactions = array();
    $sql = "SELECT * FROM transaction 
        LEFT JOIN users ON transaction.user_id = users.user_id 
        LEFT JOIN transaction_approve ON transaction.transaction_id = transaction_approve.tran_id 
        LEFT JOIN bank ON transaction_approve.bank_id = bank.bank_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            //this is transaction date and time
            $full_datetime= $row["date"];
            $date_object = new DateTime($full_datetime);
            $date_only = $date_object->format('Y-m-d');
            $time_only = $date_object->format('H:i:s');
          
            //this is reference_number
            if($row['reference_number']===null){
                $reference_number = "-";
                $bank_name ="-";
            }else{
                $reference_number= $row["reference_number"];
                $bank_name = $row['bank_name'];
                
            }
            

            //this is style class for transacton_status
            if($row["transaction_status"]== "pending" || $row["transaction_status"]== "warn"){
                $status_class = "status-pending";
            }else if($row["transaction_status"]== "approve"){
                $status_class = "status-completed";
            }else{
                $status_class = "status-failed";
            }
            //this is style class for transaction_type
            if($row["transaction_type"]== "deposit"){
                $type_class = "type-deposit";
                $amount_class = "amount-usd";
                $currency_name = "coin";
            }else if($row["transaction_type"]== "withdraw"){
                $type_class = "type-withdrawal";
                $amount_class = "amount-usd";
                $currency_name = "coin";
            }else if($row["transaction_type"]== "user_gold_buy"){
                $type_class = "type-transfer";
                $amount_class = "amount-gold";
                $currency_name = "gold";
            }else if($row["transaction_type"]== "user_gold_sell"){
                $type_class = "type-conversion";
                $amount_class = "amount-gold";
                $currency_name = "gold";
            }
            


            $newtransaction = [
                "transaction_id"=> $row["transaction_id"],
                "user_id"=> $row["user_id"],
                "user_name"=> $row["user_name"],
                "transaction_type"=> $row["transaction_type"],
                "type_class" => $type_class,
                "amount"=> $row["amount"],
                "amount_class" => $amount_class,
                "currency_name" => $currency_name,
                "transaction_status"=> $row["transaction_status"],
                "status_class"=> $status_class,
                "transaction_date"=> $date_only,
                "transaction_time"=> $time_only,
                "reference_number"=> $reference_number,
                "bank_name"=>$bank_name

            ];
            $transactions[] = $newtransaction;
        }
    }
    $conn->close();


?>
