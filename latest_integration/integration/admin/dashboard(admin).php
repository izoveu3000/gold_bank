<?php

session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}

// allow header to include a page-specific stylesheet
$extra_css = '../assets/css/dashboard(admin).css';
include('header.php');

?>
  <style>
    /* Page-specific full-width overrides */
    html, body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      overflow-x: hidden;
      background: #f8faf9;
    }
    /* force dashboard area to use full viewport width */
    .dashboard {
      width: 100vw !important;
      max-width: 100vw !important;
      margin: 0 !important;
      padding: 18px 10px !important;
      box-sizing: border-box;
    }
    /* reduce container padding (header or bootstrap containers) on this page */
    .container, .container-fluid, .header-content.container-fluid {
      max-width: 100% !important;
      padding-left: 10px !important;
      padding-right: 10px !important;
    }
    /* ensure any sidebar or fixed elements don't add unwanted horizontal space */
    body.sidebar-open .dashboard, .sidebar { transform: none; }
  </style>

  <!-- Load Tailwind (used by the sidebar/nav markup) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Sidebar slide/transform rules (desktop + mobile) */
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
			sidebar && sidebar.classList.add("open");
			sidebar && sidebar.classList.remove("closed");
			dashboardFlex && dashboardFlex.classList.remove("sidebar-closed");
			if (content) content.style.marginLeft = window.innerWidth >= 992 ? '240px' : '70px';
			if (header) header.classList.add("header-shifted");
		}

		function closeSidebar() {
			sidebar && sidebar.classList.add("closed");
			sidebar && sidebar.classList.remove("open");
			dashboardFlex && dashboardFlex.classList.add("sidebar-closed");
			if (content) { content.style.marginLeft = '0'; content.style.width = '100vw'; }
			if (header) header.classList.remove("header-shifted");
		}

		if (toggleBtn) {
			toggleBtn.onclick = function(e) {
				e.stopPropagation();
				if (sidebar && sidebar.classList.contains("open")) {
					closeSidebar();
				} else {
					openSidebar();
				}
			};
		}

		function handleResize() {
			if (window.innerWidth < 992) {
				toggleBtn && (toggleBtn.style.display = 'inline-flex');
				closeSidebar();
			} else {
				toggleBtn && (toggleBtn.style.display = 'none');
				openSidebar();
			}
		}

		window.addEventListener('resize', handleResize);
		handleResize();

		feather && feather.replace && feather.replace();
	});

	</script>
 
    <!-- Header -->
    <header class="header">
      <h1>Admin Dashboard</h1>
      <p>Manage your gold banking operations</p>
    </header>

    <!-- Top Stats -->
    <section class="stats-grid">
      <div class="stat-card">
        <p>Pending Deposits</p>
        <h2 id="deposit_total"></h2>
        <span id="deposit_amount"></span>
      </div>
      <div class="stat-card">
        <p>Pending Withdrawals</p>
        <h2 id="withdraw_total"></h2>
        <span id="withdraw_amount"></span>
      </div>
      <div class="stat-card">
        <p>Pending Gold Purchase</p>
        <h2 id="buy_gold_total"></h2>
        <span id="buy_gold_amount"></span>
      </div>
      <div class="stat-card">
        <p>Pending Gold Sell</p>
        <h2 id="sell_gold_total"></h2>
        <span id="sell_gold_amount"></span>
      </div>
    </section>

    <!-- Wallet -->
    <section class="wallet">
      <h2 class="section-title">Platform Information</h2>
      <div class="wallet-grid">
        <div class="wallet-card">
          <p>Gold Transaction Profit</p>
          <h2 class="usd gradient-green" id="gold_transaction_fee"></h2>
          <span id="gold_transaction_fee_mmk"></span>
          
          
        </div>
        <div class="wallet-card">
          <p>User Coin Balance</p>
          <h2 class="mmk gradient-blue" id="actual_coin_balance"></h2>
          <span id="actual_coin_balance_mmk"></span>
        </div>
        <div class="wallet-card">
          <p>User Gold Balance</p>
          <h2 class="gold gradient-gold" id="actual_gold_balance"></h2>
          
          
          
        </div>
        
      </div>
    </section>

    <!-- Bottom Section -->
    <section class="bottom-grid">
      
      

      
  <!-- gold transaction profit -->
      <div class="quick-actions">
  <h2 style="text-align:center;" id="dollar_total"></h2>
  
  <div style="text-align:center;">
    <label for="yearSelect_gold">Select Year: </label>
    <select id="yearSelect_gold">
      <option value="2024">2024</option>
      <option value="2025" selected>2025</option>
      <option value="2026">2026</option>
    </select>
  </div>
  

  <canvas id="myBarChart_gold" width="400" height="200"></canvas>
