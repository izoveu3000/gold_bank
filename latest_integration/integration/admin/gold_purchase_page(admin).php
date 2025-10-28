<?php

include('gold_purchase_page_data.php');

$extra_css = '../assets/css/dashboard(admin).css';
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gold Requests</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
  /* Full-bleed layout: remove outer body padding and make container span full viewport width */
  body{background:linear-gradient(135deg,#f9f7f0 0%,#e6dfcb 100%);min-height:100vh;padding:0;margin:0;color:#333;}
  .dashboard-flex{max-width:100vw;width:100%;margin:0;background:#fff;border-radius:0;box-shadow:none;}
  .header{background:linear-gradient(90deg,#bf953f 0%,#fcf6ba 33%,#b38728 66%,#fbf5b7 100%);padding:25px 30px;border-radius:20px;}
    .header h1{font-size:32px;font-weight:700;margin-bottom:10px;}
    .header p{color:#5a4a21;font-size:18px;}
    .filters{display:flex;justify-content:space-between;align-items:center;padding:20px 30px;background:#f8f9fa;border-bottom:1px solid #e1e4e8;flex-wrap:wrap;gap:15px}
    .filter-group{display:flex;gap:15px;}
    .filter-dropdown{position:relative;} /* fix dropdown positioning */
    .filter-btn{padding:10px 20px;border:1px solid #d4af37;border-radius:8px;background:#fff;color:#5a4a21;cursor:pointer;font-weight:500;display:flex;justify-content:space-between;align-items:center;min-width:180px;}
    .filter-btn i{margin-left:10px;transition:.3s;}
    .filter-btn.active i{transform:rotate(180deg);}
    .dropdown-content{display:none;position:absolute;right:0;background:#fff;min-width:180px;border:1px solid #d4af37;border-radius:8px;box-shadow:0 8px 16px rgba(0,0,0,.1);margin-top:5px;z-index:100;}
    .dropdown-content a{padding:12px 16px;display:block;color:#5a4a21;text-decoration:none;cursor:pointer;}
    .dropdown-content a:hover{background:#fcf6ba;}
    .dropdown-content a.active{background:#b38728;color:#fff;}
    .show{display:block;}
    .search-bar{display:flex;align-items:center;border:1px solid #d4af37;border-radius:8px;padding:8px 15px;width:300px;background:#fff;}
    .search-bar input{border:none;outline:none;width:100%;padding:10px;font-size:16px;}
    .search-bar i{color:#b38728;}
    .requests-table-container{overflow-x:auto;padding:20px;}
    .requests-table{width:100%;border-collapse:collapse;}
    .requests-table th{background:linear-gradient(to bottom,#bf953f,#b38728);color:#fff;padding:18px;text-align:left;position:sticky;top:0;}
    .requests-table td{padding:18px;border-bottom:1px solid #e1e4e8;}
    .requests-table tr:nth-child(even){background:#fffbf0;}
    .requests-table tr:hover{background:#f9f2de;}
    .user-info{display:flex;flex-direction:column;}
    .user-name{font-weight:600;color:#2c3e50;}
    .user-details{color:#7f8c8d;font-size:14px;}
    .request-type{padding:6px 12px;border-radius:20px;font-size:14px;font-weight:500;}
    .type-purchase{background:#e8f5e9;color:#2e7d32;}
    .type-withdrawal{background:#e3f2fd;color:#1565c0;}
    .gold-amount{color:#b38728;font-weight:600;}
    .cost-amount{color:#27ae60;font-weight:600;}
    .action-buttons{display:flex;gap:10px;}
    .action-button{padding:8px 15px;border:none;border-radius:6px;font-size:14px;font-weight:500;cursor:pointer;}
    .approve-button{background:#2e7d32;color:#fff;}
    .reject-button{background:#c62828;color:#fff;}
    .approve-button:hover{background:#1b5e20;}
    .reject-button:hover{background:#b71c1c;}
    .stats-bar{display:flex;justify-content:space-around;background:#f8f5e6;padding:15px;border-top:1px solid #e1dcc1;}
    .stat-item{text-align:center;}
    .stat-value{font-size:20px;font-weight:700;color:#b38728;}
    .pagination{display:flex;justify-content:center;align-items:center;gap:8px;margin:20px;}
    .pagination button{padding:8px 14px;border:1px solid #d4af37;border-radius:6px;background:#fff;color:#5a4a21;font-weight:500;cursor:pointer;}
    .pagination button.active{background:#b38728;color:#fff;}
    .pagination button:hover{background:#fcf6ba;}
    .pagination button:disabled{opacity:.5;cursor:not-allowed;}
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
<body id="body">
<div class="dashboard-flex" style="margin-top: 10px;">
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
  <div class="header">
    <h1>Gold Requests</h1>
    <p>Review and manage gold purchase & withdrawal requests</p>
  </div>

  <div class="filters">
    <div class="filter-group">
      <div class="filter-dropdown">
        <button class="filter-btn" onclick="toggleDropdown('typeDropdown', event)">
          All Requests <i class="fas fa-chevron-down"></i>
        </button>
        <div id="typeDropdown" class="dropdown-content">
          <a onclick="selectFilter('type','all', this)" class="active">All Requests</a>
          <a onclick="selectFilter('type','purchase', this)">Purchase</a>
          <a onclick="selectFilter('type','withdrawal', this)">Withdrawal</a>
        </div>
      </div>
    </div>
    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" id="searchInput" placeholder="Search by name, ID, or request #..." onkeyup="resetAndFilter()">
    </div>
  </div>

  <div class="requests-table-container">
    <table class="requests-table">
      <thead>
        <tr>
          <th>User</th><th>Request ID</th><th>Type</th><th>Gold Amount</th><th>Value</th><th>Submitted</th><th>Actions</th>
        </tr>
      </thead>
      <tbody id="requestsTableBody"></tbody>
    </table>
  </div>

  <div id="pagination" class="pagination"></div>

  <div class="stats-bar">
    <div class="stat-item">
      <div class="stat-value" id="totalRequests">0</div>
      <div class="stat-label">Total Requests</div>
    </div>
    <div class="stat-item">
      <div class="stat-value" id="totalGold">0 oz</div>
      <div class="stat-label">Total Gold</div>
    </div>
    <div class="stat-item">
      <div class="stat-value" id="totalValue">$0</div>
      <div class="stat-label">Total Value</div>
    </div>
  </div>
</div>

<script>
    const tableBody = document.getElementById('requestsTableBody');
    let allTransactions = []; 
    let currentTypeFilter = 'all';
    let searchQuery = '';
    let currentPage = 1;
    const rowsPerPage = 5;

    function refreshTable() {
      fetch('get_gold_purchase_page_data.php')
        .then(res => res.json())
        .then(transactions => {
          allTransactions = transactions;
          filterRequests();
        })
        .catch(err => console.error('Error fetching data:', err));
    }

    function filterRequests() {
      searchQuery = document.getElementById('searchInput').value.toLowerCase();
      let filtered = allTransactions.filter(tx => {
        const matchType = currentTypeFilter === 'all' || tx.transaction_type === currentTypeFilter;
        const matchSearch = (
          tx.user_name.toLowerCase().includes(searchQuery) ||
          String(tx.user_id).includes(searchQuery) ||
          String(tx.transaction_id).includes(searchQuery)
        );
        return matchType && matchSearch;
      });

      // Stats
      const totalGold = filtered.reduce((sum, tx) => sum + parseFloat(tx.amount), 0);
      const totalValue = filtered.reduce((sum, tx) => sum + parseFloat(tx.total), 0);

      document.getElementById('totalRequests').textContent = filtered.length;
      document.getElementById('totalGold').textContent = totalGold.toFixed(1) + ' oz';
      document.getElementById('totalValue').textContent = '$' + totalValue.toLocaleString();

      // Pagination
      const totalPages = Math.max(1, Math.ceil(filtered.length / rowsPerPage));
      if (currentPage > totalPages) currentPage = totalPages;
      const start = (currentPage - 1) * rowsPerPage;
      const end = start + rowsPerPage;
      const pageRows = filtered.slice(start, end);

      // Render table
      tableBody.innerHTML = '';
      pageRows.forEach(tx => {
        const row = document.createElement('tr');
        row.setAttribute('data-type', tx.transaction_type);
        row.innerHTML = `
          <td>
            <div class="user-info">
              <span class="user-name">${tx.user_name}</span>
              <span class="user-details">ID: <span class="user-id">${tx.user_id}</span></span>
            </div>
          </td>
          <td class="transaction_id">${tx.transaction_id}</td>
          <td><span class="request-type type-${tx.transaction_type}">${tx.transaction_type}</span></td>
          <td class="gold-amount"><span class="gold">${tx.amount}</span> oz</td>
          <td>
            <div class="cost-amount">$ <span class="cost">${tx.total}</span></div>
            <div class="price-info">Gold Price $${tx.price}/oz</div>
          </td>
          <td>${tx.transaction_date}</td>
          <td>
            <div class="action-buttons">
              <button class="action-button approve-button" onclick="updateStatus(this,'approved')">Approve</button>
              <button class="action-button reject-button" onclick="updateStatus(this,'rejected')">Reject</button>
            </div>
          </td>
        `;
        tableBody.appendChild(row);
      });

      renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
      const p = document.getElementById('pagination');
      p.innerHTML = '';
      if (totalPages <= 1) return;

      const prev = document.createElement('button');
      prev.innerHTML = '&laquo;';
      prev.disabled = currentPage === 1;
      prev.onclick = () => { if (currentPage > 1) { currentPage--; filterRequests(); } };
      p.appendChild(prev);

      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        if (i === currentPage) btn.classList.add('active');
        btn.onclick = () => { currentPage = i; filterRequests(); };
        p.appendChild(btn);
      }

      const next = document.createElement('button');
      next.innerHTML = '&raquo;';
      next.disabled = currentPage === totalPages;
      next.onclick = () => { if (currentPage < totalPages) { currentPage++; filterRequests(); } };
      p.appendChild(next);
    }

    // Dropdown toggle
    function toggleDropdown(id, event) {
      if (event) event.stopPropagation();
      document.querySelectorAll('.dropdown-content').forEach(d => {
        if (d.id !== id) d.classList.remove('show');
      });
      document.getElementById(id).classList.toggle('show');
    }

    function selectFilter(type, val, el) {
      document.querySelectorAll('#typeDropdown a').forEach(a => a.classList.remove('active'));
      el.classList.add('active');
      document.querySelector('.filter-btn').innerHTML = `${el.textContent} <i class="fas fa-chevron-down"></i>`;
      currentTypeFilter = val;
      currentPage = 1;
      filterRequests();
      document.getElementById('typeDropdown').classList.remove('show');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
      document.querySelectorAll('.dropdown-content').forEach(d => d.classList.remove('show'));
    });

    // Search input
    function resetAndFilter() {
      currentPage = 1;
      filterRequests();
    }
    
   
    // Action buttons
    function updateStatus(btn, status) {
      const row = btn.closest('tr');
      var gold_amount = row.querySelector('.gold').textContent;
      var total_dollar = row.querySelector('.cost').textContent;
      //check what button clicked
      if(status=="approved"){
        update_status="approve";

        //check transaction type if buy gold check gold amount
        if(row.querySelector('.request-type').textContent=="purchase"){
          //check amount
         

          
            let result = confirm("are you sure to submit this request?");
            if (result) {
              var userData = {
                transaction_id : row.querySelector('.transaction_id').textContent,
                user_id: row.querySelector('.user-id').textContent,
                transaction_status : update_status,
                gold_amount : gold_amount,
                total_dollar:total_dollar,
                transaction_type: "purchase"
              };
              fetch('gold_purchase_page_data.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData),
              })
              window.location.href="gold_purchase_page(admin).php";

            } else {        
            }
          
        }else{
          //if withdraw check dollar amount

          
            let result = confirm("are you sure to submit this request?");
            if (result) {
              var userData = {
                transaction_id : row.querySelector('.transaction_id').textContent,
                user_id: row.querySelector('.user-id').textContent,
                transaction_status : update_status,
                gold_amount : gold_amount,
                total_dollar:total_dollar,
                transaction_type: "withdrawal"
              };

              fetch('gold_purchase_page_data.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData),
              })
              window.location.href="gold_purchase_page(admin).php";
        
            } else {        
            }
          
        }
        

      }else{
        update_status= "reject";
        let result = confirm("are you sure to reject this request?");
        if (result) {
          var userData = {
            transaction_id : row.querySelector('.transaction_id').textContent,
            user_id: row.querySelector('.user-id').textContent,
            transaction_status : update_status,
            gold_amount : gold_amount,
            total_dollar:total_dollar,
            transaction_type: row.querySelector('.request-type').textContent
          };

          fetch('gold_purchase_page_data.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
          })
          window.location.href = "gold_purchase_page(admin).php";

        } else {        
        }
      }
      

    }

    // Init
    document.addEventListener('DOMContentLoaded', () => refreshTable());
    setInterval(refreshTable, 5000);
</script>
</body>
</html>
<?php include('footer.php'); ?>