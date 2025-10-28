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

        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if(!empty($message)){
        $sql = mysqli_query($conn, "INSERT INTO message (incoming_msg_id, outgoing_msg_id, message_text, date, is_read)
        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', NOW(), 0)") or die();
}
    

    
?>
<?php 
//     session_start();
//     if(isset($_SESSION['unique_id'])){
//         include_once "config.php";
//         $outgoing_id = $_SESSION['unique_id'];
//         $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
//         $message = mysqli_real_escape_string($conn, $_POST['message']);
//         if(!empty($message)){
//         $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, msg_time, is_read)
//         VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', NOW(), 0)") or die();
// }
//     }else{
//         header("location: ../login.php");
//     }


    
?>