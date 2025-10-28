<style>
    /* Your original styles */
    .pending-card.highlight-flash {
    /* Base style for the highlight */
    border-color: #ffe082 !important; /* Yellow border to indicate highlight */
    box-shadow: 0 0 10px 5px rgba(255, 224, 130, 0.7); /* Soft yellow glow */
    animation: flash-border 1.5s 2; /* Run the flash animation twice */
}

@keyframes flash-border {
    0% { border-color: #ffe082; box-shadow: 0 0 10px 5px rgba(255, 224, 130, 0.7); }
    50% { border-color: #dbeedc; box-shadow: 0 2px 16px #e6f4ea; } /* Back to normal */
    100% { border-color: #ffe082; box-shadow: 0 0 10px 5px rgba(255, 224, 130, 0.7); }
}
    .pending-main {
        padding: 12px 0;
    }
    .pending-card.fade-out {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.4s ease, transform 0.4s ease;
    }
    .pending-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a4d2e;
        margin-bottom: 8px;
    }

    .pending-subtitle {
        color: #6c8e6b;
        font-size: 1.15rem;
        margin-bottom: 32px;
    }

    .pending-card {
        background: linear-gradient(135deg, #f8fcf7 95%, #e6f4ea 100%);
        border-radius: 16px;
        box-shadow: 0 2px 16px #e6f4ea;
        border: 1.5px solid #dbeedc;
        padding: 24px 24px 16px 24px;
        margin-bottom: 24px;
        position: relative;
    }

    .pending-badge {
        background: #ffe082;
        color: #a67c00;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 8px;
        padding: 2px 12px;
        margin-left: 8px;
    }


    .pending-icon {
        background: #eaf6ee;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #219a43;
        position: absolute;
        left: 24px;
        top: 24px;
    }

    .pending-actions {
        position: absolute;
        right: 24px;
        top: 24px;
        display: flex;
        gap: 12px;
    }

    .pending-edit {
        background: #fff;
        color: #219a43;
        border: 1px solid #e6f4ea;
        border-radius: 6px;
        padding: 6px 18px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pending-cancel {
        background: #f44336;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 6px 18px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pending-note {
        background: #eaf6ee;
        color: #219a43;
        border-radius: 8px;
        padding: 12px 16px;
        margin-top: 16px;
        font-size: 1rem;
    }

    .pending-admin {
        background: #ffeaea;
        color: #f44336;
        border-radius: 8px;
        padding: 12px 16px;
        margin-top: 12px;
        font-size: 1rem;
    }
	/* File Upload Section */
.edit-form-file-input {
    display: none; /* Hide the default browser file input button */
}

.edit-form-file-label {
    background-color: #f8fcf7;
    border: 1px solid #dbeedc;
    border-radius: 8px;
    padding: 12px 18px;
    font-size: 1rem;
    color: #6c8e6b;
    font-weight: 500;
    margin-left: 10px;
}
    #sidebar {
        transition: transform 0.3s ease;
        /* smooth slide */
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
            margin-left: 240px;
            /* only shifts on big screens */
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
	.file-upload-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    background-color: #fff;
    color: #219a43;
    border: 1px solid #dbeedc;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
	}

.file-upload-btn:hover {
    background-color: #f8fcf9;
    border-color: #219a43;
}

    /* Modal Styles */
    .edit-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .hidden {
        display: none;
    }

    .edit-modal-content {
        background-color: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        width: 90%;
        max-width: 500px;
    }

    .edit-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 12px;
        margin-bottom: 16px;
    }

    .edit-modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a4d2e;
    }

    .edit-modal-close-btn {
        background: none;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        color: #a0a0a0;
    }

    .edit-form-group {
        margin-bottom: 16px;
    }

    .edit-form-label {
        display: block;
        font-size: 1rem;
        color: #6c8e6b;
        margin-bottom: 8px;
    }

    .edit-form-input,
    .edit-form-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #dbeedc;
        border-radius: 8px;
        font-size: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        background-color: #f8fcf7;
    }

    .edit-form-input:focus,
    .edit-form-textarea:focus {
        outline: none;
        border-color: #219a43;
        box-shadow: 0 0 0 3px rgba(33, 154, 67, 0.2);
    }

    .edit-form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .edit-modal-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
    }

    .edit-modal-update-btn {
        background-color: #219a43;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(33, 154, 67, 0.3);
        transition: background-color 0.3s ease;
    }

    .edit-modal-update-btn:hover {
        background-color: #1a7837;
    }
	/* Add this new style to your existing <style> block */
