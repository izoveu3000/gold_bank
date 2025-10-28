<?php 

include('user_page_admin_data.php');

$_SESSION['unique_id'] = 1;
$extra_css = '../assets/css/dashboard(admin).css';
include('header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold User Management</title>
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
            padding: 0; /* remove outer page padding so content can reach edges */
        }

        /* Make the main container full-width so there's no blank space at the sides */
        .container {
            width: 100vw;
            max-width: 100vw;
            background: white;
            border-radius: 0; /* full-width typically doesn't need rounded corners */
            box-shadow: none; /* remove outer shadow to avoid horizontal overflow artifacts */
            overflow: hidden;
            padding: 20px 24px; /* keep inner spacing */
            box-sizing: border-box;
        }
        
        .header {
            background: linear-gradient(90deg, #bf953f 0%, #fcf6ba 33%, #b38728 66%, #fbf5b7 100%);
            color: #333;
            padding: 25px 30px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        
        .titles h1 {
            font-weight: 700;
            font-size: 32px;
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.5);
        }
        
        .titles h2 {
            color: #5a4a21;
            font-weight: 500;
            font-size: 20px;
            margin-top: 5px;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 8px 15px;
            width: 350px;
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
        
        .user-table-container {
            overflow-x: auto;
            padding: 20px;
        }
        
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .user-table th {
            background: linear-gradient(to bottom, #bf953f 0%, #b38728 100%);
            color: white;
            text-align: left;
            padding: 18px;
            font-weight: 600;
            font-size: 16px;
            position: sticky;
            top: 0;
        }
        
        .user-table td {
            padding: 18px;
            border-bottom: 1px solid #e1e4e8;
            font-size: 16px;
        }
        
        .user-table tr:nth-child(even) {
            background-color: #fffbf0;
        }
        
        .user-table tr:hover {
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
        
        .user-email {
            color: #7f8c8d;
            font-size: 15px;
        }
        
        .gold {
            color: #b38728;
            font-weight: 600;
        }
        
        .money {
            color: #27ae60;
            font-weight: 600;
        }
        
        .status {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-offline {
            background-color: #ffecb3;
            color: #f57c00;
        }
        
        .actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-view {
            background-color: #3498db;
            color: white;
        }
        
        .btn-view:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        /* .btn-message {
            background-color: #b38728;
            color: white;
        }*/
        
        .btn-message:hover {
            background-color: #9c7424;
            transform: translateY(-2px);
        } 
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .user-table {
                min-width: 1000px;
            }
        }
        
        @media (max-width: 992px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-bar {
                width: 100%;
                margin-top: 15px;
            }
            
            .user-table {
                min-width: 900px;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                padding: 20px;
            }
            
            .titles h1 {
                font-size: 28px;
            }
            
            .titles h2 {
                font-size: 18px;
            }
            
            .user-table th,
            .user-table td {
                padding: 12px 10px;
                font-size: 14px;
            }
            
            .btn-action {
                padding: 6px 10px;
                font-size: 13px;
            }
            
            .user-table {
                min-width: 800px;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            
            .container {
                border-radius: 10px;
            }
            
            .header {
                padding: 15px;
            }
            
            .user-table-container {
                padding: 10px;
            }
            
            .user-table {
                min-width: 700px;
            }
        }
        
        .table-scroll-info {
            text-align: center;
            padding: 10px;
            color: #7f8c8d;
            font-style: italic;
            display: none;
        }
        
        @media (max-width: 992px) {
            .table-scroll-info {
                display: block;
            }
        }
        
        .stats-bar {
            display: flex;
            justify-content: space-around;
            background: #f8f5e6;
            padding: 15px;
            border-bottom: 1px solid #e1dcc1;
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
    <style>
        /* --- Your Existing CSS --- */
        /* Add pagination styling */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 15px 0;
            gap: 10px;
        }
        .pagination-button {
            padding: 8px 14px;
            border-radius: 6px;
            border: 1px solid #d4af37;
            background: white;
            color: #5a4a21;
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s ease;
        }
        .pagination-button:hover {
            background: #b38728;
            color: white;
        }
        .pagination-button.active {
            background: #b38728;
            color: white;
            font-weight: 700;
        }

    </style>
    <style>
        .status-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-left: 8px;
        }

        .status-dot.online {
            background-color: #00c853;
        }

        .status-dot.offline {
            background-color: #ccc;
        }
        .btn-message {
    background-color: #b38728;
    color: white;
    position: relative;       /* ← anchor for absolute badge */
    padding: 8px 20px 8px 14px; /* add right padding so badge doesn't overlap text */
    overflow: visible;        /* usually default, but keep it explicit */
}

.unread-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    z-index: 10;
    background-color: #ff4757;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    line-height: 1;
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
            <div class="header-content">
                <div class="titles">
                    <h1>Gold User Management</h1>
                    <h2>Manage user accounts and balances</h2>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search users by name or email...">
                </div>
            </div>
        </div>

        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value" id="totalUsers"><?php echo $total_users; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="totalGold"><?php echo $total_gold; ?> oz</div>
                <div class="stat-label">Total Gold</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="totalMoney"><?php echo $total_dollars; ?></div>
                <div class="stat-label">Total Money</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="activeUsers"><?php echo $total_active;?></div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>

        <div class="table-scroll-info">
            <i class="fas fa-info-circle"></i> Scroll horizontally to view all table content
        </div>

        <div class="user-table-container">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Gold (kt)</th>
                        <th>Money (coin)</th>
                        <th>Status</th>
                        <th>Last Active</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    
                </tbody>
            </table>

            <div class="pagination"></div>
        </div>
    </div>

<script>
const rowsPerPage = 10;
let currentPage = 1;
const searchInput = document.getElementById('searchInput');
const tableBody = document.getElementById('userTableBody');

function getFilteredRows() {
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const searchText = searchInput.value.toLowerCase();

    return rows.filter(row => {
        const name = row.querySelector('.user-name').textContent.toLowerCase();
        const email = row.querySelector('.user-email').textContent.toLowerCase();
        const parts = email.split('@');
        const user_name_email = parts[0];
        return name.includes(searchText) || user_name_email.includes(searchText);
    });
}

function showPage(page) {
    const filteredRows = getFilteredRows();
    const totalRows = filteredRows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

    if (page < 1) page = 1;
    if (page > totalPages) page = totalPages;
    currentPage = page;

    const allRows = Array.from(tableBody.querySelectorAll('tr'));
    allRows.forEach(row => row.style.display = 'none');

    const start = (page - 1) * rowsPerPage;
    const end = page * rowsPerPage;
    filteredRows.slice(start, end).forEach(row => row.style.display = '');

    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const paginationDiv = document.querySelector('.pagination');
    paginationDiv.innerHTML = '';

    if (totalPages <= 1) return;

    const prev = document.createElement('button');
    prev.classList.add('pagination-button');
    prev.innerText = '«';
    prev.disabled = currentPage === 1;
    prev.addEventListener('click', () => showPage(currentPage - 1));
    paginationDiv.appendChild(prev);

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.classList.add('pagination-button');
        if (i === currentPage) btn.classList.add('active');
        btn.innerText = i;
        btn.addEventListener('click', () => showPage(i));
        paginationDiv.appendChild(btn);
    }

    const next = document.createElement('button');
    next.classList.add('pagination-button');
    next.innerText = '»';
    next.disabled = currentPage === totalPages;
    next.addEventListener('click', () => showPage(currentPage + 1));
    paginationDiv.appendChild(next);
}

// Search Listener
searchInput.addEventListener('keyup', () => showPage(1));
// Add event listeners to buttons
        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', function() {
                const userName = this.closest('tr').querySelector('.user-name').textContent;
                alert(`View details for ${userName}`);
            });
        });
        
        // document.querySelectorAll('.btn-message').forEach(button => {
        //     button.addEventListener('click', function() {
        //         const user_id = this.closest('tr').querySelector('.user-id').textContent;

               
        //         window.location.href = `user_chat.php?user_id=${user_id}`;
        //     });
        // });
        document.querySelectorAll('.btn-message').forEach(button => {
    button.addEventListener('click', function() {
        const user_id = this.closest('tr').querySelector('.user-id').textContent;

        // ✅ Create and submit hidden form (POST)
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'user_chat.php';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'user_id';
        input.value = user_id;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    });
});
document.querySelectorAll('.btn-view').forEach(button => {
    button.addEventListener('click', function() {
        const user_id = this.closest('tr').querySelector('.user-id').textContent;

        // ✅ Create and submit hidden form (POST)
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'user_details(admin).php';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'user_id';
        input.value = user_id;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    });
});



