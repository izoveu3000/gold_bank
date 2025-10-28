<?php include('deposite_page_data.php'); ?>
<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
// tell shared header which page CSS to include (relative to pages/)
$extra_css = '../assets/css/dashboard(admin).css';

include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deposit Request Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/deposite_page(admin).css">

<style>
    /* Pagination styling */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 25px 0;
        gap: 5px;
    }

    .pagination button {
        background-color: #938042ff;
        color: white;
        border: none;
        padding: 8px 12px;
        margin: 5px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .pagination button:hover { background-color: gold; }
    .pagination button.active { background-color: gold; font-weight: bold; }
    .pagination button:disabled { background-color: #ddd; color: #888; cursor: not-allowed; }

    .request-card { display: flex; margin-bottom: 10px; }
    /* Top-gap fixes: ensure page content sits directly under shared header/nav */
    body, html { margin: 0; padding: 0; }
    .dashboard-flex, #content, .header, .header-shiftable { margin-top: 5px !important; padding-top: 0 !important; }
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
<div class="dashboard-flex " style="margin-top: 20px;">
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
        <h1>Deposit Requests</h1>
        <p>Review and manage user deposit requests</p>
    </div>

    <div class="filters">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search by name, ID, or request #..." onkeyup="filterRequests()">
        </div>
    </div>

    <div class="requests-container" id="requestsContainer">
        
    </div>

    <!-- Pagination -->
    <div class="pagination" id="pagination" style="display:none;">
        <button id="prevBtn" onclick="prevPage()">«</button>
        <span id="pageNumbers"></span>
        <button id="nextBtn" onclick="nextPage()">»</button>
    </div>

    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-value" id="totalRequests">0</div>
            <div class="stat-label">Total Requests</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" id="totalAmount">$0.00</div>
            <div class="stat-label">Total Amount(Coin)</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" id="pendingRequests">0</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>
</div>
<!-- Detail Modal -->
    <div class="modal" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Deposit Request Details - <span id="detailRequestId"></span></h2>
            </div>
            <div class="modal-body">
                <div class="modal-info">
                    <div class="info-group">
                        <h3>Request Information</h3>
                        <div class="form-group">
                            <span class="info-label">Request ID</span>
                            <span class="info-value" id="detailId"></span>
                        </div>
                        <div class="form-group">
                            <span class="info-label">User</span>
                            <span class="info-value" id="detailUser"></span>
                        </div>
                        <div class="form-group">
                            <span class="info-label">Amount(Coin)</span>
                            <span class="info-value" id="detailAmount"></span>
                        </div>
                        <div class="form-group">
                            <span class="info-label">Total</span>
                            <span class="info-value" id="detailTotalAmount"></span>
                        </div>
                        <div class="form-group">
                            <span class="info-label">Transaction ID</span>
                            <span class="info-value" id="detailTransactionId"></span>
                        </div>
                        <div class="form-group">
                            <span class="info-label">Submitted</span>
                            <span class="info-value" id="detailSubmitted"></span>
                        </div>
                        <div class="form-group">
                            <span class="info-label">Status</span>
                            <span class="info-value" id="detailStatus"></span>
                        </div>
                    </div>
                    
                    <div class="action-buttons" style="margin-top: 20px; display: flex; gap: 10px;">
                        <button class="action-button approve-button" onclick="approveRequest(currentRequestId)">Approve</button>
                        <button class="action-button warn-button" onclick="openWarnModal(currentRequestId)">Warn User</button>
                        <button class="action-button reject-button" onclick="openRejectModal(currentRequestId)">Reject</button>
                    </div>
                </div>
                
                <div class="modal-proof">
                    <div class="payment-proof">
                        <h3>Payment Proof</h3>
                        <img  alt="Payment proof" id="proofImage">
                        <p class="info-label">Transaction proof submitted by <span id="proofUser"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-button modal-button-secondary" onclick="closeModal('detailModal')">Close</button>
            </div>
        </div>
    </div>
    
    <!-- Warn Modal -->
    <div class="modal compact-modal" id="warnModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Warn User - <span id="warnRequestId"></span></h2>
            </div>
            <div class="modal-body">
                <div class="info-group">
                    <p>Warning user: <strong id="warnUserName"></strong></p>
                    <p>Amount: <strong id="warnAmount"></strong></p>
                </div>
                
                <div class="form-group">
                    <label for="warnMessage">Warning message</label>
                    <textarea id="warnMessage" placeholder="Enter warning message (e.g., incorrect amount, wrong transaction ID format, etc.)"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-button modal-button-secondary" onclick="closeModal('warnModal')">Cancel</button>
                <button class="modal-button modal-button-warning" onclick="sendWarning()">Send Warning</button>
            </div>
        </div>
    </div>
    
    <!-- Reject Modal -->
    <div class="modal compact-modal" id="rejectModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reject Deposit - <span id="rejectRequestId"></span></h2>
            </div>
            <div class="modal-body">
                <div class="info-group">
                    <p>Rejecting deposit for: <strong id="rejectUserName"></strong></p>
                    <p>Amount: <strong id="rejectAmount"></strong></p>
                </div>
                
                <div class="form-group">
                    <label for="rejectReason">Reason for rejection</label>
                    <textarea id="rejectReason" placeholder="Enter reason for rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-button modal-button-secondary" onclick="closeModal('rejectModal')">Cancel</button>
                <button class="modal-button modal-button-danger" onclick="rejectRequest()">Confirm Rejection</button>
            </div>
        </div>
    </div>
    
    <!-- Approve Modal -->
    <div class="modal compact-modal" id="approveModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Approve Deposit - <span id="approveRequestId"></span></h2>
            </div>
            <div class="modal-body">
                <div class="info-group">
                    <p>Approving deposit for: <strong id="approveUserName"></strong></p>
                    <p>Amount: <strong id="approveAmount"></strong></p>
                    <p>Transaction ID: <strong id="approveTransactionId"></strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-button modal-button-secondary" onclick="closeModal('approveModal')">Cancel</button>
                <button class="modal-button modal-button-primary" onclick="confirmApprove()">Confirm Approval</button>
            </div>
        </div>
    </div>
<!-- Modals (Detail, Warn, Reject, Approve) remain unchanged -->

<script>
let requestsData = {};  // current request dataset
let currentPage = 1;
const itemsPerPage = 5;
let searchQuery = '';
let currentRequestId = '';
var request ;

// --- Modal functions ---
function openDetailModal(requestId) {
    request = requestsData[requestId];
    if (!request) return;
    document.getElementById('detailRequestId').textContent = requestId;
    document.getElementById('detailId').textContent = requestId;
    document.getElementById('detailUser').textContent = `${request.user} (ID: ${request.userId})`;
    document.getElementById('detailAmount').textContent = request.amount;
    document.getElementById('detailTotalAmount').textContent = request.total;
    document.getElementById('detailTransactionId').textContent = request.transactionId;
    document.getElementById('detailSubmitted').textContent = request.submitted;
    document.getElementById('detailStatus').textContent = request.status;
    document.getElementById('proofUser').textContent = request.user;
    document.getElementById('proofImage').src = "../users/uploads/"+request.proofImage;
    currentRequestId = requestId;
    document.getElementById('detailModal').style.display = 'flex';
}
function openWarnModal(id){ const r=requestsData[id]; if(!r)return; document.getElementById('warnRequestId').textContent=id; document.getElementById('warnUserName').textContent=r.user; document.getElementById('warnAmount').textContent=r.amount; currentRequestId=id; document.getElementById('warnModal').style.display='flex'; }
function openRejectModal(id){ const r=requestsData[id]; if(!r)return; document.getElementById('rejectRequestId').textContent=id; document.getElementById('rejectUserName').textContent=r.user; document.getElementById('rejectAmount').textContent=r.amount; currentRequestId=id; document.getElementById('rejectModal').style.display='flex'; }
function approveRequest(id){ 
    const r=requestsData[id]; 
    var amount = parseFloat(r.amount.replace(/[^\d.-]/g,'')); ;
    if(!r)return; 
    document.getElementById('approveRequestId').textContent=id; 
    document.getElementById('approveUserName').textContent=r.user; 
    document.getElementById('approveAmount').textContent=r.amount; 
    document.getElementById('approveTransactionId').textContent=r.transactionId; 
    currentRequestId=id; 
    document.getElementById('approveModal').style.display='flex'; }

function closeModal(id){ document.getElementById(id).style.display='none'; }
function sendWarning(){ 
    var note=document.getElementById('warnMessage').value; 
    if(!note){alert('Enter warning message'); return;} 
    alert(`Warning sent for request ${currentRequestId}`);
    var update_status= "warn";
    var user_id = request.userId;
    var amount = request.amount;
    var total = request.total;
    var userData = {
            transaction_id : currentRequestId,
            user_id: user_id,
            transaction_status : update_status,
            amount : amount,
            total:total,
            note:note
          };

          fetch('deposite_page_data.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
          })
    closeModal('warnModal'); 
    closeModal('detailModal'); 
}
function rejectRequest(){ 
    var note=document.getElementById('rejectReason').value; 
    if(!note){alert('Enter reason'); return;} 
    alert(`Request ${currentRequestId} rejected.`); 
    var update_status= "reject";
    var user_id = request.userId;
    var amount = request.amount;
    var total = request.total;
    var userData = {
            transaction_id : currentRequestId,
            user_id: user_id,
            transaction_status : update_status,
            amount : amount,
            total:total,
            note:note
          };

          fetch('deposite_page_data.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
          })
    closeModal('rejectModal'); 
    closeModal('detailModal'); }
