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

   /* Highlight CSS for history page - Show only on status badge */
.transaction-highlight .badge {
    animation: highlightFlash 1.5s ease-out 1; 
    border: 3px solid #ffb300 !important;
    background: #fff9e6 !important;
    color: #b26a00 !important;
}

@keyframes highlightFlash {
    0% { 
        border: 3px solid #ffb300 !important;
        background: #fff9e6 !important;
        box-shadow: 0 0 10px #ffe082;
    }
    50% { 
        border: 3px solid #ffb300 !important;
        background: #fff9e6 !important;
        box-shadow: none;
    }
    100% { 
        border: 1.5px solid #2e7d32 !important; /* Completed border color */
        background: #eafaf1 !important; /* Completed background */
        color: #2e7d32 !important; /* Completed text color */
    }
}

/* For rejected status */
.transaction-highlight .badge[style*="color:#d32f2f"] {
    animation: highlightFlashRejected 1.5s ease-out 1; 
}

@keyframes highlightFlashRejected {
    0% { 
        border: 3px solid #ffb300 !important;
        background: #fff9e6 !important;
        box-shadow: 0 0 10px #ffe082;
    }
    50% { 
        border: 3px solid #ffb300 !important;
        background: #fff9e6 !important;
        box-shadow: none;
    }
    100% { 
        border: 1.5px solid #d32f2f !important; /* Rejected border color */
        background: #ffebee !important; /* Rejected background */
        color: #d32f2f !important; /* Rejected text color */
    }
}

/* Loading indicator */
.loading-indicator {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #219a43;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 8px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.filter-loading {
    position: relative;
}

.filter-loading::after {
    content: '';
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #219a43;
    border-radius: 50%;
    animation: spin 1s linear infinite;
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
			<div class="container py-4" style="max-width: 100vw; margin-top:-32px;">
				<div class="mb-4">
					<h2 class="fw-bold" style="font-family: 'Montserrat', sans-serif; font-size:2rem;">Transaction History</h2>
					<p class="text-muted" style="font-size:1.1rem;">View all your gold investment transactions</p>
				<div class="row mb-4 g-4" style="width:100%;margin-top:6px;">
					<div class="col-md-4">
						<div class="card text-center" style="background: #f8fcf9; border-radius: 16px; border: 1.5px solid rgba(0,0,0,0.10); box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08);">
							<div class="card-body py-4">
								<div class="fw-bold"  id="total-gold-purchased"  style="font-size:2rem; color:#ffb300;">15.75 oz</div>
								<div class="text-muted" style="font-size:1.1rem;">Total Gold Purchased</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card text-center" style="background: #f8fcf9; border-radius: 16px; border: 1.5px solid rgba(0,0,0,0.10); box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08);">
							<div class="card-body py-4">
								<div class="fw-bold"  id="portfolio-value-value" style="font-size:2rem; color:#2e7d32;">$42,174.38</div>
								<div class="text-muted" style="font-size:1.1rem;">Total Invested</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card text-center" style="background: #f8fcf9; border-radius: 16px; border: 1.5px solid rgba(0,0,0,0.10); box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08);">
							<div class="card-body py-4">
								<div class="fw-bold" id="total-transactions-count"  style="font-size:2rem; color:#222;">12</div>
								<div class="text-muted" style="font-size:1.1rem;">Total Transactions</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			<div class="card mb-4" style="background: #f8fcf9; border-radius: 16px; border: 1.5px solid rgba(0,0,0,0.18); box-shadow: 0 4px 24px 0 rgba(0,0,0,0.12); backdrop-filter: blur(2px);">
				<div class="card-body" style="padding:2rem;">
					<h5 class="mb-3 fw-semibold" style="font-size:1.25rem;">Filter Transactions</h5>
					<div class="row g-3 align-items-center">
						<div class="col-md-4">
							<input type="text" id="searchId" class="form-control" placeholder="Search Reference Number" style="border-radius:10px;">
						</div>
						<div class="col-md-4">
							<select id="transactionType" class="form-select" style="border-radius:10px;">
                                <option value="" selected> Transaction Types</option>
                                <option value="all" >All </option>
                                <option value="Gold Purchase">Gold Purchase</option>
                                <option value="Gold Sell">Gold Sell</option>
                                <option value="Account Recharge">Account Recharge</option>
                                <option value="Withdrawal Request">Withdrawal Request</option>
                            </select>
						</div>
						<div class="col-md-4">
							<select id="statusFilter" class="form-select" style="border-radius:10px;">
								<option value="" selected>Transaction Status</option>
								<option value="all" >All</option>

								<option value="Completed">Completed</option>
								<option value="Rejected">Rejected</option>
							</select>
						</div>
					</div>
				</div>
			</div>			
				<div class="card" style="background: #f8fcf9; border-radius: 16px; border: 1.5px solid rgba(0,0,0,0.18); box-shadow: 0 4px 24px 0 rgba(0,0,0,0.12); backdrop-filter: blur(2px);">
					<div class="card-body" style="padding:2rem;">
						<h5 class="mb-3 fw-semibold" style="font-size:1.25rem;" id="title">Recent Transactions</h5>
						<div id="transaction-list">
							<!-- Transactions will be loaded here by JavaScript -->
						</div>
					</div>
				</div>

			</div>
		</main>
	</div>
</div>

<script>
 function fetchAndDisplayPortfolioValue() {
        fetch('dashboard_user_db_sql.php?portfolio_value=true')
            .then(response => response.json())
            .then(data => {
                const portfolioElement = document.getElementById('portfolio-value-value');
                if (data.portfolio_value !== undefined) {
                    // Format the value as currency (e.g., $1,520.00)
                    const formattedValue = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(data.portfolio_value);
                    portfolioElement.textContent = formattedValue;
                } else {
                    portfolioElement.textContent = '$--,--';
                }
            })
            .catch(error => {
                console.error('Error fetching portfolio value:', error);
                document.getElementById('portfolio-value-value').textContent = '$--,--';
            });
    }

	function fetchGoldAndTransactionCount() {
    const goldElement = document.getElementById('total-gold-purchased');
    const countElement = document.getElementById('total-transactions-count');

    // Set a loading state
    goldElement.textContent = '... Kyatha';
    countElement.textContent = '...';

    // Use the fetch API to call the new PHP file
    fetch('history(user)_sql.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('PHP Error:', data.error);
                goldElement.textContent = '-- Kyatha';
                countElement.textContent = '--';
                return;
            }
            
            // 1. Update Total Gold Purchased (formatted to 2 decimal places)
            const formattedGold = (data.total_gold_purchased !== undefined) ? 
                                   parseFloat(data.total_gold_purchased).toFixed(2) : '0.00';
            goldElement.textContent = formattedGold + ' Kyatha';

            // 2. Update Total Transactions
            countElement.textContent = data.total_transactions;
        })
        .catch(error => {
            console.error('Error fetching history stats:', error);
            goldElement.textContent = 'Error Kyatha';
            countElement.textContent = 'Error';
        });
}