function refreshTable() {
    fetch('get_user_page_admin_data.php')
        .then(res => res.json())
        .then(users => {
            tableBody.innerHTML = '';

            users.forEach(user => {
                const row = document.createElement('tr');

                

                // ✅ Handle unread_count in JavaScript
                let unreadBadge = '';
                if (user.unread_count && user.unread_count > 0) {
                    unreadBadge = `<span class="unread-badge">${user.unread_count}</span>`;
                }

                row.innerHTML = `
                    <td>
                        <div class="user-info">
                            <span class="user-id" style="display:none;">${user.user_id}</span>
                            <span class="user-name">${user.user_name}<span class="status-dot ${user.status_dot}"></span></span>
                            <span class="user-email">${user.email}</span>
                        </div>
                    </td>
                    <td class="gold">${user.actual_gold_amount} kt</td>
                    <td class="money">${user.actual_coin_amount} coin</td>
                    <td><span class="status ${user.status_class}">${user.status}</span></td>
                    <td>${user.last_seen}</td>
                    <td>
                        <div class="actions">
                            <button class="btn-action btn-view">View</button>
                            <button class="btn-action btn-message">Message ${unreadBadge}</button>
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            showPage(currentPage);

            // ✅ Reattach message button listeners after table refresh
            document.querySelectorAll('.btn-message').forEach(button => {
                button.addEventListener('click', function() {
                    const user_id = this.closest('tr').querySelector('.user-id').textContent;
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'user_chat.php';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_id';
                    input.value = user_id;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                });
            });
         document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', function() {
                    const user_id = this.closest('tr').querySelector('.user-id').textContent;
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'user_details(admin).php';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_id';
                    input.value = user_id;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                });
            });
        })
        .catch(err => console.error('Error refreshing table:', err));
}

document.addEventListener('DOMContentLoaded', () => refreshTable());
setInterval(refreshTable, 5000);

</script>
<script>
    function refreshAllData() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Parse the JSON response text into a JavaScript object
                var data = JSON.parse(this.responseText);
                
                // Now, update each data point by its key
                document.getElementById("totalUsers").innerHTML = data.total_users;
                document.getElementById("totalGold").innerHTML = data.total_gold + ' kt';
                document.getElementById("totalMoney").innerHTML = data.total_dollars;
                document.getElementById("activeUsers").innerHTML = data.total_active;
            }
        };
        xhttp.open("GET", "get_user_page_admin_1.php", true);
        xhttp.send();
    }

    // Call the function to refresh all data every 5 seconds
    setInterval(refreshAllData, 5000);
</script>
</body>
</html>
