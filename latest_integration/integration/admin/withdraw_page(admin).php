<?php

 include('withdraw_page_admin_data.php'); ?>
<?php

$extra_css = '../assets/css/dashboard(admin).css';
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html, body {
            height: 100%;
            width: 100%;
        }
        
        body {
            background: linear-gradient(135deg, #f9f7f0 0%, #e6dfcb 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            /* remove outer padding to eliminate side gaps */
            padding: 0;
            margin: 0;
        }
        
        .container {
            width: 100%;
            height: 100vh;
            background: white;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background: linear-gradient(90deg, #bf953f 0%, #fcf6ba 33%, #b38728 66%, #fbf5b7 100%);
            color: #333;
            padding: 25px 30px;
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
        
        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .filter-btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: 1px solid #d4af37;
            background: white;
            color: #5a4a21;
            font-weight: 500;
            cursor: pointer;
            min-width: 180px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .filter-btn i {
            margin-left: 10px;
            transition: transform 0.3s ease;
        }
        
        .filter-btn.active i {
            transform: rotate(180deg);
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 180px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 8px;
            border: 1px solid #d4af37;
            overflow: hidden;
            margin-top: 5px;
        }
        
        .dropdown-content a {
            color: #5a4a21;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            cursor: pointer;
        }
        
        .dropdown-content a:hover {
            background-color: #fcf6ba;
        }
        
        .dropdown-content a.active {
            background-color: #b38728;
            color: white;
        }
        
        .show {
            display: block;
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
        
        .refresh-btn {
            background: #d4af37;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s ease;
        }
        
        .refresh-btn:hover {
            background: #b38728;
        }
        
        .refresh-btn.loading i {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .refresh-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: #e8f4fd;
            border-radius: 8px;
            margin: 0 20px;
            font-size: 14px;
            color: #0c4a6e;
        }
        
        .refresh-indicator i {
            color: #0ea5e9;
        }
        
        .refresh-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #0ea5e9;
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .requests-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }
        
        .request-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
            border-left: 4px solid #d4af37;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            justify-content: space-between;
        }
        
        .request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .request-content {
            flex: 1;
        }
        
        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .request-id {
            font-weight: 700;
            color: #1e40af;
            font-size: 18px;
        }
        
        .request-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .request-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 16px;
            font-weight: 500;
            color: #1e293b;
        }
        
        .gold-amount {
            color: #b38728;
            font-weight: 600;
        }
        
        .cost-amount {
            color: #27ae60;
            font-weight: 600;
        }
        
        .price-info {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 4px;
        }
        
        .action-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            min-width: 180px;
            padding-left: 20px;
            border-left: 1px solid #e2e8f0;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .action-button {
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
        }
        
        .approve-button {
            background-color: #2e7d32;
            color: white;
        }
        
        .approve-button:hover {
            background-color: #1b5e20;
        }
        
        .reject-button {
            background-color: #c62828;
            color: white;
        }
        
        .reject-button:hover {
            background-color: #b71c1c;
        }
        
        .status-text {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .stats-bar {
            display: flex;
            justify-content: space-around;
            background: #f8f5e6;
            padding: 15px;
            border-top: 1px solid #e1dcc1;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: #b38728;
        }
        
        .stat-label {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .modal-header {
            background: linear-gradient(90deg, #bf953f 0%, #fcf6ba 100%);
            color: #5a4a21;
            padding: 20px;
            text-align: center;
            font-weight: 600;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            padding: 20px;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
        }
        
        .form-group input, 
        .form-group textarea, 
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .file-upload {
            border: 2px dashed #d1d5db;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
            cursor: pointer;
        }
        
        .file-upload:hover {
            border-color: #3b82f6;
        }
        
        .file-upload i {
            font-size: 24px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        
        .file-upload-text {
            color: #6b7280;
            font-size: 14px;
        }
        
        .modal-button {
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .modal-button-primary {
            background-color: #b38728;
            color: white;
        }
        
        .modal-button-primary:hover {
            background-color: #8f6c20;
        }
        
        .modal-button-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .modal-button-secondary:hover {
            background-color: #4b5563;
        }
        
        @media (max-width: 1200px) {
            .filters {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-group {
                width: 100%;
                justify-content: space-between;
            }
            
            .search-bar {
                width: 100%;
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
            
            .request-card {
                flex-direction: column;
            }
            
            .action-section {
                border-left: none;
                border-top: 1px solid #e2e8f0;
                padding-left: 0;
                padding-top: 20px;
                align-items: stretch;
                min-width: auto;
            }
            
            .request-details {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: row;
            }
        
        }
    </style>
    <style>
    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin: 30px 0;
        gap: 8px;
    }

    .pagination button {
        background: #fff;
        border: 1px solid #d4af37;
        color: #d4af37;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 500;
    }

    .pagination button:hover:not(:disabled) {
        background: #d4af37;
        color: white;
    }

    .pagination button.active {
        background: #d4af37;
        color: white;
        font-weight: bold;
    }

    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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
    <div class="dashboard-flex d-flex">
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
            <h1>Withdrawal Requests</h1>
            <p>Review and manage withdrawal requests</p>
        </div>
        
        <div class="refresh-indicator" style="display: none;">
            <i class="fas fa-sync-alt"></i>
            <span>Auto-refresh: <span id="refreshStatus">Enabled</span></span>
            <div class="refresh-toggle">
                <span>Off</span>
                <label class="switch">
                    <input type="checkbox" id="autoRefreshToggle" checked>
                    <span class="slider"></span>
                </label>
                <span>On</span>
            </div>
            <span id="lastUpdate">Last updated: Just now</span>
        </div>
        
        <div class="filters">          
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by name, ID, or request #..." onkeyup="filterRequests()">
            </div>
            <button class="refresh-btn" style="display: none;" id="refreshBtn" onclick="refreshWithdrawalData()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
        
        <div class="requests-container" id="requestsContainer">
            
        </div>
        
        <!-- PAGINATION -->
        <div class="pagination" id="paginationContainer"></div>
        
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value" id="totalRequests">5</div>
                <div class="stat-label">Total Requests</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="totalGold">9.35 $</div>
                <div class="stat-label">Total Coin</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="totalValue">MMK19,656</div>
                <div class="stat-label">Total Value</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="pendingRequests">2</div>
                <div class="stat-label">Pending Approval</div>
            </div>
        </div>
    </div>
    
    <!-- Approve Modal -->
    <div class="modal" id="approveModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Approve Withdrawal - <span id="approveRequestId"></span></h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Withdrawing to user: <strong id="approveUserName"></strong></p>
                    <p>Coin Amount: <strong id="approveGoldAmount"></strong></p>
                    <p>Value: <strong id="approveAmount"></strong></p>
                    <p>Bank: <strong id="approveBank"></strong></p>
                </div>
                
                <div class="form-group">
                    <label for="transactionId">Transaction ID</label>
                    <input type="text" id="transactionId" placeholder="Enter transaction ID">
                </div>
                
                <div class="form-group">
                    <label>Proof Image</label>
                    <div class="file-upload" onclick="document.getElementById('proofFile').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <div class="file-upload-text" id="fileUploadText">Browse... No file selected.</div>
                        <input type="file" id="proofFile" style="display: none;" onchange="updateFileName()">
                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button class="modal-button modal-button-secondary" onclick="closeModal('approveModal')">Cancel</button>
                <button class="modal-button modal-button-primary" onclick="approveRequest()">Confirm Approval</button>
            </div>
        </div>
    </div>
    
    <!-- Reject Modal -->
    <div class="modal" id="rejectModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reject Withdrawal - <span id="rejectRequestId"></span></h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Rejecting request for: <strong id="rejectUserName"></strong></p>
                    <p>Dollar Amount: <strong id="rejectGoldAmount"></strong></p>
                    <p>Value: <strong id="rejectAmount"></strong></p>
                </div>
                
                <div class="form-group">
                    <label for="rejectReason">Reason for rejection</label>
                    <textarea id="rejectReason" placeholder="Enter reason for rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-button modal-button-secondary" onclick="closeModal('rejectModal')">Cancel</button>
                <button class="modal-button modal-button-primary" onclick="rejectRequest()">Confirm Rejection</button>
            </div>
        </div>
    </div>
    
    <script>
        let currentStatusFilter = 'all';
        let searchQuery = '';
        let currentRequestId = '';
        let currentUserId='';
        let currentPage = 1;
        const rowsPerPage = 5;
        let requestsData = {};
        let autoRefreshInterval;
        let isAutoRefreshEnabled = true;
        const refreshInterval = 5000; // 5 seconds

        // === AUTO-REFRESH TOGGLE ===
        document.getElementById('autoRefreshToggle').addEventListener('change', function() {
            isAutoRefreshEnabled = this.checked;
            document.getElementById('refreshStatus').textContent = isAutoRefreshEnabled ? 'Enabled' : 'Disabled';
            
            if (isAutoRefreshEnabled) {
                startAutoRefresh();
            } else {
                clearInterval(autoRefreshInterval);
            }
        });

        // === START AUTO-REFRESH ===
        function startAutoRefresh() {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = setInterval(refreshWithdrawalData, refreshInterval);
        }

        // === UPDATE LAST UPDATE TIME ===
        function updateLastUpdateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('lastUpdate').textContent = `Last updated: ${timeString}`;
        }
        refreshWithdrawalData();
        // === AJAX REFRESH FUNCTION ===
        function refreshWithdrawalData() {
            const refreshBtn = document.getElementById('refreshBtn');
            refreshBtn.classList.add('loading');
            
            // Store current page before refresh
            const previousPage = currentPage;
            
            fetch('get_withdraw_page_admin_data.php')
                .then(response => response.json())
                .then(data => {
                    // Update requestsData object
                    requestsData = {};
                    data.forEach(req => {
                        const id = req.transaction_id;
                        requestsData[id] = {
                            user: req.user_name,
                            userId: req.user_id,
                            amount: req.amount, 
                            total: 'MMK ' + parseFloat(req.total).toLocaleString('en-US', { minimumFractionDigits: 2 }),
                            transactionId: req.transaction_id,
                            submitted: req.transaction_date,
                            status: req.transaction_status.toLowerCase(),
                            accountNumber: req.account_number,
                            bankName: req.bank_name,
                        };
                    });

                    // Update the DOM
                    updateRequestsDOM();
                    
                    // Restore the previous page after DOM update
                    currentPage = previousPage;
                    
                    // Apply filters and pagination with the restored page
                    filterRequests(false);
                    
                    refreshBtn.classList.remove('loading');
                    updateLastUpdateTime();
                })
                .catch(error => {
                    console.error('Error refreshing data:', error);
                    refreshBtn.classList.remove('loading');
                    alert('Error refreshing data');
                });
        }

        // === UPDATE DOM WITH NEW DATA ===
        function updateRequestsDOM() {
            const container = document.getElementById('requestsContainer');
            container.innerHTML = '';

            if (Object.keys(requestsData).length === 0) {
                container.innerHTML = '<p style="text-align:center; padding: 40px;">No withdrawal requests found.</p>';
                return;
            }

            // Sort by transaction ID (newest first)
            const sortedIds = Object.keys(requestsData).sort((a, b) => b - a);
            
            sortedIds.forEach(id => {
                const req = requestsData[id];
                const card = document.createElement('div');
                card.className = 'request-card';
                card.id = `card-${id}`;
                card.setAttribute('data-status', req.status);
                //userId,userName, requestId, goldAmount, amount, bank
                let actionButtons = '';
                if (req.status === 'pending') {
                    actionButtons = `
                        <div class="action-buttons" id="actions-${id}">
                            <button class="action-button approve-button"
                                onclick="openApproveModal('${req.userId}','${req.user}', '${id}', ${parseFloat(req.amount)}, ${parseFloat(req.total.replace(/[^\d.]/g, ''))}, '${req.accountNumber} - ${req.bankName}')">
                                Approve
                            </button>
                            <button class="action-button reject-button"
                                onclick="openRejectModal('${req.userId}','${req.user}', '${id}', ${parseFloat(req.amount)}, ${parseFloat(req.total.replace(/[^\d.]/g, ''))})">
                                Reject
                            </button>
                        </div>
                    `;
                } else if (req.status === 'approved') {
                    actionButtons = '<div class="status-text status-approved">Request Approved</div>';
                } else if (req.status === 'rejected') {
                    actionButtons = '<div class="status-text status-rejected">Request Rejected</div>';
                }

                card.innerHTML = `
                    <div class="request-content">
                        <div class="request-header">
                            <div class="request-id">#${id}</div>
                            <div class="request-status status-${req.status}">
                                ${req.status.charAt(0).toUpperCase() + req.status.slice(1)}
                            </div>
                        </div>

                        <div class="request-details">
                            <div class="detail-item">
                                <span class="detail-label">User</span>
                                <span class="detail-value">${req.user}</span>
                                <span class="detail-label">ID: ${req.userId}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Coin Amount</span>
                                <span class="detail-value gold-amount">${req.amount}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Value</span>
                                <span class="detail-value cost-amount">${req.total}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Bank Details</span>
                                <span class="detail-value">${req.accountNumber} - ${req.bankName}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Submitted</span>
                                <span class="detail-value">${req.submitted}</span>
                            </div>
                        </div>
                    </div>

                    <div class="action-section">
                        ${actionButtons}
                    </div>
                `;

                container.appendChild(card);
            });
        }

        // === INITIALIZE REQUESTS DATA ===
        function initializeRequestsData() {
            document.querySelectorAll('.request-card').forEach(card => {
                const id = card.id.replace('card-', '');
                const status = card.getAttribute('data-status');
                const user = card.querySelector('.detail-item .detail-value')?.textContent || '';
                const userId = card.querySelector('.detail-item .detail-label:last-child')?.textContent?.replace('ID: ', '') || '';
                const amount = card.querySelector('.gold-amount')?.textContent || '';
                const total = card.querySelector('.cost-amount')?.textContent || '';
                const bankDetails = card.querySelector('.detail-item:nth-child(4) .detail-value')?.textContent || '';
                const [accountNumber, bankName] = bankDetails.split(' - ');
                const submitted = card.querySelector('.detail-item:last-child .detail-value')?.textContent || '';
                const price = card.querySelector('.price-info')?.textContent?.match(/MMK([\d,]+\.\d{2})/)?.[1]?.replace(/,/g, '') || '';

                requestsData[id] = {
                    user,
                    userId,
                    amount,
                    total,
                    transactionId: id,
                    submitted,
                    status,
                    accountNumber: accountNumber || '',
                    bankName: bankName || '',
                    price
                };
            });
        }

        // === FILTER + PAGINATION COMBINED ===
        function filterRequests(resetPage = true) {
            searchQuery = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.request-card');
            const visibleCards = [];

            let visibleCount = 0, pendingCount = 0, totalGold = 0, totalValue = 0;

            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                const textContent = card.textContent.toLowerCase();
                const statusMatch = currentStatusFilter === 'all' || status === currentStatusFilter;
                const searchMatch = textContent.includes(searchQuery);

                if (statusMatch && searchMatch) {
                    visibleCards.push(card);
                    visibleCount++;
                    if (status === 'pending') pendingCount++;

                    const goldText = card.querySelector('.gold-amount').textContent;
                    const goldAmount = parseFloat(goldText);
                    totalGold += isNaN(goldAmount) ? 0 : goldAmount;

                    const valueText = card.querySelector('.cost-amount').textContent;
                    const value = parseFloat(valueText.replace(/[^\d.]/g, ''));
                    totalValue += isNaN(value) ? 0 : value;
                }
            });

            document.getElementById('totalRequests').textContent = visibleCount;
            document.getElementById('pendingRequests').textContent = pendingCount;
            document.getElementById('totalGold').textContent = totalGold.toFixed(2) + ' coin';
            document.getElementById('totalValue').textContent = 'MMK ' + totalValue.toLocaleString();

            // Only reset page if explicitly requested (not during auto-refresh)
            if (resetPage) {
                currentPage = 1;
            }
            
            paginateCards(visibleCards);
        }

        // === PAGINATION FUNCTIONS ===
        function paginateCards(cards) {
            const totalPages = Math.ceil(cards.length / rowsPerPage);
            const paginationContainer = document.getElementById('paginationContainer');
            paginationContainer.innerHTML = '';

            // Ensure current page is valid
            if (currentPage > totalPages && totalPages > 0) {
                currentPage = totalPages;
            }

            if (totalPages <= 1) {
                paginationContainer.style.display = 'none';
                cards.forEach(c => c.style.display = 'flex');
                return;
            }
            paginationContainer.style.display = 'flex';

            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '&laquo;';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => changePage(currentPage - 1, cards);
            paginationContainer.appendChild(prevBtn);

            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, startPage + 4);

            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.textContent = i;
                if (i === currentPage) pageBtn.classList.add('active');
                pageBtn.onclick = () => changePage(i, cards);
                paginationContainer.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.innerHTML = '&raquo;';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => changePage(currentPage + 1, cards);
            paginationContainer.appendChild(nextBtn);

            showPage(cards);
        }

        function changePage(pageNum, cards) {
            currentPage = pageNum;
            paginateCards(cards);
        }

        function showPage(cards) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // First hide all cards
            document.querySelectorAll('.request-card').forEach(card => {
                card.style.display = 'none';
            });
            
            // Then show only the cards for the current page
            cards.forEach((card, i) => {
                if (i >= start && i < end) {
                    card.style.display = 'flex';
                }
            });
        }

        // === FILE + MODAL FUNCTIONS ===
        function updateFileName() {
            const fileInput = document.getElementById('proofFile');
            const fileText = document.getElementById('fileUploadText');
            fileText.textContent = fileInput.files.length > 0
                ? fileInput.files[0].name
                : 'Browse... No file selected.';
        }

        function openApproveModal(userId,userName, requestId, goldAmount, amount, bank) {
            
            document.getElementById('approveUserName').textContent = userName;
            document.getElementById('approveRequestId').textContent = requestId;
            document.getElementById('approveGoldAmount').textContent = goldAmount + ' Coin';
            document.getElementById('approveAmount').textContent = 'MMK' + amount.toLocaleString();
            document.getElementById('approveBank').textContent = bank;
            currentRequestId = requestId;
            currentUserId = userId;
            document.getElementById('approveModal').style.display = 'flex';
            
            
        }

        function openRejectModal(userId,userName, requestId, goldAmount, amount) {
            document.getElementById('rejectUserName').textContent = userName;
            document.getElementById('rejectRequestId').textContent = requestId;
            document.getElementById('rejectGoldAmount').textContent = goldAmount + ' $';
            document.getElementById('rejectAmount').textContent = 'MMK' + amount.toLocaleString();
            currentRequestId = requestId;
            currentUserId = userId;
            document.getElementById('rejectModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // === APPROVE & REJECT ===
        function approveRequest() {

            const transactionId = document.getElementById('transactionId').value;
            const proofFile = document.getElementById('proofFile').files[0];
            if (!transactionId) return alert('Please enter a transaction ID');
            if (!proofFile) return alert('Please upload a proof image');
            const fileType = proofFile.type;

            // 3. Check if the type is an image MIME type
            if (fileType.startsWith('image/')) {
                // Update the status in requestsData
                requestsData[currentRequestId].status = 'approved';
            
                // Update the DOM
                updateRequestsDOM();
            
                // Restore current page after update
                filterRequests(false);
                var update_status= "approve";
                var reason= "0";
                var user_id = currentUserId;
                var amount = document.getElementById('approveGoldAmount').textContent;
                var total = document.getElementById('approveAmount').textContent;
                var userData = {
                    transaction_id : currentRequestId,
                    user_id: user_id,
                    transaction_status : update_status,
                    amount : amount,
                    note:reason,
                    reference_id: transactionId,
                    image_name: proofFile.name
                };

                fetch('withdraw_page_admin_data.php', {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData),
                })
                closeModal('approveModal');
                alert(`Request ${currentRequestId} approved successfully!`);
                alert(proofFile.name);
            } else {
                return alert('The file is NOT an image. Type:');
            }

            
        }

        function rejectRequest() {
            const reason = document.getElementById('rejectReason').value;
            if (!reason) return alert('Please enter a reason for rejection');

            // Update the status in requestsData
            requestsData[currentRequestId].status = 'rejected';
            
            // Update the DOM
            updateRequestsDOM();
            
            // Restore current page after update
            filterRequests(false);
            var update_status= "reject";
            
            var user_id = currentUserId;
            var amount = document.getElementById('rejectGoldAmount').textContent;
            var total = document.getElementById('rejectAmount').textContent;
            var userData = {
                    transaction_id : currentRequestId,
                    user_id: user_id,
                    transaction_status : update_status,
                    amount : amount,
                    total:total,
                    note:reason,
                    reference_id: "",
                    image_name:""
                };

            fetch('withdraw_page_admin_data.php', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData),
            })
            closeModal('rejectModal');
            alert(`Request ${currentRequestId} rejected.\nReason: ${reason}`);
        }

        // === INIT ===
        document.addEventListener('DOMContentLoaded', () => {
            initializeRequestsData();
            filterRequests();
            
            // Start auto-refresh
            startAutoRefresh();
        });
    </script>
</body>
</html>
<?php include('footer.php'); ?>