</div>

<div class="quick-actions flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100"
     style="min-height: 300px; text-align: center;">
  <h2 class="text-xl font-semibold mb-4 text-yellow-600">💰 Gold Price Info</h2>

  <div class="space-y-3 mb-6">
    <p class="text-lg text-gray-800">
      <strong>Buy Gold Price:</strong>
      <span id="buyGoldPrice" class="text-gray-600 ml-1">-</span> <span class="text-sm text-gray-500">MMK</span>
    </p>
    <p class="text-lg text-gray-800">
      <strong>Sell Gold Price:</strong>
      <span id="sellGoldPrice" class="text-gray-600 ml-1">-</span> <span class="text-sm text-gray-500">MMK</span>
    </p>
  </div>

  <button id="updatePriceBtn"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition duration-200">
    Update Price
  </button>
</div>


    </section>
    <!-- Gold Price Update Modal -->
<div id="goldPriceModal" 
     style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.6);align-items:center;justify-content:center;z-index:2000;">
  <div style="background:white;padding:20px;border-radius:12px;width:90%;max-width:400px;text-align:center;box-shadow:0 4px 15px rgba(0,0,0,0.3);">
    <h3 style="margin-bottom:15px;">Update Gold Prices</h3>

    <div style="margin-bottom:12px;text-align:left;">
      <label for="buyPriceInput" style="font-weight:bold;">Buy Gold Price (MMK):</label>
      <input type="number" id="buyPriceInput" 
             style="width:100%;padding:8px;margin-top:5px;border:1px solid #ccc;border-radius:6px;">
    </div>

    <div style="margin-bottom:12px;text-align:left;">
      <label for="sellPriceInput" style="font-weight:bold;">Sell Gold Price (MMK):</label>
      <input type="number" id="sellPriceInput" 
             style="width:100%;padding:8px;margin-top:5px;border:1px solid #ccc;border-radius:6px;">
    </div>

    <div style="margin-top:20px;display:flex;justify-content:space-between;">
      <button id="cancelPriceBtn" 
              style="background:#6c757d;color:white;border:none;padding:8px 14px;border-radius:6px;cursor:pointer;">
        Cancel
      </button>
      <button id="savePriceBtn" 
              style="background:#198754;color:white;border:none;padding:8px 14px;border-radius:6px;cursor:pointer;">
        Save
      </button>
    </div>
  </div>
</div>

    
    
    <section class="bottom-grid">
      <div class="quick-actions">
        <div style="text-align: center; color:blue;">
    <label for="month">Select Month:</label>
    <input type="month" id="month3" value="<?php echo date('Y-m'); ?>">
  </div>
        <canvas id="priceChart3"></canvas>
      </div>
    </section>
    
    

    </section>

	</div> <!-- end #content -->
</div> <!-- end .dashboard-flex -->
</body>
<!-- <script>
  // MMK modal action
  (function(){
    var openBtn = document.getElementById('open-mmk-modal');
    var overlay = document.getElementById('mmk-modal');
  var cancelBtn = document.getElementById('mmk-cancel');
    var submitBtn = document.getElementById('mmk-submit');
    var amountInput = document.getElementById('mmk-amount');
    var errorEl = document.getElementById('mmk-error');
  var closeBtn = document.getElementById('mmk-close');

    function showModal(){
      overlay.classList.add('active');
      overlay.setAttribute('aria-hidden','false');
      amountInput.value = '';
      errorEl.style.display = 'none';
      // delay focus slightly to allow modal animation
      setTimeout(function(){ amountInput.focus(); amountInput.select && amountInput.select(); }, 200);
    }

    function hideModal(){
      overlay.classList.remove('active');
      overlay.setAttribute('aria-hidden','true');
    }

    function parseAmount(v){
      if(!v) return NaN;
      // remove commas and spaces
      v = v.replace(/[,\s]/g,'');
      return Number(v);
    }

    openBtn && openBtn.addEventListener('click', function(e){ e.preventDefault(); showModal(); });
  cancelBtn && cancelBtn.addEventListener('click', function(e){ e.preventDefault(); hideModal(); });
  closeBtn && closeBtn.addEventListener('click', function(e){ e.preventDefault(); hideModal(); });

    overlay && overlay.addEventListener('click', function(e){ if(e.target === overlay) hideModal(); });

    submitBtn && submitBtn.addEventListener('click', function(e){
      e.preventDefault();
      var amt = parseAmount(amountInput.value);
      if(!isFinite(amt) || amt <= 0){
        errorEl.style.display = 'block';
        return;
      }
      var userData = {
          refill_mmk : amt
        };

        fetch('dashboard_admin_data.php', {
          method: 'POST',
          headers: {
          'Content-Type': 'application/json',
          },
          body: JSON.stringify(userData),
        })
      //amt is the variable of the request amount
     

    

      console.log('Refill MMK requested:', amt);
      // Optionally show a tiny success state before closing
      submitBtn.textContent = 'Processing...';
      submitBtn.disabled = true;
      setTimeout(function(){
        submitBtn.disabled = false;
        submitBtn.textContent = 'Refill';
        hideModal();
      }, 700);
    });

    // simple Enter key submit
    amountInput && amountInput.addEventListener('keydown', function(e){ if(e.key === 'Enter'){ submitBtn.click(); } });
  })();
