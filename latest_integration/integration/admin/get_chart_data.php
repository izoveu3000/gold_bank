 <?php
 session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
    header('Content-Type: application/json');
    //database-connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "goldbank";
    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $gold_transacton_fee = [0,0,0,0,0,0,0,0,0,0,0,0];
    $total_transaction_fee = 0;
    
    // Create a new MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

    // Fetch records for that year
    $sql = " SELECT SUM(amount*(price*0.01)) AS transaction_fee ,DATE_FORMAT(date, '%b') as months FROM transaction WHERE year(date) = ? AND (transaction_type = 'user_gold_buy' or transaction_type= 'user_gold_sell') AND transaction_status='approve' GROUP BY MONTHNAME(date) ORDER BY date";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $year);
    $stmt->execute();
    $result = $stmt->get_result();
     while ($row = $result->fetch_assoc()) {
        $transaction_fee = $row['transaction_fee'];
        $searchValue = $row['months'];
        $index = array_search($searchValue, $months);
        $gold_transacton_fee[$index] = $transaction_fee*1000;
        $total_transaction_fee= $total_transaction_fee + $transaction_fee;
    }

    
    

   

    echo json_encode([
        'months' => $months,
        'gold_transaction_fee'=>$gold_transacton_fee,
        'total_transaction_fee'=>$total_transaction_fee*1000
    ]);
 ?>