.file-view-link, .file-status-text {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

.file-view-link {
    background-color: #eaf6ee; /* Light green background */
    color: #1a4d2e; /* Dark green text for contrast */
    border: 1px solid #dbeedc;
    text-decoration: none; /* Remove default underline */
    cursor: pointer;
}

.file-view-link:hover {
    background-color: #dbeedc;
}

.file-status-text {
    color: #9e9e9e; /* Grey text for no file */
}
</style>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
include 'header.php';
?>
<div class="dashboard-flex">
    <button id="toggleSidebar"
        class="p-2 bg-green-600 border border-green-700 rounded shadow-sm absolute top-4 left-4 z-50 d-lg-none"
        style="display:inline-flex;align-items:center;justify-content:center;">
        <i data-feather="menu" style="width:24px;height:24px;color:#fff;"></i>
    </button>
    <?php include 'nav.php'; ?>
    <div id="content" class="dashboard-main">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
                    toggleBtn.onclick = function (e) {
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
            <div class="pending-main">
                <div class="pending-title">Pending Transactions</div>
                <div class="pending-subtitle">Manage your pending transactions and view admin responses</div>

                <!-- Account Recharge format -->
                <!-- Loader for pending recharge data -->
                <div id="loader" style="text-align: center; margin-top: 30px; color: #6c8e6b;">
                    <div class="loader"></div> Loading pending transactions...
                </div>

                <!-- Container for dynamically loaded pending deposit transactions (Account Recharge) -->
                <div id="pendingRechargeContainer">
                    <!-- Content from fetch_pending_deposits.php will be inserted here -->
                </div>


             
            </div>
            <script>
                feather.replace();
            </script>
        </main>
    </div>
</div>

<div id="editModal" class="edit-modal-backdrop hidden">
    <div class="edit-modal-content">
        <div class="edit-modal-header">
            <h2 class="edit-modal-title">Edit Transaction</h2>
            <button class="edit-modal-close-btn">&times;</button>
        </div>
        <div class="edit-modal-body">
            <input type="hidden" id="editTransactionId">
           
            <div class="edit-form-group">
                <label class="edit-form-label" id="editAmountLabel">Requested Amount</label>
                <input type="number" id="editAmount" class="edit-form-input" readonly />
            </div>
            
            <div class="edit-form-group">
                <label class="edit-form-label" id="editPriceLabel">Total Amount</label>
                <input type="number" id="editPrice" class="edit-form-input" readonly/>
            </div>
            
            <!-- Bank Selection (only for deposit and withdraw) -->
            <div class="edit-form-group" id="bank-select-group" style="display: none;">
                <label class="edit-form-label" id="bankLabel">Payment Bank</label>
                <select id="editBankSelect" class="edit-form-input"></select>
            </div>

            <!-- Reference Number (only for deposit) -->
            <div class="edit-form-group" id="reference-group" style="display: none;">
                <label class="edit-form-label">Reference Number</label>
                <input type="text" id="editReferenceNumber" class="edit-form-input" />
            </div>

            <!-- File Upload (only for deposit and withdraw) -->
            <div class="edit-form-group" id="file-upload-group" style="display: none;">
                <label class="file-upload-btn">
                    <i data-feather="upload" style="width:18px;height:18px;margin-right:6px;"></i>
                    <input type="file" id="editFile" class="edit-form-file-input" />
                    <span id="uploadButtonText">Upload Image File</span>
                </label>
                <span id="fileStatusContainer" class="ml-3"></span>
            </div>

            <!-- Existing Image (only for deposit and withdraw) -->
            <div class="edit-form-group" id="existingImageGroup" style="display:none;">
                <label class="edit-form-label">Existing Receipt Image</label>
                <div style="border: 1px dashed #dbeedc; padding: 10px; border-radius: 8px;">
                    <a href="#" target="_blank" id="existingImageLink" class="text-green-600 font-medium">View Image</a>
                </div>
            </div>

        </div>
        <div class="edit-modal-footer">
            <button class="edit-modal-update-btn">Update Transaction</button>
        </div>
    </div>
</div>
            <!-- AJAX Polling Script -->
<script>
     const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight_id');
    
    if (highlightId) {
        // Clear the URL parameter right away so it doesn't reappear on refresh
        history.replaceState(null, '', window.location.pathname); 
    }
                // Function to handle the AJAX call and update the content
                function fetchPendingDeposits() {
                    const container = document.getElementById('pendingRechargeContainer');
                    const loader = document.getElementById('loader');

                    // Show loader while fetching (only hide if it's the first load or previously failed)
                    if (loader.style.display === 'none' || loader.style.display === '') {
                        loader.style.display = 'block';
                    }
                    
                    fetch('pending_db_sql.php')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                       .then(html => {
                            // Update the container with the new HTML content
                            container.innerHTML = html.trim();

                            // If no content or no pending cards, show a friendly message
                            if (!html.trim() || !container.querySelector('.pending-card')) {
                                container.innerHTML = `
                                    <div style="
                                        text-align:center;
                                        padding: 40px;
                                        font-size: 1.2rem;
                                        color: #6c8e6b;
                                        border: 1.5px dashed #dbeedc;
                                        border-radius: 12px;
                                        background: #f8fcf7;
                                    ">
                                         No pending transactions here
                                    </div>`;
                            }
                            if (highlightId) {
                                window.applyHighlight(highlightId);
                            }

                            // Re-initialize Feather icons for the newly loaded content
                            feather.replace();

                            // Re-attach modal listeners to new elements
                            attachModalListeners();
                            
                            // Hide loader
                            loader.style.display = 'none';
                        })

                        .catch(error => {
                            console.error('Error fetching pending transactions:', error);
                            container.innerHTML = `<div style="color: #f44336; padding: 20px; border: 1px dashed #f44336; border-radius: 8px; margin-top: 20px;">Could not load pending deposits. Please check server logs.</div>`;
                            loader.style.display = 'none';
                        });
                }
  // Function to mark a single transaction as read, or fall back to batch update if no ID is passed
    function markTransactionAsRead(transactionId = null) {
        let postBody = '';
        if (transactionId) {
            postBody = `transaction_id=${transactionId}`;
        }
        
        // Call mark_as_read.php script
        fetch('mark_as_read.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: postBody
        })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.updated_rows > 0) {
                    // One item marked as read, rely on the notification polling 
                    // (in header.php) to update the badge count shortly.
                }
            })
            .catch(error => {
                console.error('Error marking transaction as read:', error);
            });
    }
                // Initial load
                document.addEventListener('DOMContentLoaded', function() {

                    fetchPendingDeposits();

                    // Set up interval for real-time polling (every 5 min)
                    setInterval(fetchPendingDeposits, 300000 ); 
                    
                    // Define the highlight function globally
        window.applyHighlight = function(transactionId) {
            const card = document.querySelector(`.pending-card[data-id='${transactionId}']`);
            if (card) {
                card.classList.add('highlight-flash');
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                markTransactionAsRead(transactionId); 

                setTimeout(() => {
                    card.classList.remove('highlight-flash');
                }, 3000); 
            }
        }
    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight_id');

    if (highlightId) {
        applyHighlight(highlightId);
        history.replaceState(null, '', window.location.pathname); 
    }

                });
                
                // Function to attach modal listeners (must be re-run after every AJAX update)
                function attachModalListeners() {
                    const editButtons = document.querySelectorAll('.pending-edit');
                    const cancelButtons = document.querySelectorAll('.pending-cancel');

                    const modal = document.getElementById('editModal');
                    const closeButton = document.querySelector('.edit-modal-close-btn');
                    const updateButton = document.querySelector('.edit-modal-update-btn');

                    
                    // Cancel button listeners
                    cancelButtons.forEach(button => {
                        button.onclick = null;
                        button.addEventListener('click', (e) => {
                            const transactionId = e.currentTarget.getAttribute('data-id');
                            const card = e.currentTarget.closest('.pending-card');

                            if (confirm(`Are you sure you want to cancel transaction #${transactionId}?`)) {
                                fetch('pending_btn_action.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: `transaction_id=${transactionId}`
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        // Remove card from UI
                                        card.classList.add('fade-out');

                                            // Wait for transition to finish, then remove element
                                            setTimeout(() => {
                                                card.remove();
                                            }, 400); // match transition duration                                    } else {
                                            fetchPendingDeposits();
                                        } else {
                                        alert("Failed to cancel: " + (data.error || 'Unknown error'));
                                    }

                                })
                                .catch(err => {
                                    console.error('Cancel request error:', err);
                                    alert("Something went wrong while cancelling.");
                                });
                            }
                        });
                    });
                    // Make sure listeners are only attached once for global elements
                    if (!closeButton.hasListener) {
                         closeButton.addEventListener('click', closeModal);
                        updateButton.addEventListener('click', updateTransaction); // Call a new update function
                         window.addEventListener('click', (event) => {
                             if (event.target === modal) {
                                 closeModal();
                             }
                         });
                         closeButton.hasListener = true;
                    }
