<?php
session_start();
//comment
// if (isset($_GET['amount']) && isset($_GET['totalMMK']) && isset($_GET['rate'])) {
//     $_SESSION['recharge_usd'] = (float)$_GET['amount'];
//     $_SESSION['recharge_mmk'] = (float)($_GET['amount'] * $_GET['rate']);
//     $_SESSION['recharge_service_fee'] = $_SESSION['recharge_mmk'] * 0.03;
//     $_SESSION['recharge_total_mmk'] = $_SESSION['recharge_mmk'] + $_SESSION['recharge_service_fee'];

// 	 // Store the base rate
//     $baseRate = isset($_GET['rate']) ? (float)$_GET['rate'] : 1;
//     $_SESSION['recharge_rate'] = $baseRate; 



// 	//original price
// 	$_SESSION['price'] =$_SESSION['recharge_rate'] ;


// }
	if(isset($_POST['amount'])){
		$amount = $_POST['amount'];
		$amount_mmk = $amount * 1000;
		$service_fee_mmk = 0; // Currently 0 based on your display logic
		$total_to_transfer_mmk = $amount_mmk + $service_fee_mmk;
	}else{
		header("Location: rechargecoin(user).php");
		exit();
	}
?>

<style>
    .submit-main {
					padding: 32px 0;
				}
				.submit-title {
					font-size: 2.2rem;
					font-weight: 700;
					color: #1a4d2e;
					margin-bottom: 8px;
				}
				.submit-subtitle {
					color: #6c8e6b;
					font-size: 1.15rem;
					margin-bottom: 32px;
				}
				.submit-card {
					background: linear-gradient(135deg, #f8fcf7 95%, #e6f4ea 100%);
					border-radius: 16px;
					box-shadow: 0 2px 16px #e6f4ea;
					padding: 24px 24px 16px 24px;
					margin-bottom: 24px;
					position: relative;
				}
				.submit-section {
					background: #e3f0e7;
					border-radius: 12px;
					padding: 24px;
					margin-bottom: 18px;
					border: 1px solid #b6e2c6;
				}
				.submit-section-yellow {
					background: #fff7e3;
					border-radius: 12px;
					padding: 24px;
					margin-bottom: 18px;
					border: 1px solid #ffe082;
				}
				.submit-section-title {
					font-size: 1.15rem;
					font-weight: 600;
					color: #1a4d2e;
					margin-bottom: 12px;
					display: flex;
					align-items: center;
					gap: 8px;
				}
				.submit-section-title .icon {
					color: #219a43;
					font-size: 1.3rem;
				}
				.submit-section-yellow .icon {
					color: #ffa000;
					font-size: 1.3rem;
				}
				.submit-details {
					font-size: 1.08rem;
					color: #222;
				}
				.submit-details b {
					color: #1a4d2e;
				}
				.submit-label {
					font-size: 1.08rem;
					color: #1a4d2e;
					font-weight: 500;
					margin-bottom: 6px;
				}
				.submit-input {
					width: 100%;
					padding: 12px;
					border-radius: 8px;
					border: 1px solid #e6f4ea;
					font-size: 1rem;
					margin-bottom: 18px;
				}
				.submit-upload {
					background: #f8fcf7;
					border: 2px dashed #b6e2c6;
					border-radius: 12px;
					padding: 32px 0 16px 0;
					text-align: center;
					margin-bottom: 18px;
				}
				.submit-upload .icon {
					color: #219a43;
					font-size: 2.2rem;
					margin-bottom: 8px;
				}
				/* .submit-upload-btn {
					background: #fff;
					color: #1a4d2e;
					border: 1px solid #e6f4ea;
					border-radius: 8px;
					padding: 8px 24px;
					font-size: 1rem;
					font-weight: 500;
					cursor: pointer;
					margin-top: 8px;
				} */
				.submit-upload-btn {
				background: #fff;
				color: #1a4d2e;
				border: 1px solid #e6f4ea;
				border-radius: 8px; /* Slightly larger border-radius for modern look */
				padding: 8px 20px;
				font-size: 1rem;
				font-weight: 500;
				cursor: pointer;
				/* margin-top: 8px; <--- REMOVED this line */

				/* ADDED for icon alignment */
				display: inline-flex;
				align-items: center;
				justify-content: center;
				transition: background-color 0.2s; /* Added transition */
			}

			.submit-upload-btn:hover {
				background-color: #f0f8f4; /* Light hover background */
			}

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
	<!-- Removed duplicate dashboard-flex and nav include -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
include 'header.php';
?>
<div class="dashboard-flex">
	<!-- Responsive Toggle Sidebar Button -->
	<button id="toggleSidebar" class="p-2 bg-green-600 border border-green-700 rounded shadow-sm absolute top-4 left-4 z-50 d-lg-none" style="display:inline-flex;align-items:center;justify-content:center;">
		<i data-feather="menu" style="width:24px;height:24px;color:#fff;"></i>
	</button>
	<?php include 'nav.php'; ?>
	<div id="content" class="dashboard-main" >
		<script>
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
		<?php
			// include'database.php';
			// $rechargeAmountUSD = isset($_GET['amount']) ? (float)$_GET['amount'] : 0;

			// $sql = "SELECT price FROM currency_price WHERE currency_id = 2 ORDER BY changed_at DESC LIMIT 1";
			// $result = $conn->query($sql);


			// $exchangeRateMMK = 0;
			// if ($result && $result->num_rows > 0) {
			// 	$row = $result->fetch_assoc();
			// 	$exchangeRateMMK = $row['price'];
			// }
			// $rechargeAmountMMK = $rechargeAmountUSD * $exchangeRateMMK;
	        // $conn->close();


		?>
		<main class="container-fluid" style="background: #f8fcf9; min-height: 100vh; padding: 0;">
			<div class="submit-main">
				<div class="submit-title">Recharge Coins</div>
				<div class="submit-subtitle">Add funds to your wallet to purchase gold</div>
				<form id="rechargeForm" action="submit_recharge_db_sql.php" method="POST" enctype="multipart/form-data">

                <div class="submit-card">
                    <div class="submit-section-title"><span class="icon">&#x21bb;</span> Submit Payment Proof</div>
                    <div class="submit-section">
                        <div class="submit-section-title"><span class="icon" style="font-size:1.1rem;">&#128222;</span> Admin Payment Details</div>
                        <div class="submit-details">
                            
                            <b>Phone:</b> +1 (555) 123-4567<br>
                            
                            <b>Payment</b> 
                            <select name="bank_id" id="bank-select" class="submit-input" required>
                                <option value="">Select a bank</option>

                                <?php
                                // PHP code to fetch banks from the database
                                // NOTE: Ensure 'database.php' connects and returns a $conn object
                                include 'database.php';

                                $sql_banks = "SELECT bank_id, bank_name, account_number FROM bank WHERE user_id=1 AND active = 1";
                                $result_banks = $conn->query($sql_banks);
                                if ($result_banks && $result_banks->num_rows > 0) {
                                    while ($row_bank = $result_banks->fetch_assoc()) {
                                        echo '<option value="' . $row_bank['bank_id']  . '" data-account-number="' . htmlspecialchars($row_bank['account_number']) . '">' . htmlspecialchars($row_bank['bank_name']) . '</option>';
                                    }
                                }
                                $conn->close();
                                ?>
                            </select>
                            
                            <div id="bank-details-container">
                                <b id="account-number-label" style="display: none;">Account Number:</b> <span id="account-number-value"></span><br>
                            
                                <b>Requested Amount (Coins):</b> <?php echo number_format($amount,0); ?> Coins<br>
                                <b>Amount (MMK):</b> <?php echo number_format($amount_mmk, 0); ?> MMK<br>
                                <b>Service Fee (MMK):</b> <?php echo number_format($service_fee_mmk, 0); ?> MMK<br>
                                <b>Total to Transfer (MMK):</b> <?php echo number_format($total_to_transfer_mmk, 0); ?> MMK<br>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section-yellow">
                        <div class="submit-section-title"><span class="icon">&#9888;</span> Payment Instructions</div>
                        <div class="submit-details">
                            1. Transfer the exact amount to the admin account above<br>
                            2. Take a screenshot of the successful transfer<br>
                            3. Upload the screenshot and enter your transaction ID below<br>
                            4. Wait for admin verification (usually within 2-4 hours)<br>
                            5. Coins will be added to your wallet once verified
                        </div>
                    </div>
                    
                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
                    


                    <div class="submit-label">Transaction ID</div>
                    <input type="text" name="transaction_id" class="submit-input" placeholder="Enter your transaction ID..." required>
                    
                    <div class="submit-label">Upload Payment Screenshot</div>
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom: 18px;">
                           <label for="file-upload" class="submit-upload-btn" id="upload-label">
                               <i data-feather="upload" style="width:18px;height:18px;margin-right:6px;"></i>
                                   Choose File
                           </label>
                           <input id="file-upload" type="file" name="payment_screenshot" style="display: none;" required>
                           <span id="file-name-status" style="color:#6c8e6b;font-size:0.98rem;">No file chosen</span>
                        </div>
                    <div id="image-preview-container" style="margin-bottom: 18px; display: none;">
                        <img id="image-preview" src="#" alt="Payment Screenshot Preview" 
                            style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #e6f4ea; object-fit: contain;">
                    </div>
                    
                    <div id="error_message" style="display: none; color: #d9534f; margin-bottom: 18px; font-weight: 500;"></div>

                    <div style="display:flex;gap:16px;margin-top:24px;">
                        <button id="backBtn" type="button" style="flex:1;background:#fff;color:#1a4d2e;border:1px solid #e6f4ea;border-radius:8px;padding:12px 0;font-size:1.1rem;font-weight:500;cursor:pointer;">Back</button>
                        <button type="submit" style="flex:2;background:linear-gradient(90deg,#219a43,#43e97b);color:#fff;border:none;border-radius:8px;padding:12px 0;font-size:1.1rem;font-weight:600;cursor:pointer;">Submit Proof</button>
                    </div>
                </div>
            </form>
			</div>
		</main>
	</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initial feather icon replacement
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        const form = document.getElementById('rechargeForm'); // Select the form by its new ID
        const fileInput = document.getElementById('file-upload');
        const fileNameStatus = document.getElementById('file-name-status');
        const imagePreview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const errorMessage = document.getElementById('error_message');
        const defaultFileStatusColor = '#6c8e6b';

        // Helper function to reset the file input and error state
        function resetFileState(isError = false, message = 'No file chosen') {
            fileInput.value = "";
            fileNameStatus.textContent = message;
            fileNameStatus.style.color = isError ? '#d9534f' : defaultFileStatusColor;
            imagePreview.src = '#';
            previewContainer.style.display = 'none';
            errorMessage.style.display = 'none';
        }

        // --- File Input Change Handler (for preview and status) ---
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (!file) {
                resetFileState();
                return;
            }

            const fileType = file.type;
            
            if (fileType.startsWith('image/')) {
                // File is an image: show preview and clear error
                const fileName = file.name;
                fileNameStatus.textContent = 'File Chosen: ' + (fileName.length > 30 ? fileName.substring(0, 27) + '...' : fileName);
                fileNameStatus.style.color = defaultFileStatusColor;
                errorMessage.style.display = 'none';
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);

            } else {
                // File is NOT an image: show error and reset file input (crucial!)
                const errorMsgText = 'The selected file is NOT an image. Please select a valid screenshot.';
                
                // Reset the input value and update status with error
                resetFileState(true, 'ERROR: Invalid file type.'); 

                // Display detailed error message
                errorMessage.textContent = errorMsgText;
                errorMessage.style.display = 'block';
            }
        });

        // --- Form Submission Handler (The solution to prevent submission) ---
        form.addEventListener('submit', function(e) {
            const file = fileInput.files[0];
            
            // 1. Check if the required file input has a file
            if (!file) {
                e.preventDefault(); // STOP submission
                errorMessage.textContent = 'Please upload the payment screenshot (required).';
                errorMessage.style.display = 'block';
                fileNameStatus.textContent = 'File required!';
                fileNameStatus.style.color = '#d9534f';
                return;
            }

            // 2. Validate the file type on submit
            if (!file.type.startsWith('image/')) {
                e.preventDefault(); // STOP submission
                
                // Set final error messages
                errorMessage.textContent = 'The selected file is not a valid image. Submission blocked.';
                errorMessage.style.display = 'block';
                fileNameStatus.textContent = 'Invalid file type!';
                fileNameStatus.style.color = '#d9534f'; 
                
                // Prevent the user from being stuck by resetting the input value
                fileInput.value = ""; 
            }
            // If valid, the form proceeds to submit_recharge_db_sql.php
        });


        // Bank select logic (from your original code)
        const bankSelect = document.getElementById('bank-select');
        const accountNumberValue = document.getElementById('account-number-value');
        const accountNumberLabel = document.getElementById('account-number-label');

        bankSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const accountNumber = selectedOption.getAttribute('data-account-number');

            if (accountNumber) {
                accountNumberValue.textContent = accountNumber;
                accountNumberLabel.style.display = 'inline';
            } else {
                accountNumberValue.textContent = '';
                accountNumberLabel.style.display = 'none';
            }
        });
    });
    
</script>
<script>

document.getElementById('backBtn').onclick = function() {

    window.location.href = 'rechargecoin(user).php';

};

</script>
<?php include 'footer.php'; ?>
