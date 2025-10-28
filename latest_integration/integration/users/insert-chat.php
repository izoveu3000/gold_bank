<?php 
session_start();  
             // Database connection details
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "goldbank";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

        $outgoing_id = 2;
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if(!empty($message)){
        $sql = mysqli_query($conn, "INSERT INTO message (incoming_msg_id, outgoing_msg_id, message_text, date, is_read)
        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', NOW(), 0)") or die();
}
    

    
?>