function confirmApprove(){ 
    updateCardStatus(currentRequestId,'Approved'); 
    alert(`Request ${request.user} approved.`); 
    var update_status= "approve";
    var note= "0";
    var user_id = request.userId;
    var amount = request.amount;
    var userData = {
            transaction_id : currentRequestId,
            user_id: user_id,
            transaction_status : update_status,
            amount : amount,
            note:note
          };

          fetch('deposite_page_data.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
          })
    closeModal('approveModal'); 
    closeModal('detailModal'); 
}

function updateCardStatus(requestId,status){
    const card=document.getElementById(`card-${requestId}`);
    if(!card) return;
    card.setAttribute('data-status', status.toLowerCase());
    const badge=card.querySelector('.request-status');
    if(badge){ badge.className='request-status status-'+status.toLowerCase(); badge.textContent=status; }
    requestsData[requestId].status=status;
    renderPagination();
}

// --- Filtering & Pagination ---
function getFilteredCards(){
    const container=document.getElementById('requestsContainer');
    return Array.from(container.querySelectorAll('.request-card')).filter(card=>{
        const status=(card.getAttribute('data-status')||'').toLowerCase();
        const text=(card.textContent||'').toLowerCase();
        const statusMatch = true; // show all
        const searchMatch = !searchQuery || text.includes(searchQuery);
        return statusMatch && searchMatch;
    });
}

