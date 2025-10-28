<style>
	#sidebar {
  transition: transform 0.3s ease; /* smooth slide */
}

#sidebar.closed {
  transform: translateX(-100%) !important;
}

#sidebar.open {
  transform: translateX(0) !important;
}

@media (min-width: 992px) {
	#sidebar {
		transform: translateX(0) !important;
		width: 240px;
	}
	#content {
		margin-left: 240px; /* only shifts on big screens */
	}
}
@media (max-width: 991px) {
	#sidebar {
		transform: translateX(-100%);
		position: fixed;
		left: 0;
		top: 0;
		height: 100%;
		z-index: 999;
	}
	#content {
		margin-left: 0;
	}
}

</style>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
include 'header.php';
?>
<div class="dashboard-flex">
	<?php include 'nav.php'; ?>
	<div id="content" class="dashboard-main" >
		<script>
		// Sidebar logic
		document.addEventListener('DOMContentLoaded', function() {
			var sidebar = document.getElementById('sidebar');
			var toggleBtn = document.getElementById('toggleSidebar');
			var header = document.querySelector('nav.header-shiftable');
			var dashboardFlex = document.querySelector('.dashboard-flex');
			var content = document.getElementById('content');

			function openSidebar() {
				sidebar.classList.add("open");
				sidebar.classList.remove("closed");
				dashboardFlex.classList.remove("sidebar-closed");
				content.style.marginLeft = window.innerWidth >= 992 ? '240px' : '70px';
				content.style.width = '';
				if (header) header.classList.add("header-shifted");
			}

			function closeSidebar() {
				sidebar.classList.add("closed");
				sidebar.classList.remove("open");
				dashboardFlex.classList.add("sidebar-closed");
				content.style.marginLeft = '0';
				content.style.width = '100vw';
				if (header) header.classList.remove("header-shifted");
			}

			if (toggleBtn) {
				toggleBtn.onclick = function(e) {
					e.stopPropagation();
					if (sidebar.classList.contains("open")) {
						closeSidebar();
					} else {
						openSidebar();
					}
				};
			}

			function handleResize() {
				if (window.innerWidth < 992) {
					toggleBtn.style.display = 'inline-flex';
					closeSidebar();
				} else {
					toggleBtn.style.display = 'none';
					openSidebar();
				}
			}

			window.addEventListener('resize', handleResize);
			handleResize();

			feather.replace();
		});
		</script>
		<main class="container-fluid" style="background: #f8fcf9; min-height: 100vh; padding: 0;">
			<!-- <script>
			document.addEventListener('DOMContentLoaded', function() {
				var bankSelect = document.getElementById('bankSelect');
				var amountInput = document.getElementById('withdrawAmount');
				var requestBtn = document.getElementById('requestWithdrawBtn');
				var error = document.getElementById('error_alert');
				function validate() {
					var bankValid = bankSelect && bankSelect.value && bankSelect.value !== '' && bankSelect.value !== 'Select your bank account';
					var amountValid = amountInput && amountInput.value && !isNaN(amountInput.value) && Number(amountInput.value) >= 100 && Number(amountInput.value) <= 10000;
					if (bankValid && amountValid) {
						requestBtn.disabled = false;
						error.style.display = '';
						requestBtn.classList.remove('opacity-50', 'cursor-not-allowed');
					} else {
						requestBtn.disabled = true;
						error.style.display =none;
						requestBtn.classList.add('opacity-50', 'cursor-not-allowed');
					}
				}
				if (bankSelect && amountInput && requestBtn) {
					bankSelect.addEventListener('change', validate);
					amountInput.addEventListener('input', validate);
					validate();
				}
			});
			</script> -->
			<!-- Welcome -->
			<div class="p-6" style="margin-top:-32px;">
				<div class="flex items-center mb-4">
					<i data-feather="info" class="mr-2 text-green-600"></i>
					<span class="text-green-900 text-lg">Welcome back to your gold investment platform</span>
				</div>
				<h1 class="text-3xl font-bold text-green-900 mb-2">Withdraw Funds</h1>
				<p class="text-green-700 mb-6">Convert your coins back to real money</p>
				<!-- Available Balance -->
				<div class="bg-green-50 rounded-xl p-6 mb-6 shadow">
					<div class="flex flex-col md:flex-row justify-between items-center">
						<div class="text-center mb-4 md:mb-0">
							<div class="text-green-900 text-4xl font-bold" id="available_coin_balance"></div>
							<div class="text-green-700">Available for withdrawal</div>
						</div>
						<div class="flex gap-8">
							<div class="text-center">
								<div class="text-green-700">Price</div>
								<div class="text-green-900 font-bold" id="price">1 Coin = 1,000 MMK</div>
							</div>
							<div class="text-center">
								<div class="text-green-700">Daily Limit Remaining</div>
								<div class="text-green-900 font-bold" id="limit"></div>
							</div>
							<div class="text-center">
								<div class="text-green-700">Processing Fee</div>
								<div class="text-red-600 font-bold">0%</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Request Withdrawal -->
				<div class="bg-white rounded-xl p-6 mb-6 shadow">
					<h2 class="text-xl font-bold text-green-900 mb-4 flex items-center"><i data-feather="arrow-left-circle" class="mr-2 text-green-600"></i> Request Withdrawal</h2>
					<div class="mb-4">
						<label class="block text-green-700 mb-1">Bank Account</label>
						<select id="bankSelect" class="w-full border rounded px-3 py-2">
							<option value="not selected">Select your bank account</option>
							<?php
								// PHP code to fetch banks from the database
								include'database.php';
								$user_id = 5;
								$sql_banks = "SELECT bank_id, bank_name, account_number FROM bank where bank.user_id = $user_id and bank.active = 1";
								$result_banks = $conn->query($sql_banks);
								if ($result_banks && $result_banks->num_rows > 0) {
									while ($row_bank = $result_banks->fetch_assoc()) {
										echo '<option value="' . $row_bank['bank_id']  .  '">' . htmlspecialchars($row_bank['bank_name']) .' - '. htmlspecialchars(($row_bank['account_number'])) .' </option>';
									}
								}
								$conn->close();
								?>
						</select>
					</div>
					<div class="mb-4">
						<label class="block text-green-700 mb-1">Withdrawal Amount ($)</label>
						<input id="withdrawAmount" type="number" class="w-full border rounded px-3 py-2" placeholder="Enter amount to withdraw..." min="100" max="10000">
						<div class="flex justify-between text-xs text-green-700 mt-1">
							<span>Min: 100</span>
							<span>Max: 10,000</span>
						</div>
					</div>
					<div class="buygold-summary">
						<div class="buygold-summary-row"><span>Total Amount:</span><span id="TotalAmount"></span></div>
						<div class="buygold-summary-row buygold-summary-balance"><span>Processing Fee-0%:</span><span id="fee"></span></div>
						<div class="buygold-summary-row" style="font-weight:700;font-size:1.2rem;"><span>Received Amount:</span><span class="buygold-summary-cost" id="receive"></span></div>

					</div>
					<div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-4 rounded">
						<div class="font-bold text-orange-700 mb-2 flex items-center"><i data-feather="info" class="mr-2"></i> Withdrawal Information</div>
						<ul class="list-disc pl-6 text-orange-700">
							<li>Withdrawals are processed within 24-48 hours</li>
							<li>A processing fee of 3% applies to all withdrawals</li>
							<li>Bank transfers may take 3-5 business days to reflect</li>
							<li>You'll receive a confirmation email once processed</li>
						</ul>
					</div>
					<div id="error_message" style="display: none; color:red;"></div>
					<button id="requestWithdrawBtn" class="w-full bg-green-400 hover:bg-green-500 text-white font-bold py-3 rounded transition ">&larr; Request Withdrawal</button>
				
		</main>
		<script>
			var balance = 0;
			var price = 1000;
			var limit = 100000;
			var selectedBankId = "not selected";
			var value = 0;
			function refreshAllData() {
        		var xhttp = new XMLHttpRequest();
        		xhttp.onreadystatechange = function() {
            		if (this.readyState == 4 && this.status == 200) {
                		// Parse the JSON response text into a JavaScript object
                		var data = JSON.parse(this.responseText);
						// Now you can access each data point by its key
						balance = data.available_coin_balance;
                		document.getElementById("available_coin_balance").innerHTML = Number(data.available_coin_balance).toLocaleString()+" coin";
						limit_amount = limit - data.withdraw_amount;
						document.getElementById("limit").innerHTML= Number(limit_amount).toLocaleString()+" coin";
					
					}   
				};
				xhttp.open("GET", "withdraw_user_db_sql.php", true);
        		xhttp.send();  
			}
			refreshAllData();
			setInterval(() => {
				refreshAllData();
			}, 5000);

		
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const bankSelect = document.getElementById('bankSelect');
				const btn = document.getElementById("requestWithdrawBtn");
				const input_amount = document.getElementById("withdrawAmount");
				const error = document.getElementById('error_message');

				
				bankSelect.addEventListener('change', function(event) {
					selectedBankId = event.target.value;
				});

				input_amount.addEventListener('input',()=>{
					value = input_amount.value;
					document.getElementById("TotalAmount").innerHTML= (value * price).toLocaleString() + " MMK";
					document.getElementById("fee").innerHTML = ((value * price)*0).toLocaleString() + " MMK";
					document.getElementById("receive").innerHTML= ((value * price)-((value * price)*0)).toLocaleString()+ " MMK";
				});

				btn.addEventListener('click',function(){
					if(selectedBankId == "not selected"){
						error.innerHTML="please choose your bank account";
						error.style.display= "block";
					}else if(value == 0){
						error.innerHTML= "please fill withdraw amount";
						error.style.display= "block";
					}else if(value>limit_amount){
						error.innerHTML="your daily limit remaining amount is "+limit_amount.toLocaleString() + " Coins";
						error.style.display="block";
					}else if(value>balance){
						error.innerHTML = "insufficient coin balance";
						error.style.display="block";
					}else if(value<100){
						error.innerHTML="cannot withdraw below 100 coins amount";
						error.style.display="block";
					}else{
						var userData = {
                    		bank_id : selectedBankId,
							amount : value,
							

                		};

            			fetch('withdraw_user_db_sql.php', {
                			method: 'POST',
                			headers: {
                				'Content-Type': 'application/json',
                			},
                			body: JSON.stringify(userData),
            			})
						alert('withdraw request is successfully sent');
						bankSelect.value = "not selected"; // reset combo box
        input_amount.value = "";           // clear input
        document.getElementById("TotalAmount").innerHTML = "";
        document.getElementById("fee").innerHTML = "";
        document.getElementById("receive").innerHTML = "";

        // Reset JS variables
        selectedBankId = "not selected";
        value = 0;
		window.location.href= "pending(user).php";

						
					}
				});
				
			});
		</script>

	</div>
</div>
<?php include 'footer.php'; ?>
