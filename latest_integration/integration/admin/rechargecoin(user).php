<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
?>
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
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8fcf7; margin: 0; }
        .container { width: 1200px; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px #e6f4ea; padding: 32px; }
        h1 { color: #1a4d2e; margin-bottom: 8px; }
        .subtitle { color: #6c8e6b; margin-bottom: 32px; }
        .packages { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; margin-bottom: 32px; }
        .package { background: linear-gradient(135deg, #f8fcf7 80%, #e6f4ea 100%); border: 2px solid #e6f4ea; border-radius: 12px; padding: 32px 24px; text-align: center; transition: box-shadow 0.2s; position: relative; }
        .package:hover { box-shadow: 0 4px 24px #cde9d6; border-color: #b6e2c6; }
        .package .popular { position: absolute; top: 16px; right: 16px; background: #ffd700; color: #fff; font-size: 12px; padding: 2px 10px; border-radius: 8px; font-weight: bold; }
        .package.selected {
            border-color: #388e3c;
            background: #f8fcf7;
        }
        .package.selected .checkmark {
            display: block;
            position: absolute;
            top: 16px;
            right: 16px;
            color: #388e3c;
            font-size: 1.5rem;
        }
        .checkmark {
            display: none;
        }
        .package-amount { font-size: 2rem; color: #1a4d2e; font-weight: bold; }
        .package-bonus { color: #2e7d32; font-size: 1rem; margin-top: 8px; }
        .package-total { color: #1a4d2e; font-size: 1.1rem; margin-top: 8px; font-weight: 500; }
        .custom-section { background: linear-gradient(135deg, #f8fcf7 80%, #e6f4ea 100%); border-radius: 12px; padding: 32px 24px; margin-top: 24px; }
        .custom-label { font-size: 1.2rem; color: #1a4d2e; font-weight: 500; margin-bottom: 12px; }
        .custom-input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e6f4ea; font-size: 1rem; margin-bottom: 8px; }
        .custom-note { color: #6c8e6b; font-size: 0.95rem; }
        @media (max-width: 900px) {
            .packages { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .container { padding: 12px; }
            .packages { grid-template-columns: 1fr; gap: 16px; }
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
        <main class="container-fluid" style="background: #f8fcf9; min-height: 100vh; padding: 0;">

            <div class="container">
                    <h1 style="font-size: 45px;">Recharge Coins</h1>
                    <div class="subtitle">Add funds to your wallet to purchase gold</div>
                    <div style="margin-bottom: 24px; font-size: 1.15rem; color: #1a4d2e; font-weight: 500;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 1.3rem;">&#128176;</span> Select Recharge Package
                        </span>
                    </div>
                    <div class="packages">
                        <div class="package" data-amount="1000">
                            <div class="package-amount">$1,000</div>
                            <div class="package-total">Total: $1,000</div>
                            <span class="checkmark">&#10003;</span>
                        </div>
                        <div class="package" data-amount="2500" data-bonus="50">
                            <div class="package-amount">$2,500</div>
                            <div class="package-bonus">+ $50 Bonus</div>
                            <div class="package-total">Total: $2,550</div>
                            <span class="checkmark">&#10003;</span>
                        </div>
                        <div class="package" data-amount="5000" data-bonus="150">
                            <span class="popular">Popular</span>
                            <div class="package-amount">$5,000</div>
                            <div class="package-bonus">+ $150 Bonus</div>
                            <div class="package-total">Total: $5,150</div>
                            <span class="checkmark">&#10003;</span>
                        </div>
                        <div class="package" data-amount="10000" data-bonus="400">
                            <div class="package-amount">$10,000</div>
                            <div class="package-bonus">+ $400 Bonus</div>
                            <div class="package-total">Total: $10,400</div>
                            <span class="checkmark">&#10003;</span>
                        </div>
                        <div class="package" data-amount="25000" data-bonus="1250">
                            <div class="package-amount">$25,000</div>
                            <div class="package-bonus">+ $1,250 Bonus</div>
                            <div class="package-total">Total: $26,250</div>
                            <span class="checkmark">&#10003;</span>
                        </div>
                        <div class="package" data-amount="50000" data-bonus="3000">
                            <div class="package-amount">$50,000</div>
                            <div class="package-bonus">+ $3,000 Bonus</div>
                            <div class="package-total">Total: $53,000</div>
                            <span class="checkmark">&#10003;</span>
                        </div>
                    </div>
                    <div class="custom-section">
                        <div class="custom-label">Custom Amount</div>
                        <label for="customAmount" style="color: #1a4d2e; font-size: 1rem;">Enter Custom Amount ($)</label>
                        <input type="number" id="customAmount" class="custom-input" placeholder="Enter amount..." min="100">
                        <div class="custom-note">Minimum recharge amount is $100</div>
            <div id="paymentSection" style="display:none; margin-top:32px;">
                <div style="font-size:1.2rem; color:#1a4d2e; margin-bottom:16px; text-align:center;">Recharge Amount: <span id="rechargeAmount">$0</span></div>
                <button id="proceedBtn" style="display:block; margin:0 auto; background:#219a43; color:#fff; border:none; border-radius:6px; padding:12px 32px; font-size:1.1rem; font-weight:600; cursor:pointer;">Proceed to Payment</button>
<script>
    // ...existing code...
    document.getElementById('proceedBtn').onclick = function() {
        window.location.href = 'rechargesubmit(user).php';
    };
</script>
            </div>
<script>
    // Package selection logic
    const packages = document.querySelectorAll('.package');
    const customInput = document.getElementById('customAmount');
    const paymentSection = document.getElementById('paymentSection');
    const rechargeAmount = document.getElementById('rechargeAmount');
    let selectedAmount = 0;
    let selectedPackage = null;

    packages.forEach(pkg => {
        pkg.addEventListener('click', function() {
            packages.forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            selectedPackage = this;
            // Calculate total with bonus if present
            let amount = parseInt(this.getAttribute('data-amount'));
            let bonus = parseInt(this.getAttribute('data-bonus')) || 0;
            selectedAmount = amount + bonus;
            rechargeAmount.textContent = `$${selectedAmount.toLocaleString()}`;
            paymentSection.style.display = 'block';
            customInput.value = '';
        });
    });

    customInput.addEventListener('input', function() {
        packages.forEach(p => p.classList.remove('selected'));
        let val = parseInt(this.value);
        if (val && val >= 100) {
            selectedAmount = val;
            rechargeAmount.textContent = `$${selectedAmount.toLocaleString()}`;
            paymentSection.style.display = 'block';
        } else {
            paymentSection.style.display = 'none';
        }
    });
</script>
                    </div>
                </div>
            	</div>
            </div>
        </main>
<?php include 'footer.php'; ?>