function renderPagination(){
    const container=document.getElementById('requestsContainer');
    const pagination=document.getElementById('pagination');
    const pageNumbers=document.getElementById('pageNumbers');
    const prevBtn=document.getElementById('prevBtn');
    const nextBtn=document.getElementById('nextBtn');

    const filtered=getFilteredCards();
    const totalItems=filtered.length;
    const totalPages=Math.ceil(totalItems/itemsPerPage)||1;
    if(currentPage>totalPages) currentPage=totalPages;
    if(currentPage<1) currentPage=1;

    container.querySelectorAll('.request-card').forEach(c=>c.style.display='none');
    const start=(currentPage-1)*itemsPerPage;
    const end=Math.min(start+itemsPerPage,totalItems);
    for(let i=start;i<end;i++){ filtered[i].style.display='flex'; }

    if(totalItems<=itemsPerPage){ pagination.style.display='none'; } else { pagination.style.display='flex'; }

    pageNumbers.innerHTML='';
    const maxVisible=5;
    let startPage=Math.max(1,currentPage-Math.floor(maxVisible/2));
    let endPage=Math.min(totalPages,startPage+maxVisible-1);
    if(endPage-startPage<maxVisible-1){ startPage=Math.max(1,endPage-maxVisible+1); }

    for(let i=startPage;i<=endPage;i++){
        const btn=document.createElement('button');
        btn.textContent=i;
        if(i===currentPage) btn.classList.add('active');
        btn.addEventListener('click',()=>{ currentPage=i; renderPagination(); });
        pageNumbers.appendChild(btn);
    }
    prevBtn.style.display=currentPage===1?'none':'inline-block';
    nextBtn.style.display=currentPage===totalPages?'none':'inline-block';

    updateStats(filtered);
}
function prevPage(){ if(currentPage>1){ currentPage--; renderPagination(); } }
function nextPage(){ const filtered=getFilteredCards(); const totalPages=Math.ceil(filtered.length/itemsPerPage); if(currentPage<totalPages){ currentPage++; renderPagination(); } }
function filterRequests(){ searchQuery=document.getElementById('searchInput').value.toLowerCase().trim(); currentPage=1; renderPagination(); }
function updateStats(filtered){
    let pending=0,total=0;
    filtered.forEach(card=>{
        if(card.getAttribute('data-status')==='pending') pending++;
        const amt=parseFloat(card.querySelector('.amount')?.textContent.replace(/[^\d.-]/g,''))||0;
        total+=amt;
    });
    document.getElementById('totalRequests').textContent=filtered.length;
    document.getElementById('pendingRequests').textContent=pending;
    document.getElementById('totalAmount').textContent=total.toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2});
}

