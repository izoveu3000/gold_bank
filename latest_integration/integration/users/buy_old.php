<head>
	<link rel="stylesheet" href="../css/user.css">
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
</head>
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
		<main class="container-fluid" style="background: #f8fcf9; min-height: 100vh; padding: 0;">
			
			<div class="buygold-main" style="margin-top:-48px;">
				<div class="buygold-title">Buy Premium Gold</div>
				<div class="buygold-subtitle">Purchase gold with your available coins</div>
				<div class="buygold-card">
					<div class="buygold-market">
						<div class="buygold-market-title"><span style="color:#ffd700;font-size:1.3rem;">&#x1F4B0;</span> Live Gold Market</div>
						<div class="buygold-market-price" id="goldPrice">$2645.30</div>
						<div class="buygold-market-label">Per Troy Ounce (USD)</div>
						<div class="buygold-market-change">+2.4% Today</div>
					</div>
					<div class="buygold-market">
						<div class="buygold-market-balance" id="balance">$15,000</div>
						<div class="buygold-market-status">Ready to invest</div>
					</div>
					<div class="buygold-market">
						<div class="buygold-market-affordable" id="maxAffordable">5.67 oz</div>
						<div class="buygold-market-capacity">Gold capacity</div>
					</div>
				</div>
				<div class="buygold-section">
					<div class="buygold-section-title"><span style="color:#219a43;font-size:1.3rem;">&#128179;</span> Gold Purchase Calculator</div>
					<div class="buygold-quick">
						<div class="buygold-quick-btn" data-oz="0.1">0.1 oz</div>
						<div class="buygold-quick-btn" data-oz="0.5">0.5 oz</div>
						<div class="buygold-quick-btn active" data-oz="1">1 oz</div>
						<div class="buygold-quick-btn" data-oz="2">2 oz</div>
						<div class="buygold-quick-btn" data-oz="5">5 oz</div>
						<div class="buygold-quick-btn" data-oz="10">10 oz</div>
					</div>
					<div class="buygold-slider-label">Gold Amount (Troy Ounces)</div>
					<div class="buygold-slider-row">
						<input type="number" id="goldAmountInput" value="1" min="0.1" max="5.67" step="0.01" style="width:120px;padding:8px;border-radius:8px;border:1px solid #e6f4ea;font-size:1.1rem;">
						<button id="maxBtn" style="background:#fff;color:#219a43;border:1px solid #e6f4ea;border-radius:8px;padding:8px 18px;font-size:1rem;font-weight:500;cursor:pointer;margin-left:8px;">Max</button>
					</div>
					<input type="range" id="goldAmountSlider" min="0.1" max="5.67" step="0.01" value="1" class="buygold-slider">
					<div class="buygold-slider-minmax" style="display:flex;justify-content:space-between;margin-top:2px;">
						<span>0 oz</span>
						<span>5.67 oz</span>
					</div>
					<div class="buygold-summary">
						<div class="buygold-summary-row"><span>Gold Amount:</span><span id="summaryGoldAmount">1.000 oz</span></div>
						<div class="buygold-summary-row"><span>Price per Ounce:</span><span id="summaryGoldPrice">$2645.30</span></div>
						<div class="buygold-summary-row" style="font-weight:700;font-size:1.2rem;"><span>Total Cost:</span><span class="buygold-summary-cost" id="summaryTotalCost">$2,645.3</span></div>
						<div class="buygold-summary-row buygold-summary-balance"><span>Remaining Balance:</span><span id="summaryBalance">$12,354.7</span></div>
					</div>
					<button class="buygold-purchase-btn" id="purchaseBtn"><span style="color:#a67c00;font-size:1.3rem;">&#128176;</span> Purchase 1.000 oz Gold</button>
				</div>
				<div class="buygold-marketinfo">
					<div class="buygold-marketinfo-title">Market Information</div>
					<div class="buygold-marketinfo-row">
						<div class="buygold-marketinfo-performance">
							<div style="font-weight:600;color:#219a43;margin-bottom:8px;">Today's Performance</div>
							<div>24h Change: <span style="color:#43e97b;font-weight:600;">+ $62.50 (+2.4%)</span></div>
							<div>24h High: <span style="color:#219a43;">$2660.30</span></div>
							<div>24h Low: <span style="color:#f44336;">$2620.30</span></div>
						</div>
						<div class="buygold-marketinfo-tips">
							<div style="font-weight:600;color:#219a43;margin-bottom:8px;">Investment Tips</div>
							<ul>
								<li>Gold is a hedge against inflation</li>
								<li>Consider dollar-cost averaging</li>
								<li>Monitor market trends regularly</li>
								<li>Diversify your investment portfolio</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<script>
				// Gold purchase calculator logic
				const goldPrice = 2645.30;
				let balance = 15000;
				let maxAffordable = 5.67;
				let goldAmount = 1;
				const quickBtns = document.querySelectorAll('.buygold-quick-btn');
				const goldAmountInput = document.getElementById('goldAmountInput');
				const goldAmountSlider = document.getElementById('goldAmountSlider');
				const maxBtn = document.getElementById('maxBtn');
				const summaryGoldAmount = document.getElementById('summaryGoldAmount');
				const summaryGoldPrice = document.getElementById('summaryGoldPrice');
				const summaryTotalCost = document.getElementById('summaryTotalCost');
				const summaryBalance = document.getElementById('summaryBalance');
				const purchaseBtn = document.getElementById('purchaseBtn');

				function updateSummary() {
					let cost = goldAmount * goldPrice;
					let remaining = balance - cost;
					summaryGoldAmount.textContent = goldAmount.toFixed(3) + ' oz';
					summaryGoldPrice.textContent = '$' + goldPrice.toFixed(2);
					summaryTotalCost.textContent = '$' + cost.toLocaleString(undefined, {minimumFractionDigits:1, maximumFractionDigits:1});
					summaryBalance.textContent = '$' + remaining.toLocaleString(undefined, {minimumFractionDigits:1, maximumFractionDigits:1});
					purchaseBtn.innerHTML = `<span style='color:#a67c00;font-size:1.3rem;'>&#128176;</span> Purchase ${goldAmount.toFixed(3)} oz Gold`;
				}

				quickBtns.forEach(btn => {
					btn.addEventListener('click', function() {
						quickBtns.forEach(b => b.classList.remove('active'));
						this.classList.add('active');
						goldAmount = parseFloat(this.getAttribute('data-oz'));
						goldAmountInput.value = goldAmount;
						goldAmountSlider.value = goldAmount;
						updateSummary();
					});
				});

				goldAmountInput.addEventListener('input', function() {
					let val = parseFloat(this.value);
					if (!isNaN(val) && val >= 0.1 && val <= maxAffordable) {
						goldAmount = val;
						goldAmountSlider.value = val;
						quickBtns.forEach(b => b.classList.remove('active'));
						updateSummary();
					}
				});

				goldAmountSlider.addEventListener('input', function() {
					let val = parseFloat(this.value);
					if (!isNaN(val) && val >= 0.1 && val <= maxAffordable) {
						goldAmount = val;
						goldAmountInput.value = val;
						quickBtns.forEach(b => b.classList.remove('active'));
						updateSummary();
					}
				});

				maxBtn.addEventListener('click', function() {
					goldAmount = maxAffordable;
					goldAmountInput.value = goldAmount;
					goldAmountSlider.value = goldAmount;
					quickBtns.forEach(b => b.classList.remove('active'));
					updateSummary();
				});

				updateSummary();
			</script>
		</main>
	</div>
</div>

<?php include 'footer.php'; ?>
