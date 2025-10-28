
<!-- Feather Icons Script for Sidebar Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>feather.replace();</script>
<!-- New Modern Responsive Sidebar -->
<aside id="sidebar" class="dashboard-sidebar">
	<div class="sidebar-header flex items-center justify-center py-6 border-b border-blue-800">
		<i data-feather="box" class="text-yellow-400 w-7 h-7"></i>
		<span class="logo-text ml-3 font-bold text-2xl">GoldVault</span>
	</div>
	<nav class="sidebar-nav flex-1 py-6">
		<ul class="space-y-2">
			<li>
				   <a href="dashboard(admin).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors">
					<i data-feather="home" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="transaction_page(admin).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors">
					<i data-feather="clock" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Transactions History</span>
				</a>
			</li>
			<li>
				<a href="user_page(admin).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors">
					<i data-feather="user" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Users</span>
				</a>
			</li>
			<li>
				<a href="gold_purchase_page(admin).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors">
					<i data-feather="dollar-sign" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Purchase Gold</span>
				</a>
			</li>
			<li>
				<a href="deposite_page(admin).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors">
					<i data-feather="award" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Deposit</span>
				</a>
			</li>
			<li>
				<a href="withdraw_page(admin).php" class="flex items-center px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors">
					<i data-feather="credit-card" class="w-5 h-5"></i>
					<span class="nav-text ml-4">Withdraw</span>
				</a>
			</li>
		</ul>
	</nav>
	<div class="sidebar-footer py-6 border-t border-blue-800 flex justify-center">
		<a href="logout.php" class="flex items-center px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors">
			<i data-feather="log-out" class="w-5 h-5"></i>
			<span class="nav-text ml-4">Logout</span>
		</a>
	</div>
</aside>
