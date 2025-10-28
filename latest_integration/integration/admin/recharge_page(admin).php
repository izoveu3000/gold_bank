<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
include('dashboard_admin_data.php');
$extra_css = '../assets/css/dashboard(admin).css';
include('header.php');


?>
<?php
if (isset($_GET['dollar'])) {
    // The URL had ?dollar
    $selected_tab = 'usd';
} else if (isset($_GET['gold'])) {
    // The URL had ?gold
    $selected_tab = 'gold';
} else {
    header("Location: dashboard(admin).php");
    exit;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Currency & Gold Purchase</title>
  <link rel="stylesheet" href="../assets/css/recharge_page(admin).css" />
  <style>
    /* Page-scoped styles to make this page full-bleed */
    body { overflow-x: hidden; margin: 0; }
    main.full-bleed {
      /* width: 100vw;
      max-width: 100vw; */
      
      padding-left: 5%;
    }
    /* keep inner spacing for left/right sections while removing outer gutters */
    main.full-bleed .left-section,
    main.full-bleed .right-section {
      padding: 1rem;
      width: 50%;
      float: left;
    }
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
  
</head>
<body>
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
  <!-- Top Header -->
  <header class="top-header">
    <div class="top-header-content">
      <div>
        <a href="dashboard(admin).php" class="back-link">← Back to Dashboard</a>
        <h1>Add Capital & Gold Purchase</h1>
        <p class="subtitle">Expand your admin wallet reserves</p>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <main class="full-bleed">

    <!-- Left Section -->
    <section class="left-section">

      <!-- Tabs -->
      <div class="tab-bar">
        <button id="usdTab" class="tab active">Add Capital</button>
        <button id="goldTab" class="tab">Purchase Gold</button>
      </div>

      <!-- USD Purchase -->
      <div id="usdPanel" class="panel">
        <h2>Add Capital</h2>
        <div class="info-box green">
          <p class="label">Exchange Rate</p>
          <p class="rate" id="dollar_price">1 Coin = 1,000 MMK</p>
          
        </div>

        <label for="usdAmount">Capital Amount To Add</label>
        <input id="usdAmount" type="number" min="1" placeholder="Enter Coin amount" />
        <p class="buy-dollar-error" id="buy-dollar-error"></p>
        <button id="usdPurchaseBtn" class="btn primary">
          Add 0 Coin
        </button>
      </div>

      <!-- Gold Purchase -->
      <div id="goldPanel" class="panel hidden">
        <h2>Purchase Gold</h2>
        <div class="info-box yellow">
          <p class="label">Gold Price</p>
          <p class="rate" id="gold_price"></p>
          <p class="note" id="gold_price_mmk"></p>
        </div>

        <label for="goldAmount">Gold Amount (kyatar)</label>
        <input id="goldAmount" type="number" min="1" placeholder="Enter gold amount in kyatar" />
        <p class="buy-gold-error" id="buy-gold-error"></p>
        <button id="goldPurchaseBtn" class="btn secondary">
          Purchase 0 kyatar Gold
        </button>
      </div>
    </section>

    <!-- Right Section -->
    <aside class="right-section">

      <!-- Market Overview -->
      <!-- <div class="card market-card">
        <h3>Market Overview</h3>
        <div class="market-grid">
          <div>
            <span class="item-label">USD/MMK Rate</span>
            <span class="item-value">1 : 2,100</span>
            <span class="status stable">Stable</span>
            <div class="small-note">Last updated 5 min ago</div>
          </div>
          <div>
            <span class="item-label">Gold Price</span>
            <span class="item-value">$2,076 / oz</span>
            <span class="status positive">+0.5% today</span>
            <div class="small-note">Updated live from market</div>
          </div>
        </div>

        <div class="market-extra">
          <h4>Other Currencies</h4>
          <ul class="wallet-list">
            <li><span>EUR/MMK</span> <span>2,250</span></li>
            <li><span>JPY/MMK</span> <span>14.2</span></li>
            <li><span>THB/MMK</span> <span>61.5</span></li>
          </ul>
        </div>
      </div> -->

      <!-- Quick Tips -->
      <div class="tips-card">
        <h3>Quick Tips</h3>
        <ul class="tips-list">
          <li>Buy USD when MMK is strong to save reserves.</li>
          <li>Track gold price volatility before large purchases.</li>
          <li>Split purchases into small batches to reduce risk.</li>
          <li>Always keep 10% of reserves as USD for safety.</li>
        </ul>
      </div>

    </aside>
  </main>

  <!-- JS -->
  <script>
    const usdTab = document.getElementById('usdTab');
    const goldTab = document.getElementById('goldTab');
    const usdPanel = document.getElementById('usdPanel');
    const goldPanel = document.getElementById('goldPanel');
    const usdPurchaseBtn = document.getElementById('usdPurchaseBtn');
    const goldPurchaseBtn = document.getElementById('goldPurchaseBtn');

    usdTab.addEventListener('click', () => {
      usdTab.classList.add('active');
      goldTab.classList.remove('active');
      usdPanel.classList.remove('hidden');
      goldPanel.classList.add('hidden');
    });

    goldTab.addEventListener('click', () => {
      goldTab.classList.add('active');
      usdTab.classList.remove('active');
      goldPanel.classList.remove('hidden');
      usdPanel.classList.add('hidden');
    });
    var usdAmount= 0;
    document.getElementById('usdAmount').addEventListener('input', e => {
      const val = parseFloat(e.target.value) || 0;
      if(val<0){
        event.target.value=0;
      }else{
        document.getElementById('usdPurchaseBtn').innerText =
        `Add ${val} Coins (${(val*1000).toLocaleString()} MMK)`;
        usdAmount=val;
        
      }
      
    });
    var goldAmount = 0;
    var gold_price= 0;
    var platform_coin_reserve = 0;
    var total_coin = 0;
    
    document.getElementById('goldAmount').addEventListener('input', e => {
      const val = parseFloat(e.target.value) || 0;
      if(val<0){
        event.target.value=0;
      }else{
        document.getElementById('goldPurchaseBtn').innerText =
        `Purchase ${val} kyatar Gold (Coins ${(val*gold_price).toLocaleString()})`;
        goldAmount=val;
        total_coin = goldAmount*gold_price;
      }
      
    }); 
    usdPurchaseBtn.addEventListener('click',()=>{
        if(usdAmount>0){
          var userData = {
          amount : usdAmount,
          price: 1000,
          type : "capital_in"
        };

        fetch('dashboard_admin_data.php', {
          method: 'POST',
          headers: {
          'Content-Type': 'application/json',
          },
          body: JSON.stringify(userData),
        })
       alert('Add successfully!');
      window.history.back();
        }else{
          document.getElementById('buy-dollar-error').innerHTML= "please enter a valid amount greater than 0";
        document.getElementById('buy-dollar-error').style.display='block';
        }
        
      
      
       
      
    });
    goldPurchaseBtn.addEventListener('click',()=>{
      if(total_coin>platform_coin_reserve){
        document.getElementById('buy-gold-error').innerHTML= "Not enough coins.Platform coin reserve is "+platform_coin_reserve+ " coins";
        document.getElementById('buy-gold-error').style.display='block';
      }else if(goldAmount>0){
          var userData = {
          amount : goldAmount,
          price: gold_price,
          type : "admin_gold_buy"
        };

        fetch('dashboard_admin_data.php', {
          method: 'POST',
          headers: {
          'Content-Type': 'application/json',
          },
          body: JSON.stringify(userData),
        })
       alert('Buy successfully!');
      window.history.back();
        }else{
          document.getElementById('buy-gold-error').innerHTML= "please enter a valid amount greater than 0";
        document.getElementById('buy-gold-error').style.display='block';
        }
     
    });

  </script>

  <script>
    function refreshAllData() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Parse the JSON response text into a JavaScript object
                var data = JSON.parse(this.responseText);
                
                document.getElementById('gold_price').innerHTML= Number(data.base_buy_price).toLocaleString()+" Coins/kyatar";
                document.getElementById('gold_price_mmk').innerHTML= Number(data.base_buy_price*1000).toLocaleString()+" MMK";

                platform_coin_reserve = data.platform_coin_reserve || 0;
                gold_price =data.base_buy_price;
                


                
                
            }
        };
        xhttp.open("GET", "get_dashboard_data.php", true);
        xhttp.send();
    }

    // Call the function to refresh all data every 5 seconds
    setInterval(refreshAllData, 5000);
    refreshAllData();
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const activeTab = "<?php echo $selected_tab; ?>";
  if (activeTab === "usd") {
    usdTab.click();
  } else if (activeTab === "gold") {
    goldTab.click();
  }
});
</script>

</body>
</html>
<?php include('footer.php'); ?>