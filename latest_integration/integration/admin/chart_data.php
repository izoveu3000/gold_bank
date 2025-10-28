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

    // Create a new MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //getting min and max gold price in each month

    $data = [
    'days' => [],
    'base_buy_price' => [],
    'base_sell_price' => [],
    
];


    // Get month (format: YYYY-MM)
    $month_year = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

    // Fetch records for that month
    $sql = " SELECT AVG(base_buy_price) as base_buy_price,AVG(base_sell_price) as base_sell_price,day(changed_at) as day FROM gold_price_history WHERE  DATE_FORMAT(changed_at, '%Y-%m')= ? GROUP BY date(changed_at) ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $month_year);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data['days'][] = $row['day'];
        $data['base_buy_price'][] = (float)$row['base_buy_price'];
        $data['base_sell_price'][] = (float)$row['base_sell_price'];
    }

    

echo json_encode($data); 



?>