</script> -->
<script>
    function refreshAllData() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Parse the JSON response text into a JavaScript object
                var data = JSON.parse(this.responseText);
                
                document.getElementById('deposit_total').innerHTML= data.deposit_total;
                document.getElementById('withdraw_total').innerHTML=data.withdraw_total;
                document.getElementById('buy_gold_total').innerHTML=data.buy_gold_total;
                document.getElementById('sell_gold_total').innerHTML=data.sell_gold_total;

                document.getElementById('deposit_amount').innerHTML="Total "+Number(data.deposit_amount*1000).toLocaleString()+" MMK";
                document.getElementById('withdraw_amount').innerHTML="Total "+Number(data.withdraw_amount*1000).toLocaleString()+" MMK";
                document.getElementById('buy_gold_amount').innerHTML="Total "+data.buy_gold_amount + " kyatar";
                document.getElementById('sell_gold_amount').innerHTML="Total "+data.sell_gold_amount+ " kyatar";

                document.getElementById('gold_transaction_fee').innerHTML=Number(data.gold_transaction_fee).toLocaleString()+ " Coins" ;
                document.getElementById('actual_coin_balance').innerHTML =Number(data.actual_coin_balance).toLocaleString()+" Coins" ;
                document.getElementById('actual_gold_balance').innerHTML=data.actual_gold_balance + " kyatar";

                document.getElementById('gold_transaction_fee_mmk').innerHTML=Number(data.gold_transaction_fee * 1000).toLocaleString()+ " MMK" ;
                document.getElementById('actual_coin_balance_mmk').innerHTML =Number(data.actual_coin_balance*1000).toLocaleString()+" MMK" ;
                document.getElementById('buyGoldPrice').innerText= Number(data.base_buy_price).toLocaleString();
                document.getElementById('sellGoldPrice').innerText= Number(data.base_sell_price).toLocaleString();
                loadMMKChartData(document.getElementById('month3').value);

                
                
            }
        };
        xhttp.open("GET", "get_dashboard_data.php", true);
        xhttp.send();
    }

    // Call the function to refresh all data every 5 seconds
    setInterval(refreshAllData, 5000);
    refreshAllData();

    function fetchprice() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Parse the JSON response text into a JavaScript object
                var data = JSON.parse(this.responseText);
                
                document.getElementById('buyGoldPrice').innerText= Number(data.base_buy_price).toLocaleString();
                document.getElementById('sellGoldPrice').innerText= Number(data.base_sell_price).toLocaleString();

                
                
            }
        };
        xhttp.open("GET", "get_dashboard_data.php", true);
        xhttp.send();
    }
    fetchprice();
    
</script>

<script>
let myChart_gold;

function loadChart_gold(year) {
  fetch('get_chart_data.php?year=' + year)
    .then(response => response.json())
    .then(data => {
      const ctx = document.getElementById('myBarChart_gold').getContext('2d');
      document.getElementById('dollar_total').innerHTML= "Gold Transaction's Profit - "+ Number(data.total_transaction_fee).toLocaleString() + "(MMK)";
      if (myChart_gold) myChart_gold.destroy(); // Destroy previous chart before re-creating
      
      myChart_gold = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.months,
          datasets: [
            {
              label: 'Transactions Profit (MMK)',
              data: data.gold_transaction_fee,
              backgroundColor: 'rgba(255, 215, 0, 0.7)',
              borderColor: 'gold',
              borderWidth: 1
            },
            
          ]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    });
}

// Initial load
loadChart_gold(2025);

