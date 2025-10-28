<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
$_SESSION['unique_id'] = 1;
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "goldbank";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);


    
?>
<html lang="en">
<head>
  
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head> 
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
     
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];  // <-- This is how you get POST data

} else {
    echo "No POST data received.";
}


          $sql = mysqli_query($conn, "SELECT * FROM users WHERE user_id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }
        ?>
        <a href="#" onclick="window.history.back()" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['user_name']; ?></span>
          <p>
          <?php
          date_default_timezone_set('Asia/Yangon');
          if($row['status'] == "Offline now"){
          echo "<small>Last seen: ".date("d M Y h:i A", strtotime($row['last_seen']))."</small>";
         }else{
          echo "<small>Active now</small>";
         }
         ?>
         </p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="chat.js"></script>

</body>
</html>