// --- Auto-refresh ---
const refreshInterval = 5000; // 10s

async function fetchRequests() {
    try {
        const res = await fetch('get_deposite_page_data.php'); // check file name
        if (!res.ok) throw new Error('Network error');
        const newRequests = await res.json();

        const newIds = new Set(newRequests.map(r => r.transaction_id));
        const oldIds = new Set(Object.keys(requestsData));

        // --- Remove deleted cards ---
        oldIds.forEach(id => {
            if (!newIds.has(id)) {
                const card = document.getElementById(`card-${id}`);
                if (card) card.remove();
                delete requestsData[id];
            }
        });

        // --- Add/update new or changed cards ---
        newRequests.forEach(req => {
            const id = req.transaction_id;
            const status = req.transaction_status.toLowerCase();
            const amount = parseFloat(req.amount).toLocaleString('en-US', { minimumFractionDigits: 2 });
            const total = 'MMK' + parseFloat(req.total).toLocaleString('en-US', { minimumFractionDigits: 2 });
            const data = {
                user: req.user_name,
                userId: req.user_id,
                amount,
                total,
                transactionId: req.reference_number,
                submitted: req.transaction_date,
                status,
                proofImage: req.image
            };

            if (requestsData[id]) {
                // Update card only if something changed
                const card = document.getElementById(`card-${id}`);
                if (!card) return;
                const oldData = requestsData[id];

                if (oldData.status !== status) {
                    const badge = card.querySelector('.request-status');
                    if (badge) {
                        badge.textContent = req.transaction_status;
                        badge.className = 'request-status status-' + status;
                    }
                    card.setAttribute('data-status', status);
                }
                if (oldData.amount !== amount) {
                    const amtElem = card.querySelector('.amount');
                    if (amtElem) amtElem.textContent = amount;
                }
                if (oldData.user !== req.user_name) {
                    const userElem = card.querySelector('.detail-item .detail-value');
                    if (userElem) userElem.textContent = req.user_name;
                }
                requestsData[id] = data; // update reference
            } else {
                // Add new card
                const container = document.getElementById('requestsContainer');
                const card = document.createElement('div');
                card.className = 'request-card';
                card.id = 'card-' + id;
                card.setAttribute('data-status', status);
                card.innerHTML = `
                    <div class="request-content">
                        <div class="request-header">
                            <div class="request-id">${id}</div>
                            <div class="request-status status-${status}">${req.transaction_status}</div>
                        </div>
                        <div class="request-details">
                            <div class="detail-item">
                                <span class="detail-label">User</span>
                                <span class="detail-value">${req.user_name}</span>
                                <span class="detail-label">ID: ${req.user_id}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Amount(Coin)</span>
                                <span class="detail-value amount">${amount}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Transaction ID</span>
                                <span class="detail-value">${req.reference_number}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Submitted</span>
                                <span class="detail-value">${req.transaction_date}</span>
                            </div>
                        </div>
                    </div>
                    <div class="action-section">
                        <div class="action-buttons">
                            <button class="action-button view-button" onclick="openDetailModal('${id}')">View Details</button>
                        </div>
                    </div>
                `;
                
                container.appendChild(card); // newest at top
                requestsData[id] = data;
            }
        });

        renderPagination(); // reapply pagination and stats
    } catch (err) {
        console.error('Auto-refresh error:', err);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    // Initialize requestsData from existing cards
    document.querySelectorAll('.request-card').forEach(card => {
        const id = card.id.replace('card-', '');
        const status = card.getAttribute('data-status') || 'pending';
        const amount = card.querySelector('.amount')?.textContent || '$0';
        const user = card.querySelector('.detail-item .detail-value')?.textContent || '';
        const transactionId = card.querySelector('.detail-item:nth-child(3) .detail-value')?.textContent || '';
        const total = card.querySelector('.total')?.textContent || 'MMK0';
        const submitted = card.querySelector('.submitted')?.textContent || '';
        const proofImage = card.querySelector('.image')?.textContent || '';
        const userId = card.querySelector('.user-id')?.textContent || '';
        requestsData[id] = { user, userId, amount, total, transactionId, submitted, status, proofImage };
    });
    renderPagination();
    setInterval(fetchRequests, refreshInterval);
    fetchRequests();
});

</script>
</body>
</html>
<?php include('footer.php'); ?>


  <style>
    /* Ensure full-width layout for this page */
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
    
  </div>
 	
 <?php include('footer.php'); ?>