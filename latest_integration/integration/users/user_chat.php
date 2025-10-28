<?php
session_start();
$_SESSION['unique_id'] = 5;
// Database connection details (use the project's DB settings)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "goldbank";

// Create a new MySQLi connection and check
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Database connection failed: ' . $conn->connect_error);
}


    
?>
<html lang="en">
<head>
  
  <link rel="stylesheet" href="../css/user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
</head> 
<body>
   <div class="dashboard-flex">
  <!-- Sidebar -->
  <div id="sidebar">
    <?php 
     $in_chat_page = true;
    include 'nav.php'; ?>
  </div>
  </div>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
     
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];  // <-- This is how you get POST data

} else {
    echo "No POST data received.";
}

// Prepared statement to fetch the user
$stmt = $conn->prepare('SELECT * FROM users WHERE user_id = ? LIMIT 1');
if (!$stmt) {
  die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param('i', $user_id);
if (!$stmt->execute()) {
  die('Execute failed: ' . $stmt->error);
}
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  header('Location: users.php');
  exit;
}
$stmt->close();
        ?>
        <button id="toggleSidebar" 
  class="btn btn-link d-flex align-items-center justify-content-center"
  style="background: #f4f7f4ff; border: none; margin: 13px; color: #097d22ff; border-radius: 50%; width: 20px; height: 20px;">
  <i data-feather="box"></i>
</button>
<!-- <button id="toggleSidebar" class="expand-icon btn btn-link d-flex align-items-center justify-content-center" style="background: #eaedebff; border: none; margin-right: 5px; color: #16a41dff; border-radius: 50%; width: 20px; height: 20px; box-shadow: 0 2px 8px rgba(56,142,60,0.08);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" fill="none" viewBox="0 0 24 24">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="#222" stroke-width="2" fill="#fff"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="#222" stroke-width="2" fill="none"/>
                        <line x1="12" y1="22.08" x2="12" y2="12" stroke="#222" stroke-width="2"/>
                    </svg>
                </button> -->


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
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    feather.replace(); // Refresh Feather icons
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  feather.replace();

  const sidebar = document.getElementById('sidebar');
  const content = document.getElementById('content');
  const toggleBtn = document.getElementById('toggleSidebar');

  toggleBtn.addEventListener('click', function() {
    sidebar.classList.toggle('hidden');
    //content.classList.toggle('full');
  });
  function handleResize() {
    if (window.innerWidth < 992) {
      sidebar.classList.add('hidden');
      //content.classList.add('full');
    } else {
      sidebar.classList.remove('hidden');
      //content.classList.remove('full');
    }
  }

  window.addEventListener('resize', handleResize);
  handleResize(); // Run once on page load

});
</script>

</body>
</html>

