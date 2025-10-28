<?php

include('transaction_admin_data.php');
$extra_css = '../assets/css/dashboard(admin).css';
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f9f7f0 0%, #e6dfcb 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            margin: 0;
            padding: 0; /* remove outer padding so layout can be full-bleed */
        }

        /* make the page full width (no side gaps) */
        .container {
            width: 100vw;
            max-width: 100vw;
            background: white;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
            box-sizing: border-box;
            padding: 20px; /* internal spacing */
        }
        
        .header {
            background: linear-gradient(90deg, #bf953f 0%, #fcf6ba 33%, #b38728 66%, #fbf5b7 100%);
            color: #333;
            padding: 25px 30px;
            border-radius: 15px 15px 0 0;
        }
        
        .header h1 {
            font-weight: 700;
            font-size: 32px;
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.5);
            margin-bottom: 10px;
        }
        
        .header p {
            color: #5a4a21;
            font-size: 18px;
            max-width: 800px;
        }
        
        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #e1e4e8;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 8px;
            padding: 8px 15px;
            width: 300px;
            border: 1px solid #d4af37;
        }
        
        .search-bar input {
            border: none;
            outline: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            background: transparent;
        }
        
        .search-bar i {
            color: #b38728;
            font-size: 18px;
        }
        
        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-select {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #d4af37;
            background: white;
            color: #5a4a21;
            font-weight: 500;
            cursor: pointer;
            min-width: 150px;
        }
        
        .transaction-table-container {
            overflow-x: auto;
            padding: 20px;
        }
        
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .transaction-table th {
            background: linear-gradient(to bottom, #bf953f 0%, #b38728 100%);
            color: white;
            text-align: left;
            padding: 18px;
            font-weight: 600;
            font-size: 16px;
            position: sticky;
            top: 0;
        }
        
        .transaction-table td {
            padding: 18px;
            border-bottom: 1px solid #e1e4e8;
            font-size: 16px;
        }
        
        .transaction-table tr:nth-child(even) {
            background-color: #fffbf0;
        }
        
        .transaction-table tr:hover {
            background-color: #f9f2de;
            transition: background-color 0.2s;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 17px;
        }
        
        .user-id {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 4px;
        }
        
        .transaction-id {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .transaction-type {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .type-deposit {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .type-withdrawal {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .type-conversion {
            background-color: #e3f2fd;
            color: #1565c0;
        }
        
        .type-transfer {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        
        .amount {
            font-weight: 600;
        }
        
        .amount-usd {
            color: #27ae60;
        }
        
        .amount-gold {
            color: #b38728;
        }
        
        .currency {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 4px;
        }
        
        .status {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-completed {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-pending {
            background-color: #fff8e1;
            color: #f57c00;
        }
        
        .status-failed {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .date {
            color: #2c3e50;
            font-weight: 500;
        }
        
        .time {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 4px;
        }
        
        .reference {
            font-family: monospace;
            font-size: 15px;
            color: #5a4a21;
            font-weight: 500;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px;
            gap: 10px;
        }
        
        .pagination-button {
            padding: 10px 18px;
            border-radius: 8px;
            border: 1px solid #d4af37;
            background: white;
            color: #5a4a21;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .pagination-button:hover{
            background: #b38728;
            color: white;
        }
        .pagination-button.active {
            background: #b38728;
            color: white;
        }
        
        @media (max-width: 1200px) {
            .filters {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-bar {
                width: 100%;
            }
            
            .filter-group {
                width: 100%;
                justify-content: space-between;
            }
            
            .filter-select {
                flex-grow: 1;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 28px;
            }
            
            .header p {
                font-size: 16px;
            }
            
            .transaction-table th,
            .transaction-table td {
                padding: 12px;
                font-size: 14px;
            }
            
            .transaction-table {
                min-width: 1000px;
            }
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
        <div class="header">
            <h1>Transaction History</h1>
            <p>View all user transactions and activities</p>
            <p>Monitor and review all platform transactions and user activities</p>
        </div>
        
        <div class="filters">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by ID, user, or reference...">
            </div>
            
            <div class="filter-group">
                <select class="filter-select" id="typeFilter">
                    <option value="all">All Types</option>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                    <option value="user_gold_buy">Buy Gold</option>
                    <option value="user_gold_sell">Sell Gold</option>
                    
                </select>
                
                <select class="filter-select" id="statusFilter">
                    <option value="all">All Status</option>
                    <option value="approve">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="reject">Reject</option>
                    <option value="cancel">Cancel</option>
                    <option value="warn">warn</option>
                </select>
            </div>
        </div>
        
        <div class="transaction-table-container">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody id="transactionTableBody">
                    
                </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <button class="pagination-button active">1</button>
            <button class="pagination-button">2</button>
            <button class="pagination-button">3</button>
            <button class="pagination-button">4</button>
            <button class="pagination-button">5</button>
        </div>
    </div>
    <script>
const rowsPerPage = 10;
let currentPage = 1;

const searchInput = document.getElementById('searchInput');
const typeFilter = document.getElementById('typeFilter');
const statusFilter = document.getElementById('statusFilter');
const tableBody = document.getElementById('transactionTableBody');

// ------------- FILTER FUNCTION -------------
function getFilteredRows() {
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const searchText = searchInput.value.toLowerCase();
    const typeValue = typeFilter.value;
    const statusValue = statusFilter.value;

    return rows.filter(row => {
        const id = row.querySelector('.transaction-id').textContent.toLowerCase();
        const userName = row.querySelector('.user-name').textContent.toLowerCase();
        const userId = row.querySelector('.user-id').textContent.toLowerCase();
        const type = row.querySelector('.transaction-type').textContent.toLowerCase();
        const status = row.querySelector('.status').textContent.toLowerCase();
        // const reference = row.querySelector('.reference').textContent.toLowerCase();

        const matchesSearch = id.includes(searchText) || userName.includes(searchText) ||
                              userId.includes(searchText) ;
        const matchesType = typeValue === 'all' || type === typeValue;
        const matchesStatus = statusValue === 'all' || status === statusValue;

        return matchesSearch && matchesType && matchesStatus;
    });
}

// ------------- PAGINATION FUNCTION -------------
function showPage(page) {
    const filteredRows = getFilteredRows();
    const totalRows = filteredRows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

    if (page < 1) page = 1;
    if (page > totalPages) page = totalPages;
    currentPage = page;

    // hide all rows
    const allRows = Array.from(tableBody.querySelectorAll('tr'));
    allRows.forEach(row => row.style.display = 'none');

    // show only current page rows
    const start = (page - 1) * rowsPerPage;
    const end = page * rowsPerPage;
    filteredRows.slice(start, end).forEach(row => row.style.display = '');

    renderPagination(totalPages);
}

// ------------- PAGINATION BUTTONS -------------
function renderPagination(totalPages) {
    const paginationDiv = document.querySelector('.pagination');
    paginationDiv.innerHTML = '';

    if (totalPages <= 1) return; // hide pagination if only one page

    // Previous
    const prev = document.createElement('button');
    prev.classList.add('pagination-button');
    prev.innerText = '«';
    prev.disabled = currentPage === 1;
    prev.addEventListener('click', () => showPage(currentPage - 1));
    paginationDiv.appendChild(prev);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.classList.add('pagination-button');
        if (i === currentPage) btn.classList.add('active');
        btn.innerText = i;
        btn.addEventListener('click', () => showPage(i));
        paginationDiv.appendChild(btn);
    }

    // Next
    const next = document.createElement('button');
    next.classList.add('pagination-button');
    next.innerText = '»';
    next.disabled = currentPage === totalPages;
    next.addEventListener('click', () => showPage(currentPage + 1));
    paginationDiv.appendChild(next);
}

// ------------- FILTER LISTENERS -------------
searchInput.addEventListener('keyup', () => showPage(1));
typeFilter.addEventListener('change', () => showPage(1));
statusFilter.addEventListener('change', () => showPage(1));

// ------------- FETCH & REFRESH -------------
function refreshTable() {
    fetch('get_transaction_admin_data.php')
        .then(res => res.json())
        .then(transactions => {
            tableBody.innerHTML = '';
            transactions.forEach(tx => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="transaction-id">${tx.transaction_id}</td>
                    <td>
                        <div class="user-info">
                            <span class="user-name">${tx.user_name}</span>
                            <span class="user-id">ID: ${tx.user_id}</span>
                        </div>
                    </td>
                    <td><span class="transaction-type ${tx.type_class}">${tx.transaction_type}</span></td>
                    <td>
                        <div class="amount ${tx.amount_class}">${tx.amount}</div>
                        <div class="currency">${tx.currency_name}</div>
                    </td>
                    <td><span class="status ${tx.status_class}">${tx.transaction_status}</span></td>
                    <td>
                        <div class="date">${tx.transaction_date}</div>
                        <div class="time">${tx.transaction_time}</div>
                    </td>
                    <td>
                        <div clas="reference">${tx.reference_number}</div>
                        <div class="bank_name">${tx.bank_name}</div>
                    </td>
                    
                `;
                tableBody.appendChild(row);
            });
            showPage(currentPage); // apply pagination & filters
        })
        .catch(err => console.error(err));
}

// Initial load
document.addEventListener('DOMContentLoaded', () => refreshTable());

// Auto-refresh every 5 seconds
setInterval(refreshTable, 5000);
</script>

    

    
    </body>
</html>
<?php include('footer.php'); ?>