function loadRecentTransactions() {
    fetch('get_recent_transactions.php')
        .then(response => response.json())
        .then(data => {
            const transactionList = document.getElementById('transaction-list');
            
            if (data.error) {
                transactionList.innerHTML = `<div class="text-center text-muted p-4">${data.error}</div>`;
                return;
            }
            
            if (data.transactions.length === 0) {
                transactionList.innerHTML = '<div class="text-center text-muted p-4">No transactions found</div>';
                return;
            }
            
            let html = '<ul class="list-group list-group-flush">';
            
            data.transactions.forEach(transaction => {
                // Determine transaction type display text and icon
                let typeDisplay = '';
                let icon = '';
                let iconStyle = '';
                
                if (transaction.transaction_type === 'gold purchase') {
                    typeDisplay = 'Gold Purchase';
                    icon = 'dollar-sign';
                    iconStyle = 'background:#fff7e6;color:#a67c00;';
                } else if (transaction.transaction_type === 'sell gold') {
                    typeDisplay = 'Gold Sell';
                    icon = 'trending-down';
                    iconStyle = 'background:#fff0f0;color:#d32f2f;';
                } else if (transaction.transaction_type === 'deposit') {
                    typeDisplay = 'Account Recharge';
                    icon = 'plus-circle';
                    iconStyle = 'background:#e6f7ff;color:#0066cc;';
                } else if (transaction.transaction_type === 'withdraw') {
                    typeDisplay = 'Withdrawal Request';
                    icon = 'arrow-up-circle';
                    iconStyle = 'background:#fff0f0;color:#cc0000;';
                } else {
                    typeDisplay = transaction.transaction_type;
                    icon = 'dollar-sign';
                    iconStyle = 'background:#f0f0f0;color:#666;';
                }
                
                // Format amount based on transaction type
                let amountDisplay = '';
                if (transaction.transaction_type === 'gold purchase' || transaction.transaction_type === 'sell gold') {
                    amountDisplay = `${parseFloat(transaction.amount).toFixed(2)} Kyatha`;
                } else if (transaction.transaction_type === 'deposit' || transaction.transaction_type === 'withdraw') {
                    amountDisplay = `${parseFloat(transaction.amount).toFixed(2)} MMK`;
                } else {
                    amountDisplay = `${parseFloat(transaction.amount).toFixed(2)}`;
                }
                
                // Format price based on transaction type
                let priceDisplay = '';
                if (transaction.transaction_type === 'gold purchase' || transaction.transaction_type === 'sell gold') {
                    priceDisplay = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(transaction.price);
                } else {
                    priceDisplay = new Intl.NumberFormat('en-US').format(transaction.price) + ' MMK';
                }
                
                // Calculate and format total value
                const totalValue = transaction.amount * transaction.price;
                let totalDisplay = '';
                
                if (transaction.transaction_type === 'gold purchase' || transaction.transaction_type === 'sell gold') {
                    totalDisplay = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(totalValue);
                } else {
                    totalDisplay = new Intl.NumberFormat('en-US').format(totalValue) + ' MMK';
                }
                
                // Format date
                const transactionDate = new Date(transaction.date);
                const formattedDate = transactionDate.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                
                // Determine status badge style
                let statusBadge = '';
                if (transaction.transaction_status === 'approved') {
                    statusBadge = `<span class="badge" style="font-size:1rem; border-radius:999px; border:1.5px solid #2e7d32; color:#2e7d32; background: #eafaf1; padding:0.45em 1.2em; font-weight:500;">Completed</span>`;
                } else if (transaction.transaction_status === 'rejected') {
                    statusBadge = `<span class="badge" style="font-size:1rem; border-radius:999px; border:1.5px solid #d32f2f; color:#d32f2f; background: #ffebee; padding:0.45em 1.2em; font-weight:500;">Rejected</span>`;
                } else {
                    statusBadge = `<span class="badge" style="font-size:1rem; border-radius:999px; border:1.5px solid #ff9800; color:#ff9800; background: #fff3e0; padding:0.45em 1.2em; font-weight:500;">${transaction.transaction_status}</span>`;
                }
                
                html += `
                <li class="list-group-item" style="background: transparent; border:none; padding:1.2rem 0;" data-transaction-id="${transaction.transaction_id}">
                    <div class="d-flex align-items-center" style="width:100%;">
                        <div class="d-flex align-items-center gap-3" style="flex:1;">
                            <span class="bg-light rounded-circle p-2" style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;">
                                <i data-feather="${icon}" class="text-warning"></i>
                            </span>
                            <div>
                                <div class="fw-semibold" style="font-size:1.1rem;">${typeDisplay} - ${amountDisplay}</div>
                                <div class="text-muted small">
                                    <span>Transaction ID • ${transaction.reference_number || 'N/A'}</span>
                                    <span class="mx-2">|</span>
                                    <span>Unit Price: ${priceDisplay}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2" style="margin-left:auto;">
                            <div class="text-end me-3">
                                <div class="fw-bold" style="color: #ffb300; font-size:1.1rem;">${totalDisplay}</div>
                                <small class="text-muted">${formattedDate}</small>
                            </div>
                            ${statusBadge}
                        </div>
                    </div>
                </li>
                `;
            });
            
            html += '</ul>';
            transactionList.innerHTML = html;
            
            // Refresh Feather icons
            feather.replace();

            handleUrlHighlight();

        })
        .catch(error => {
            console.error('Error loading transactions:', error);
            document.getElementById('transaction-list').innerHTML = '<div class="text-center text-muted p-4">Error loading transactions</div>';
        });
}