// When user selects another year
document.getElementById('yearSelect_gold').addEventListener('change', function() {
  loadChart_gold(this.value);
});
</script>

 
  
  
  <script>
    let mmkChart; // Unique chart variable

    async function loadMMKChartData(month) { // Unique function name
        try {
            // Assuming chart_data.php also returns monthly MMK balance data (e.g., in a key called 'mmk_balance')
            const response = await fetch(`chart_data.php?month=${month}`);
            const data3 = await response.json(); // Unique data variable

            if (!data3 || data3.days.length === 0) {
                alert(`No data found for ${month}!`);
                document.getElementById("month3").value= "<?php echo date('Y-m'); ?>";
                return;
                
            }

            if (mmkChart) mmkChart.destroy();

            // Target the new canvas ID: priceChart3
            const ctx3 = document.getElementById('priceChart3').getContext('2d'); 
            
            mmkChart = new Chart(ctx3, {
                type: 'line',
                data: {
                    // Use String(d) to ensure .padStart() works, and target month3's data
                    labels: data3.days.map(d => `${month.slice(-2)}/${String(d).padStart(2, '0')}`), 
                    datasets: [
                        {
            label: 'Buy Price(MMK)',
            data: data3.base_buy_price,
            borderColor: '#FFD700',
            backgroundColor: 'rgba(255,215,0,0.2)',
            borderWidth: 2,
            tension: 0.3,
            pointBackgroundColor: '#FFD700'
          },
          {
            label: 'Sell Price(MMK)',
            data: data3.base_sell_price,
            borderColor: '#B8860B',
            backgroundColor: 'rgba(184,134,11,0.2)',
            borderWidth: 2,
            tension: 0.3,
            borderDash: [5,5],
            pointBackgroundColor: '#B8860B'
          }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Gold Prices - ${month}`,
                            font: { size: 18 }
                        }
                    },
                    scales: {
              y: { beginAtZero: false, title: { display: true, text: 'Price' } },
              x: { title: { display: true, text: 'Date' } }
            }
                }
            });
        } catch (error) {
            console.error("Error loading MMK Balance chart data:", error);
        }
    }

    // Initial load: Target month3
    document.addEventListener("DOMContentLoaded", () => {
        const defaultMonth = document.getElementById('month3').value;
        loadMMKChartData(defaultMonth);
    });

    // On month change: Target month3
    document.getElementById('month3').addEventListener('change', e => {
        loadMMKChartData(e.target.value);
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('goldPriceModal');
    const updateBtn = document.getElementById('updatePriceBtn');
    const cancelBtn = document.getElementById('cancelPriceBtn');
    const saveBtn = document.getElementById('savePriceBtn');
    const buyInput = document.getElementById('buyPriceInput');
    const sellInput = document.getElementById('sellPriceInput');
    const buyText = document.getElementById('buyGoldPrice');
    const sellText = document.getElementById('sellGoldPrice');
    

    // Open Modal
    updateBtn.addEventListener('click', () => {
      modal.style.display = 'flex';
      buyInput.value = buyText.innerText !== '-' ? buyText.innerText.replace(/,/g, '') : '';
      sellInput.value = sellText.innerText !== '-' ? sellText.innerText.replace(/,/g, '') : '';
    });

    // Close Modal
    cancelBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    // Save Button Action
    saveBtn.addEventListener('click', () => {
      const buyPrice = parseFloat(buyInput.value);
      const sellPrice = parseFloat(sellInput.value);

      if (isNaN(buyPrice) || isNaN(sellPrice)) {
        alert("Please enter valid prices!");
        return;
      }

      // Update frontend values
      buyText.innerText = buyPrice.toLocaleString();
      sellText.innerText = sellPrice.toLocaleString();
      modal.style.display = 'none';

      
      
      fetch('dashboard_admin_data.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ buy_price: buyPrice, sell_price: sellPrice })
      })
      .then(res => res.json())
      .then(response => console.log(response))
      .catch(err => console.error(err));

    
      
    });

    // Close modal when clicking outside content
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.style.display = 'none';
    });
  });
</script>
<!-- Gold Price Update Modal -->
<div id="goldPriceModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
  <div class="bg-white rounded-2xl shadow-lg w-11/12 max-w-md p-6">
    <h3 class="text-xl font-semibold mb-5 text-gray-800 text-center">Update Gold Prices</h3>

    <div class="mb-4">
      <label for="buyPriceInput" class="block text-gray-700 font-medium mb-1">Buy Gold Price (MMK)</label>
      <input type="number" id="buyPriceInput"
             class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
    </div>

    <div class="mb-4">
      <label for="sellPriceInput" class="block text-gray-700 font-medium mb-1">Sell Gold Price (MMK)</label>
      <input type="number" id="sellPriceInput"
             class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
    </div>

    <div class="flex justify-between mt-6">
      <button id="cancelPriceBtn"
              class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded-lg transition duration-200">
        Cancel
      </button>
      <button id="savePriceBtn"
              class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition duration-200">
        Save
      </button>
    </div>
  </div>
</div>



  
  
<?php include('footer.php'); ?>
