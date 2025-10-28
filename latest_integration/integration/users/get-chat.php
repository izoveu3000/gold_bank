<?php 
session_start();


$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "goldbank";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$outgoing_id = 2;
$incoming_id = intval($_POST['incoming_id']); // safer than string escape
$output = "";

// Fetch messages
$sql = "SELECT message.*, users.user_name, users.img 
        FROM message 
        LEFT JOIN users ON users.user_id = message.outgoing_msg_id
        WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?)
           OR (outgoing_msg_id = ? AND incoming_msg_id = ?)
        ORDER BY message_id ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
$stmt->execute();
$result = $stmt->get_result();

// Mark messages as read
$update_sql = "UPDATE message 
               SET is_read = 1 
               WHERE incoming_msg_id = ? 
                 AND outgoing_msg_id = ? 
                 AND is_read = 0";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("ii", $outgoing_id, $incoming_id);
$update_stmt->execute();

// Render messages
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['outgoing_msg_id'] == $outgoing_id) {
            // Outgoing
            $output .= '<div class="chat outgoing">
                          <div class="details">
                              <p>'. htmlspecialchars($row['message_text']) .'</p>
                              <small style="color:gray;">'. date("d M Y h:i A", strtotime($row['date'])) .'</small>
                          </div>
                        </div>';
        } else {
            // Incoming
            $output .= '<div class="chat incoming">
                          <img src="'. htmlspecialchars($row['img']) .'" alt="">
                          <div class="details">
                              <p>'. htmlspecialchars($row['message_text']) .'</p>
                              <small style="color:gray;">'. date("d M Y h:i A", strtotime($row['date'])) .'</small>
                          </div>
                        </div>';
        }
    }
} else {
    $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
}

echo $output;
?>
