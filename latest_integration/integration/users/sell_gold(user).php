<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Gold | Gold Vault</title>
    <link rel="stylesheet" href="../css/user.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        :root {
            --gold: #d4af37;
            --gold-light: #f4e4a6;
            --gold-dark: #b8941f;
            --white: #ffffff;
            --green: #10b981;
            --green-light: #d1fae5;
            --gray-light: #f8fafc;
            --gray: #64748b;
            --gray-dark: #334155;
            --red: #ef4444;
            --red-light: #fef2f2;
            --yellow: #f59e0b;
            --yellow-light: #fefce8;
            --border: #e2e8f0;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--gray-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .page-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-title h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .page-title p {
            font-size: 1.2rem;
            color: var(--gray);
        }

        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
        }

        .card-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-content {
            padding: 1.5rem;
        }

        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-cols-1 {
            grid-template-columns: 1fr;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .grid-cols-5 {
            grid-template-columns: repeat(5, 1fr);
        }

        @media (max-width: 768px) {
            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .grid-cols-4 {
                grid-template-columns: 1fr;
            }
        }

        .info-card {
            background: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid var(--border);
            text-align: center;
            transition: all 0.2s ease;
        }

        .info-card:hover {
            box-shadow: var(--shadow-medium);
        }

        .info-card .value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .info-card .value.gold {
            color: var(--gold);
        }

        .info-card .value.green {
            color: var(--green);
        }

        .info-card .label {
            font-size: 0.875rem;
            color: var(--gray);
            margin-bottom: 0.75rem;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge.success {
            background-color: var(--green-light);
            color: var(--green);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .text-4xl {
            font-size: 2.25rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-muted {
            color: var(--gray);
        }

        .text-success {
            color: var(--green);
        }

        .text-gold {
            color: var(--gold);
        }

        .text-red {
            color: var(--red);
        }

        .text-yellow {
            color: var(--yellow);
        }

        .bg-gold-light {
            background-color: rgba(212, 175, 55, 0.1);
        }

        .bg-success-light {
            background-color: var(--green-light);
        }

        .bg-red-light {
            background-color: var(--red-light);
        }

        .bg-yellow-light {
            background-color: var(--yellow-light);
        }

        .border {
            border: 1px solid var(--border);
        }

        .border-b {
            border-bottom: 1px solid var(--border);
        }

        .rounded {
            border-radius: 0.5rem;
        }

        .rounded-lg {
            border-radius: 0.75rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            font-size: 0.875rem;
            gap: 0.5rem;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
        }

        .btn-primary:hover:not(:disabled) {
            opacity: 0.9;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--gray-dark);
        }

        .btn-outline:hover:not(:disabled) {
            background-color: rgba(212, 175, 55, 0.05);
            border-color: var(--gold);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .w-full {
            width: 100%;
        }

        .input-group {
            display: flex;
            gap: 0.5rem;
        }

        .input {
            flex: 1;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
        }

        .input:focus {
            outline: none;
            border-color: var(--gold);
        }

        .label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .slider-container {
            padding: 0 0.5rem;
        }

        .slider {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: #e2e8f0;
            outline: none;
            -webkit-appearance: none;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--gold);
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--gold);
            cursor: pointer;
            border: none;
        }

        .receipt {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .receipt-line {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border);
        }

        .receipt-total {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem;
            background-color: rgba(16, 185, 129, 0.05);
            border-radius: 0.5rem;
            margin-top: 0.75rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            border: 1px solid;
        }

        .alert-error {
            background-color: var(--red-light);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .alert-warning {
            background-color: var(--yellow-light);
            border-color: rgba(245, 158, 11, 0.2);
        }

        .alert-content {
            display: flex;
            gap: 0.5rem;
        }

        .alert-icon {
            flex-shrink: 0;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .alert-description {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: rgba(212, 175, 55, 0.1);
        }

        .icon-small {
            width: 0.75rem;
            height: 0.75rem;
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

<body>
    <div class="container">
        <div class="page-title">
            <h1>Sell Your Gold</h1>
            <p>Convert your gold holdings to cash instantly</p>
        </div>

        <!-- Enhanced Current Gold Price & Balances -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="icon-circle">
                        <i class="fas fa-arrow-trend-down" style="color: var(--gold);"></i>
                    </div>
                    Live Gold Market & Wallets
                </div>
            </div>
            <div class="card-content">
                <div class="grid grid-cols-4">
                    <div class="info-card">
                        <div class="value gold" id="gold-price"></div>
                        <div class="label" id="gold_price_mmk"></div>
                    </div>
                    <div class="info-card">
                        <div class="value gold" id="gold-balance"></div>
                        <div class="label">Gold Wallet(kt)</div>
                        <div class="flex items-center justify-center gap-2 text-sm text-gold">
                            <i class="fas fa-coins icon-small"></i>
                            <span>Available balance</span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="value green" id="dollar-balance"></div>
                        <div class="label">Coin Wallet</div>
                        <div class="flex items-center justify-center gap-2 text-sm text-success">
                            <i class="fas fa-wallet icon-small"></i>
                            <span>Available balance</span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="value" id="daily-limit"></div>
                        <div class="label">Daily Limit Remaining</div>
                        <div class="flex items-center justify-center gap-2 text-sm text-muted">
                            <i class="fas fa-info-circle icon-small"></i>
                            <span>10 kt/day max</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sale Calculator -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-calculator" style="color: var(--gold);"></i>
                    Gold Sale Calculator
                </div>
            </div>
            <div class="card-content space-y-6">
                <!-- Quick Amount Buttons -->
                <div>
                    <div class="label">Quick Select</div>
                    <div class="grid grid-cols-5 gap-2">
                        <button class="btn btn-outline btn-sm quick-amount" data-amount="0.1">0.1 kt</button>
                        <button class="btn btn-outline btn-sm quick-amount" data-amount="0.5">0.5 kt</button>
                        <button class="btn btn-outline btn-sm quick-amount" data-amount="1">1 kt</button>
                        <button class="btn btn-outline btn-sm quick-amount" data-amount="2">2 kt</button>
                        <button class="btn btn-outline btn-sm quick-amount" data-amount="5">5 kt</button>
                    </div>
                </div>

                <!-- Amount Input -->
                <div class="space-y-4">
                    <div>
                        <label for="gold-amount" class="label">Gold Amount to Sell (Troy Ounces)</label>
                        <div class="input-group">
                            <input type="number" id="gold-amount" class="input" step="0.01" min="0" value="0.1">
                            <button class="btn btn-outline" id="max-btn">Max</button>
                        </div>
                    </div>

                    <!-- Slider -->
                    <div class="slider-container">
                        <input type="range" id="gold-slider" class="slider" min="0"  step="0.01" value="0.1">
                        <div class="flex justify-between text-sm text-muted mt-1">
                            <span>0 kt</span>
                            <span id="max-display">5.75 oz</span>
                        </div>
                    </div>
                </div>

                <!-- Receipt Breakdown -->
                <div class="receipt p-6">
                    <div class="receipt-header">
                        <h3 class="text-lg font-semibold text-gold mb-1">Sale Receipt</h3>
                        <p class="text-sm text-muted">Transaction Summary</p>
                    </div>
                    <div class="receipt-line">
                        <span class="text-muted">Gold Amount:</span>
                        <span class="font-medium text-gold" id="receipt-gold-amount">0.100 oz</span>
                    </div>
                    <div class="receipt-line">
                        <span class="text-muted">Price per Ounce:</span>
                        <span class="font-medium" id="receipt-price">$2,645.30</span>
                    </div>
                    <div class="receipt-total">
                        <span class="text-lg font-semibold">Total Receive:</span>
                        <span class="text-xl font-bold text-success" id="receipt-total">$264.53</span>
                    </div>
                    <div class="receipt-line mt-2">
                        <span class="text-sm text-muted">New Coin Balance:</span>
                        <span class="text-sm font-medium text-success" id="receipt-new-balance">$15,264.53</span>
                    </div>
                    <div class="receipt-line">
                        <span class="text-sm text-muted">Remaining Gold:</span>
                        <span class="text-sm font-medium text-gold" id="receipt-remaining-gold">5.650 oz</span>
                    </div>
                </div>

                <!-- Sell Button -->
                <button id="sell-btn" class="btn btn-primary btn-lg w-full">
                    <i class="fas fa-arrow-trend-down"></i>
                    <span id="sell-btn-text">Sell 0.100 oz Gold</span>
                </button>
            </div>
        </div>

        <!-- Market Info -->
        <!-- <div class="card">
            <div class="card-header">
                <div class="card-title">Selling Information</div>
            </div>
            <div class="card-content">
                <div class="grid grid-cols-2">
                    <div class="space-y-3">
                        <h3 class="font-semibold">Today's Market Performance</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>24h Change:</span>
                                <span class="text-success">+$62.50 (+2.4%)</span>
                            </div>
                            <div class="flex justify-between">
                                <span>24h High:</span>
                                <span>$2,660.30</span>
                            </div>
                            <div class="flex justify-between">
                                <span>24h Low:</span>
                                <span>$2,620.30</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-semibold">Selling Tips</h3>
                        <ul class="text-sm text-muted space-y-1">
                            <li>• Daily limit: 10 oz per 24 hours</li>
                            <li>• Requests are processed within 24-48 hours</li>
                            <li>• Monitor market trends for best timing</li>
                            <li>• Consider keeping emergency reserves</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <script>
        // Initial state
        let goldAmount = 0.1;
        var userGoldBalance = 0;
        var userDollarBalance = 0;
        var goldPrice = 0;
        const dailyLimit = 10;
        var base_sell_price =0;
        var dailySold = 0;
        var remainingDailyLimit = dailyLimit - dailySold;
        var maxSellableGold = 0;
		function refreshAllData() {
        	var xhttp = new XMLHttpRequest();
        	xhttp.onreadystatechange = function() {
            	if (this.readyState == 4 && this.status == 200) {
                	// Parse the JSON response text into a JavaScript object
                	var data = JSON.parse(this.responseText);
					// Now you can access each data point by its key
                    // goldPrice = parseFloat(data.gold_price);
                    // document.getElementById("gold-price").innerHTML= "$"+ Number(data.gold_price).toLocaleString();
                    // userGoldBalance = parseFloat(data.gold_balance);
                    // document.getElementById("gold-balance").innerHTML= Number(data.gold_balance).toLocaleString()+ " oz";
                    // userDollarBalance = parseFloat(data.dollar_balance);
                    // document.getElementById("dollar-balance").innerHTML = "$ "+Number(data.dollar_balance).toLocaleString();
                    // dailySold = data.sell_gold_amount;
                    // remainingDailyLimit = dailyLimit - dailySold;
                    // maxSellableGold = Math.min(userGoldBalance, remainingDailyLimit);
                    // document.getElementById("daily-limit").innerHTML = (remainingDailyLimit).toLocaleString() + " oz";
                    // document.getElementById("gold-balance-dollar").innerHTML = "≈ "+"$ "+ Number(data.gold_balance*data.gold_price).toLocaleString();
					// initialize();
                    base_sell_price = parseFloat(data.base_buy_price/1000);
                    goldPrice = base_sell_price-(base_sell_price*0.01);
                    document.getElementById("gold-price").innerHTML=  (Number(goldPrice)).toLocaleString()+ " coin/kt";
                    document.getElementById("gold_price_mmk").innerHTML=  (Number(goldPrice)*1000).toLocaleString()+ " MMK(1%tax included)";

                    userGoldBalance = parseFloat(data.available_gold_balance);
                    document.getElementById("gold-balance").innerHTML= Number(data.available_gold_balance || 0).toLocaleString();
                    userDollarBalance = parseFloat(data.available_coin_balance);
                    document.getElementById("dollar-balance").innerHTML = Number(data.available_coin_balance||0).toLocaleString();
                    dailySold = data.sell_gold_amount;
                    remainingDailyLimit = dailyLimit - dailySold;
                    maxSellableGold = Math.min(userGoldBalance, remainingDailyLimit);
                    document.getElementById("daily-limit").innerHTML = (remainingDailyLimit).toLocaleString() + " kt";
                    // document.getElementById("gold-balance-dollar").innerHTML = "≈ "+"$ "+ Number(data.gold_balance*data.gold_price).toLocaleString();
					initialize();
				}   
			};
			xhttp.open("GET", "sell_gold_user_db_sql.php", true);
        	xhttp.send();  
		}
		refreshAllData();
		setInterval(() => {
			refreshAllData();
		}, 5000);

		
	</script>

    <script>
        

        // DOM elements
        const goldAmountInput = document.getElementById('gold-amount');
        const goldSlider = document.getElementById('gold-slider');
        const maxBtn = document.getElementById('max-btn');
        const quickAmountBtns = document.querySelectorAll('.quick-amount');
        const sellBtn = document.getElementById('sell-btn');
        const sellBtnText = document.getElementById('sell-btn-text');
        const insufficientGoldAlert = document.getElementById('insufficient-gold-alert');
        const limitExceededAlert = document.getElementById('limit-exceeded-alert');
        const maxDisplaySpan = document.getElementById('max-display');

        // Receipt elements
        const receiptGoldAmount = document.getElementById('receipt-gold-amount');
        const receiptPrice = document.getElementById('receipt-price');
        const receiptTotal = document.getElementById('receipt-total');
        const receiptNewBalance = document.getElementById('receipt-new-balance');
        const receiptRemainingGold = document.getElementById('receipt-remaining-gold');

        // Initialize
        function initialize() {
            updateReceipt();
            updateSellButton();
            goldSlider.max = maxSellableGold.toFixed(2);
            maxDisplaySpan.textContent = `${maxSellableGold.toFixed(2)} kt`;
        }

        // Update receipt calculations
        function updateReceipt() {
            const totalReceive = goldAmount * goldPrice;
            const newDollarBalance = userDollarBalance + totalReceive;
            const remainingGold = userGoldBalance - goldAmount;

            receiptGoldAmount.textContent = `${goldAmount.toFixed(3)} kt`;
            receiptPrice.textContent = `${goldPrice.toFixed(2)} coin`;
            receiptTotal.textContent = `${totalReceive.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })} coin`;
            receiptNewBalance.textContent = `${newDollarBalance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })} coin`;
            receiptRemainingGold.textContent = `${remainingGold.toFixed(3)} kt`;
        }

        

        // Update sell button state and text
        function updateSellButton() {
            // const canSell = goldAmount <= userGoldBalance && goldAmount <= remainingDailyLimit && goldAmount > 0;
            
            // sellBtn.disabled = !canSell;
            
            // if (canSell) {
            //     sellBtnText.textContent = `Sell ${goldAmount.toFixed(3)} oz Gold`;
            // } else if (goldAmount > userGoldBalance) {
            //     sellBtnText.textContent = "Insufficient Gold";
            // } else if (goldAmount > remainingDailyLimit) {
            //     sellBtnText.textContent = "Daily Limit Exceeded";
            // } else {
            //     sellBtnText.textContent = "Invalid Amount";
            // }
            if(goldAmount==0.1 && maxSellableGold == 0){
                sellBtn.textContent = "insufficient gold";
                sellBtn.disabled = true;
            }else if(maxSellableGold == 0){
                sellBtn.textContent = "daily limit exceeded!";
                sellBtn.disabled = true;
            }else{
                sellBtn.textContent = `Sell ${goldAmount.toFixed(2)} kt Gold`;
            }
            
           
        }

        // Handle input change
        function handleGoldAmountChange(value) {
            const amount = parseFloat(value);
            if (!isNaN(amount) && amount >= 0) {
                goldAmount = Math.min(amount, maxSellableGold);
                goldAmountInput.value = goldAmount;
                goldSlider.value = goldAmount;
                updateReceipt();
                updateSellButton();
            }
        }

        // Set max amount
        function setMaxAmount() {
            goldAmount = maxSellableGold;
            goldAmountInput.value = goldAmount;
            goldSlider.value = goldAmount;
            updateReceipt();
            updateSellButton();
        }

        // Handle sale
        function handleSale() {
            var userData = {
				amount : goldAmount,
				price :base_sell_price,
                type : "user_gold_sell"
                };

            fetch('sell_gold_user_db_sql.php', {
                method: 'POST',
                headers: {
                	'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData),
            })
			alert('sell gold request is successfully sent');
            goldAmount = 0.1;
            goldAmountInput.value = goldAmount;
            goldSlider.value = goldAmount;
            initialize();
            window.location.href="pending(user).php";
        }

        

        // Event listeners
        goldAmountInput.addEventListener('input', (e) => handleGoldAmountChange(e.target.value));
        goldSlider.addEventListener('input', (e) => handleGoldAmountChange(e.target.value));
        maxBtn.addEventListener('click', setMaxAmount);
        sellBtn.addEventListener('click', handleSale);

        quickAmountBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const amount = parseFloat(btn.getAttribute('data-amount'));
                if (amount <= maxSellableGold) {
                    handleGoldAmountChange(amount);
                }
            });
        });

        
    </script>
</body>
</html>