// New change event listener for file input to update displayed file name
    const editFile = document.getElementById('editFile');
    const fileChosen = document.getElementById('fileChosen');
    editFile.addEventListener('change', (e) => {
        const fileName = e.target.files.length > 0 ? e.target.files[0].name : 'No file chosen';
        fileChosen.textContent = fileName;
        fileChosen.removeAttribute('href'); // Remove link when a new file is selected
    });

                 // Clear existing listeners on dynamic buttons before attaching new ones
    editButtons.forEach(button => {
        button.onclick = null; // Clear existing listener
        button.addEventListener('click', (e) => {
            const transactionId = e.currentTarget.getAttribute('data-id');
            document.getElementById('editTransactionId').value = transactionId;
            document.querySelector('.edit-modal-title').textContent = `Edit Transaction #${transactionId}`;
            
            // **New AJAX call to fetch and populate data**
            fetchTransactionData(transactionId);
        });
    });
}
// New function to fetch and populate the modal with data
function fetchTransactionData(transactionId) {
    fetch(`fetch_transaction_details.php?transaction_id=${transactionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tx = data.data;
                const bankSelect = document.getElementById('editBankSelect');
                const fileStatusContainer = document.getElementById('fileStatusContainer');
                const editFile = document.getElementById('editFile');
                
                // Get UI elements for conditional display
                const bankGroup = document.getElementById('bank-select-group');
                const referenceGroup = document.getElementById('reference-group');
                const fileUploadGroup = document.getElementById('file-upload-group');
                const existingImageGroup = document.getElementById('existingImageGroup');
                const bankLabel = document.getElementById('bankLabel');

                // Reset all groups to hidden first
                bankGroup.style.display = 'none';
                referenceGroup.style.display = 'none';
                fileUploadGroup.style.display = 'none';
                existingImageGroup.style.display = 'none';

                // 1. Populate Input Fields
                document.getElementById('editAmount').value = tx.amount;
                document.getElementById('editPrice').value = tx.total_mmk;
                document.getElementById('editReferenceNumber').value = tx.reference_number || '';
                
                // 2. Update labels and show/hide fields based on transaction type
                const transactionType = tx.transaction_type.toLowerCase();
                
                if (transactionType === 'deposit') {
                    // Deposit: Show bank, reference, and file upload
                    bankGroup.style.display = 'block';
                    referenceGroup.style.display = 'block';
                    fileUploadGroup.style.display = 'block';
                    bankLabel.textContent = 'Payment Bank';
                    
                    document.getElementById('editAmountLabel').textContent = 'Request Amount (USD):';
                    document.getElementById('editPriceLabel').textContent = 'Total To Transfer (MMK):';

                } else if (transactionType === 'withdraw') {
                    // Withdraw: Show bank and file upload, but NOT reference
                     bankGroup.style.display = 'block';
                    // fileUploadGroup.style.display = 'block';
                    bankLabel.textContent = 'Your Selected Bank';
                    
                    document.getElementById('editAmountLabel').textContent = 'Withdraw Amount (USD):';
                    document.getElementById('editPriceLabel').textContent = 'You\'ll Receive (MMK):';

                } else if (transactionType === 'gold purchase') {
                    // Gold Purchase: Only show basic info
                    document.getElementById('editAmountLabel').textContent = 'Gold Amount (oz):';
                    document.getElementById('editPriceLabel').textContent = 'Total Cost (USD):';

                } else if (transactionType === 'sell gold') {
                    // Sell Gold: Only show basic info
                    document.getElementById('editAmountLabel').textContent = 'Gold Amount (oz):';
                    document.getElementById('editPriceLabel').textContent = 'You\'ll Receive (USD):';
                }

                // 3. Populate Bank Dropdown and Auto-Select
                bankSelect.innerHTML = ''; // Clear previous options
                tx.all_banks.forEach(bank => {
                    const option = document.createElement('option');
                    option.value = bank.bank_id;
                    option.textContent = `${bank.bank_name} - ${bank.account_number}`;
                    if (bank.bank_id == tx.bank_id) {
                        option.selected = true; // Auto-select the current bank
                    }
                    bankSelect.appendChild(option);
                });
                
                // 4. Handle Image/File Display
                editFile.value = ''; // Clear file input on modal open
                document.getElementById('uploadButtonText').textContent = 'Upload New Image';
                
                fileStatusContainer.innerHTML = ''; // Clear container first

                if (tx.image && tx.image !== '') {
                    // Show existing image
                    existingImageGroup.style.display = 'block';
                    document.getElementById('existingImageLink').href = 'uploads/' + tx.image;
                    
                    // Also show in file status container
                    const imageLink = document.createElement('a');
                    imageLink.href = 'uploads/' + tx.image;
                    imageLink.target = '_blank';
                    imageLink.classList.add('file-view-link');
                    imageLink.innerHTML = `<i data-feather="image" style="width:18px;height:18px;margin-right:6px;"></i> View Current Receipt`;
                    fileStatusContainer.appendChild(imageLink);
                } else {
                    // No file uploaded
                    const statusText = document.createElement('span');
                    statusText.classList.add('file-status-text');
                    statusText.textContent = 'No receipt uploaded yet.';
                    fileStatusContainer.appendChild(statusText);
                }

                // Re-initialize Feather icons
                feather.replace();

                // 5. Open Modal 
                openModal();

            } else {
                alert(`Error: ${data.error}`);
            }
        })
        .catch(error => {
            console.error('Error fetching transaction details:', error);
            alert('Could not load transaction details.');
        });
}

// New change event listener for file input to update displayed file name
const editFile = document.getElementById('editFile');
const fileStatusContainer = document.getElementById('fileStatusContainer'); // New element reference

editFile.addEventListener('change', (e) => {
    const fileName = e.target.files.length > 0 ? e.target.files[0].name : '';
    const uploadButtonText = document.getElementById('uploadButtonText');

    if (fileName) {
        // When a new file is chosen, update the main upload button text
        uploadButtonText.textContent = `File Chosen: ${fileName.length > 20 ? fileName.substring(0, 17) + '...' : fileName}`;
        
        // And clear the separate status container so it doesn't show the old image link
        fileStatusContainer.innerHTML = ''; 
    } else {
        // If the file selection is cancelled
        uploadButtonText.textContent = 'Upload New Image';
        // The original logic in fetchTransactionData will restore the old link if the modal is reopened
    }
});
function updateTransaction() {
    const updateButton = document.querySelector('.edit-modal-update-btn');
    const originalButtonText = updateButton.innerHTML;

    // Disable button and show loading state
    updateButton.disabled = true;
    updateButton.innerHTML = '<i data-feather="loader" class="animate-spin" style="width:18px;height:18px;margin-right:6px;"></i> Updating...';
    feather.replace(); 

    // 1. Get all the updated values
    const transactionId = document.getElementById('editTransactionId').value;
    const bankId = document.getElementById('editBankSelect').value;
    const referenceNumber = document.getElementById('editReferenceNumber').value;
    const newFile = document.getElementById('editFile').files[0];

    // Get transaction type from the modal title or you might need to store it
    const transactionType = document.getElementById('editAmountLabel').textContent.toLowerCase();

    // Conditional validation based on transaction type
    let isValid = true;
    let errorMessage = '';

    if (transactionType.includes('deposit')) {
        // Deposit requires bank, reference, and optionally file
        if (!bankId || !referenceNumber) {
            isValid = false;
            errorMessage = "Please ensure Bank and Reference Number are filled for deposit.";
        }
    } else if (transactionType.includes('withdraw')) {
        // Withdraw requires bank only (no reference)
        if (!bankId) {
            isValid = false;
            errorMessage = "Please select your bank for withdrawal.";
        }
    }
    // Gold purchase and sell gold don't require additional validation

    if (!isValid) {
        alert(errorMessage);
        updateButton.disabled = false;
        updateButton.innerHTML = originalButtonText;
        feather.replace();
        return;
    }

    // Create FormData
    const formData = new FormData();
    formData.append('transaction_id', transactionId);
    
    // Only append these if they're relevant for the transaction type
    if (bankId) formData.append('bank_id', bankId);
    if (referenceNumber) formData.append('reference_number', referenceNumber);
    if (newFile) formData.append('new_image', newFile);

    // AJAX POST request
    fetch('update_transaction.php', { 
        method: 'POST', 
        body: formData 
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(`Transaction #${transactionId} updated successfully!`);
            closeModal();
            fetchPendingDeposits(); 
        } else {
            alert("Update failed: " + (data.error || 'An unknown server error occurred.'));
        }
    })
    .catch(error => {
        console.error('Error during transaction update:', error);
        alert('A network or server error occurred. Check the console for details.');
    })
    .finally(() => {
        // Re-enable button and restore text
        updateButton.disabled = false;
        updateButton.innerHTML = originalButtonText;
        feather.replace();
    });
}
                // Modal control functions
                function openModal() {
                    document.getElementById('editModal').classList.remove('hidden');
                }

                function closeModal() {
                    document.getElementById('editModal').classList.add('hidden');
                }

</script>

<?php include 'footer.php'; ?>