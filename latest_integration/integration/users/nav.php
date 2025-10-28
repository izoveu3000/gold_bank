<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "goldbank";

$conn = new mysqli($servername, $username, $password, $dbname);

$current_user_id = 2; // or use $_SESSION['unique_id'] if available

// Only show unread count if not inside chat page
$unread_count = 0;
if (!isset($in_chat_page)) {
    $sql = "SELECT COUNT(*) AS unread_count FROM message WHERE incoming_msg_id = ? AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];
}


?>
<!-- Feather Icons Script for Sidebar Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>feather.replace();</script>
<!-- New Modern Responsive Sidebar -->
<aside id="sidebar" class="dashboard-sidebar">
	<div class="sidebar-header flex items-center justify-center py-6 border-b border-green-600">
		<i data-feather="box" class="text-green-700 w-7 h-7"></i>
		<span class="logo-text ml-3 font-bold text-2xl">GoldVault</span>
	</div>
	<nav class="sidebar-nav flex-1 py-6">
		<ul class="space-y-2">
			<li>
				   <a href="dashboard(user).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
					<i data-feather="home" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="history(user).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
					<i data-feather="clock" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Transactions History</span>
				</a>
			</li>
			<li>
				<a href="pending(user).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
					<i data-feather="alert-circle" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Pending</span>
				</a>
			</li>
			<li>
				<a href="rechargecoin(user).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
					<i data-feather="dollar-sign" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Recharge Coins</span>
				</a>
			</li>
			<li>
				<a href="buygold(user).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
					<i data-feather="award" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Buy Gold</span>
				</a>
			</li>
			<li>
				<a href="sell_gold(user).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
					<i data-feather="award" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Sell Gold</span>
				</a>
			</li>
			<li>
				<a href="withdraw(user).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
					<i data-feather="credit-card" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Withdraw</span>
				</a>
			</li>
			<li>
				<a href="#" id="link" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors relative">
    <i data-feather="message-circle" class="w-5 h-5"></i>
    <span class="nav-text ml-4">Messages</span>

    <?php if ($unread_count > 0): ?>
<span id="unread-badge" class="absolute top-1 right-4 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
    <?php echo $unread_count; ?>
</span>
<?php endif; ?>
</a>

			</li>
		</ul>
	</nav>
	<div class="sidebar-footer py-6 border-t border-green-600 flex justify-center">
		<a href="#" class="flex items-center px-6 py-3 rounded-lg hover:bg-green-100 transition-colors">
			<i data-feather="log-out" class="w-5 h-5"></i>
			<span class="nav-text ml-4">Logout</span>
		</a>
	</div>
</aside>
<script>
    // Now the script can find the 'link' element
    const link = document.getElementById('link');
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevents the default anchor tag behavior

        const userId = 1;
        
        // Create a form element dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'user_chat.php';

        // Create a hidden input to send the user ID
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'user_id';
        input.value = userId;

        // Append the input to the form and the form to the body
        form.appendChild(input);
        document.body.appendChild(form);

        // Submit the form
        form.submit();
    });
	document.addEventListener("DOMContentLoaded", function() {
  const chatView = document.getElementById("chat-view");
  const dashboardView = document.getElementById("dashboard-view");
  const openChatBtn = document.getElementById("openChat");
  const openDashboardBtn = document.getElementById("openDashboard");

  if (openChatBtn) {
    openChatBtn.addEventListener("click", function(e) {
      e.preventDefault();
      dashboardView.style.display = "none"; 
      chatView.style.display = "block";
    });
  }

  if (openDashboardBtn) {
    openDashboardBtn.addEventListener("click", function(e) {
      e.preventDefault();
      chatView.style.display = "none"; 
      dashboardView.style.display = "block";
    });
  }
});

</script>