function applyTransactionHighlight(transactionId) {
    const transactionItem = document.querySelector(`.list-group-item[data-transaction-id="${transactionId}"]`);
    
    if (transactionItem && !sessionStorage.getItem(`highlighted_${transactionId}`)) {
        // Add highlight class only to the status badge area
        transactionItem.classList.add('transaction-highlight');
        
        // Scroll to the highlighted transaction
        transactionItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Mark as highlighted in sessionStorage to prevent showing again
        sessionStorage.setItem(`highlighted_${transactionId}`, 'true');
        
        // Remove highlight after 3 seconds
        setTimeout(() => {
            transactionItem.classList.remove('transaction-highlight');
        }, 3000);
        
        return true;
    }
    return false;
}

// Function to handle URL parameters and apply highlights
function handleUrlHighlight() {
    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight_id');
    const markRead = urlParams.get('mark_read');
    
    if (highlightId) {
        // Clear the URL parameters to prevent showing again on refresh
        const cleanUrl = window.location.pathname;
        history.replaceState(null, '', cleanUrl);
        
        // Try to apply highlight immediately
        const highlighted = applyTransactionHighlight(highlightId);
        
        // If transaction not found in current list, wait for transactions to load
        if (!highlighted) {
            // Wait for transactions to load and try again
            setTimeout(() => {
                applyTransactionHighlight(highlightId);
            }, 1000);
        }
        
        // Mark as read if parameter is present
        if (markRead === 'true') {
            markSpecificNotificationAsRead(highlightId);
        }
    }
}

// Function to clear all highlights from sessionStorage when leaving the page
function clearHighlightFlags() {
    // Get all keys from sessionStorage that start with 'highlighted_'
    Object.keys(sessionStorage).forEach(key => {
        if (key.startsWith('highlighted_')) {
            sessionStorage.removeItem(key);
        }
    });
}
// Function to mark a specific notification as read
function markSpecificNotificationAsRead(transactionId) {
    fetch('mark_as_read.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `transaction_id=${transactionId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(`Notification for transaction ${transactionId} marked as read`);
            // Refresh notification badge count
            fetchAndDisplayNotifications();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

	



function displayTransactions(transactions) {
    const transactionList = document.getElementById('transaction-list');
    
    if (transactions.length === 0) {
        transactionList.innerHTML = '<div class="text-center text-muted p-4">No transactions found</div>';
        return;
    }
    
    let html = '<ul class="list-group list-group-flush">';
    
    transactions.forEach(transaction => {
        // Determine transaction type display text and icon
        let typeDisplay = '';
        let icon = '';
        let iconStyle = '';
        
        if (transaction.transaction_type === 'gold purchase') {
            typeDisplay = 'Gold Purchase';
            icon = 'dollar-sign';
            iconStyle = 'background:#fff7e6;color:#a67c00;';
        } else if (transaction.transaction_type === 'sell gold') {
            typeDisplay = 'Gold Sell';
            icon = 'trending-down';
            iconStyle = 'background:#fff0f0;color:#d32f2f;';
        } else if (transaction.transaction_type === 'deposit') {
            typeDisplay = 'Account Recharge';
            icon = 'plus-circle';
            iconStyle = 'background:#e6f7ff;color:#0066cc;';
        } else if (transaction.transaction_type === 'withdraw') {
            typeDisplay = 'Withdrawal Request';
            icon = 'arrow-up-circle';
            iconStyle = 'background:#fff0f0;color:#cc0000;';
        } else {
            typeDisplay = transaction.transaction_type;
            icon = 'dollar-sign';
            iconStyle = 'background:#f0f0f0;color:#666;';
        }
        
        // Format amount based on transaction type
        let amountDisplay = '';
        if (transaction.transaction_type === 'gold purchase' || transaction.transaction_type === 'sell gold') {
            amountDisplay = `${parseFloat(transaction.amount).toFixed(2)} Kyatha`;
        } else if (transaction.transaction_type === 'deposit' || transaction.transaction_type === 'withdraw') {
            amountDisplay = `${parseFloat(transaction.amount).toFixed(2)} MMK`;
        } else {
            amountDisplay = `${parseFloat(transaction.amount).toFixed(2)}`;
        }
        
        // Format price based on transaction type
        let priceDisplay = '';
        if (transaction.transaction_type === 'gold purchase' || transaction.transaction_type === 'sell gold') {
            priceDisplay = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'MMK',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(transaction.price);
        } else {
            priceDisplay = new Intl.NumberFormat('en-US').format(transaction.price) + ' MMK';
        }
        
        // Calculate and format total value
        const totalValue = transaction.amount * transaction.price;
        let totalDisplay = '';
        
        if (transaction.transaction_type === 'gold purchase' || transaction.transaction_type === 'sell gold') {
            totalDisplay = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'MMK',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(totalValue);
        } else {
            totalDisplay = new Intl.NumberFormat('en-US').format(totalValue) + ' MMK';
        }
        
        // Format date
        const transactionDate = new Date(transaction.date);
        const formattedDate = transactionDate.toLocaleDateString('en-US', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        // Determine status badge style - ONLY approved and rejected
        let statusBadge = '';
        if (transaction.transaction_status === 'approved') {
            statusBadge = `<span class="badge" style="font-size:1rem; border-radius:999px; border:1.5px solid #2e7d32; color:#2e7d32; background: #eafaf1; padding:0.45em 1.2em; font-weight:500;">Completed</span>`;
        } else if (transaction.transaction_status === 'rejected') {
            statusBadge = `<span class="badge" style="font-size:1rem; border-radius:999px; border:1.5px solid #d32f2f; color:#d32f2f; background: #ffebee; padding:0.45em 1.2em; font-weight:500;">Rejected</span>`;
        }
        
        html += `
        <li class="list-group-item" style="background: transparent; border:none; padding:1.2rem 0;" data-transaction-id="${transaction.transaction_id}">
            <div class="d-flex align-items-center" style="width:100%;">
                <div class="d-flex align-items-center gap-3" style="flex:1;">
                    <span class="bg-light rounded-circle p-2" style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;${iconStyle}">
                        <i data-feather="${icon}"></i>
                    </span>
                    <div>
                        <div class="fw-semibold" style="font-size:1.1rem;">${typeDisplay} - ${amountDisplay}</div>
                        <div class="text-muted small">
                            <span>Transaction ID • ${transaction.transaction_id}</span>
                            <span class="mx-2">|</span>
                            <span>Ref: ${transaction.reference_number || 'N/A'}</span>
                            <span class="mx-2">|</span>
                            <span>Unit Price: ${priceDisplay}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2" style="margin-left:auto;">
                    <div class="text-end me-3">
                        <div class="fw-bold" style="color: #ffb300; font-size:1.1rem;">${totalDisplay}</div>
                        <small class="text-muted">${formattedDate}</small>
                    </div>
                    ${statusBadge}
                </div>
            </div>
        </li>
        `;
    });
    
    html += '</ul>';
    transactionList.innerHTML = html;
    
    // Refresh Feather icons
    feather.replace();
    handleUrlHighlight();
}

function updatePagination(pagination) {
    const paginationContainer = document.getElementById('pagination-container');
    if (!paginationContainer) {
        // Create pagination container if it doesn't exist
        const transactionList = document.getElementById('transaction-list');
        const paginationHTML = `
            <div id="pagination-container" class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing ${((pagination.current_page - 1) * 6) + 1} to ${Math.min(pagination.current_page * 6, pagination.total_count)} of ${pagination.total_count} transactions
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item ${!pagination.has_previous ? 'disabled' : ''}">
                            <a class="page-link" href="#" onclick="changePage(${pagination.current_page - 1})" style="border-radius:8px; margin:0 4px;">Previous</a>
                        </li>
                        ${Array.from({length: Math.min(5, pagination.total_pages)}, (_, i) => {
                            const pageNum = i + 1;
                            return `
                                <li class="page-item ${pageNum === pagination.current_page ? 'active' : ''}">
                                    <a class="page-link" href="#" onclick="changePage(${pageNum})" style="border-radius:8px; margin:0 2px;">${pageNum}</a>
                                </li>
                            `;
                        }).join('')}
                        <li class="page-item ${!pagination.has_next ? 'disabled' : ''}">
                            <a class="page-link" href="#" onclick="changePage(${pagination.current_page + 1})" style="border-radius:8px; margin:0 4px;">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        `;
        transactionList.insertAdjacentHTML('afterend', paginationHTML);
    } else {
        // Update existing pagination
        paginationContainer.innerHTML = `
            <div class="text-muted">
                Showing ${((pagination.current_page - 1) * 6) + 1} to ${Math.min(pagination.current_page * 6, pagination.total_count)} of ${pagination.total_count} transactions
            </div>
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item ${!pagination.has_previous ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="changePage(${pagination.current_page - 1})" style="border-radius:8px; margin:0 4px;">Previous</a>
                    </li>
                    ${Array.from({length: Math.min(5, pagination.total_pages)}, (_, i) => {
                        const pageNum = i + 1;
                        return `
                            <li class="page-item ${pageNum === pagination.current_page ? 'active' : ''}">
                                <a class="page-link" href="#" onclick="changePage(${pageNum})" style="border-radius:8px; margin:0 2px;">${pageNum}</a>
                            </li>
                        `;
                    }).join('')}
                    <li class="page-item ${!pagination.has_next ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="changePage(${pagination.current_page + 1})" style="border-radius:8px; margin:0 4px;">Next</a>
                    </li>
                </ul>
            </nav>
        `;
    }
}
function removePagination() {
    const paginationContainer = document.getElementById('pagination-container');
    if (paginationContainer) {
        paginationContainer.remove();
    }
}

function changePage(page) {
    currentPage = page;
    loadFilteredTransactions(page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Remove the duplicate declarations and keep only this one
let currentPage = 1;
let currentFilters = {
    search_id: '',
    transaction_type: '',  // Empty string for default
    status: ''             // Empty string for default
};

let filterTimeout;

// Auto-filter function with debounce
function applyAutoFilter() {
    // Clear previous timeout
    clearTimeout(filterTimeout);
    
    // Add loading state to filter inputs
    const inputs = [
        document.getElementById('searchId'),
        document.getElementById('transactionType'),
        document.getElementById('statusFilter')
    ];
    
    inputs.forEach(input => {
        input.classList.add('filter-loading');
    });
    
    // Set new timeout (300ms delay for better UX)
    filterTimeout = setTimeout(() => {
        const searchId = document.getElementById('searchId').value.trim();
        const transactionType = document.getElementById('transactionType').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        // Set filters
        currentFilters = {
            search_id: searchId,
            transaction_type: transactionType,
            status: statusFilter
        };
        
        currentPage = 1;
        loadFilteredTransactions(currentPage);
        
        // Remove loading state
        inputs.forEach(input => {
            input.classList.remove('filter-loading');
        });
    }, 300);
}

// Update the title function
function updateTransactionTitle(isFiltered, filterInfo = null) {
    const titleElement = document.getElementById('title');
    if (!titleElement) return;

    const { search_id, transaction_type, status } = currentFilters;
    
    // Check what kind of filter is applied
    const hasSearch = search_id !== '';
    const hasTypeFilter = transaction_type !== '' && transaction_type !== 'all';
    const hasStatusFilter = status !== '' && status !== 'all';
    const hasAllTypes = transaction_type === 'all';
    const hasAllStatus = status === 'all';
    
    // If no filters at all (empty values), show Recent Transactions
    if (!hasSearch && !hasTypeFilter && !hasStatusFilter && !hasAllTypes && !hasAllStatus) {
        titleElement.textContent = 'Recent Transactions';
        return;
    }
    
    let title = 'Transactions';
    
    if (hasSearch) {
        title += ` - Ref: ${search_id}`;
    }
    if (hasTypeFilter) {
        title += ` - ${transaction_type}`;
    } else if (hasAllTypes) {
        title += ' - All Types';
    }
    if (hasStatusFilter) {
        title += ` - ${status}`;
    } else if (hasAllStatus) {
        title += ' - All Status';
    }
    
    titleElement.textContent = title;
}

// Update the loadFilteredTransactions function
function loadFilteredTransactions(page = 1) {
    const transactionList = document.getElementById('transaction-list');
    transactionList.innerHTML = '<div class="text-center text-muted p-4">Loading transactions...</div>';

    const params = new URLSearchParams({
        ...currentFilters,
        page: page
    });

    fetch(`filter_transactions.php?${params}`)
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error(data.error);
            }

            displayTransactions(data.transactions);
            
            // Only show pagination if filtered
            if (data.is_filtered) {
                updatePagination(data.pagination);
            } else {
                removePagination();
            }
            
            // Update title based on filters
            updateTransactionTitle(data.is_filtered, data.filter_info);
        })
        .catch(error => {
            console.error('Error loading transactions:', error);
            transactionList.innerHTML = `<div class="text-center text-muted p-4">Error: ${error.message}</div>`;
        });
}

// Make sure you have the correct PHP file
document.addEventListener('DOMContentLoaded', function() {
    // Initialize with default filters
    loadFilteredTransactions();

    // Auto-filter event listeners
    document.getElementById('searchId').addEventListener('input', applyAutoFilter);
    document.getElementById('transactionType').addEventListener('change', applyAutoFilter);
    document.getElementById('statusFilter').addEventListener('change', applyAutoFilter);

    fetchAndDisplayPortfolioValue();
    fetchGoldAndTransactionCount(); 

    setInterval(() => {
        fetchAndDisplayPortfolioValue();
        fetchGoldAndTransactionCount();
    }, 5000);
});
// Clear highlights when user leaves the page (optional)

window.addEventListener('beforeunload', clearHighlightFlags);
</script>

<?php include 'footer.php'; ?>
