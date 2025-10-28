<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Investment Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/user.css">
    <style>
        /* --- Notification Dropdown Styles --- */
.notification-dropdown-container {
    position: relative; 
    margin-right: 16px; 
}

.notification-icon-wrapper {
    /* Keep this for alignment */
    display: flex;
    align-items: center;
    justify-content: center;
    height: 36px;
    width: 36px;
}

.notification-badge {
    /* --- PINTEREST-STYLE POSITIONING --- */
    position: absolute;
    top: 3px;         /* Adjusted to move it down slightly */
    right: 4px;       /* Adjusted to move it left and closer to the bell */
    
    /* Keep the style properties */
    background-color: #f44336; /* Red color */
    color: white;
    border-radius: 50%;
    width: 8px;     /* Made slightly smaller for a more subtle dot */
    height: 8px;
    padding: 0;
    /* Optional: Add a small border for visibility against the icon */
    border: 1px solid white; 
    display: block; 
}

.notification-badge.hidden {
    display: none;
}

.notification-box {
    position: absolute;
    top: 100%; 
    right: 0;
    width: 350px; 
    max-height: 400px;
    background-color: #fff;
    border: 1px solid #dbeedc;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 1000; 
    overflow: hidden;
    margin-top: 10px; 
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.notification-box.hidden {
    display: none;
    opacity: 0;
    transform: translateY(-10px);
}

.notification-header {
    padding: 12px 16px;
    font-weight: 600;
    color: #1a4d2e;
    border-bottom: 1px solid #eaf6ee;
    background-color: #f8fcf7;
}

.notification-list {
    list-style: none;
    padding: 0;
    margin: 0;
    overflow-y: auto;
    max-height: 300px;
}

.notification-list li {
    padding: 12px 16px;
    border-bottom: 1px solid #f8fcf7;
    cursor: pointer;
    transition: background-color 0.15s ease;
    font-size: 0.95rem;
}

.notification-list li:hover {
    background-color: #eaf6ee;
}

/* Style for UNREAD notifications (is_read = 0) */
.notification-list li.unread {
    background-color: #e6fff0; /* Light green highlight for unread */
    font-weight: 500;
}

.notification-list li a {
    text-decoration: none;
    color: #1a4d2e;
    display: block;
}

/* --- Highlight CSS for 'Check' and History transactions --- */
/* This is the class that will be added to the pending card when redirected */
.highlight-flash {
    /* Use a brief keyframe animation for a flash effect */
    animation: flashHighlight 1.5s ease-out 1; 
    border: 3px solid #ffb300 !important; /* Yellow border for 'Check' highlight */
}

@keyframes flashHighlight {
    0% { background: #ffe082; box-shadow: 0 0 10px #ffe082; }
    50% { background: #f8fcf7; box-shadow: none; }
    100% { background: #f8fcf7; border: 1.5px solid #dbeedc; box-shadow: 0 2px 16px #e6f4ea; }
}
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white header-shiftable" style="border-bottom: 1px solid #e0e0e0; min-height: 30px;">
        <div class="header-content container-fluid d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center flex-shrink-1">
                <button id="toggleSidebar" class="expand-icon btn btn-link d-flex align-items-center justify-content-center" style="background: #eaf6ee; border: none; margin-right: 10px; color: #388e3c; border-radius: 50%; width: 40px; height: 40px; box-shadow: 0 2px 8px rgba(56,142,60,0.08);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="#222" stroke-width="2" fill="#fff"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="#222" stroke-width="2" fill="none"/>
                        <line x1="12" y1="22.08" x2="12" y2="12" stroke="#222" stroke-width="2"/>
                    </svg>
                </button>
            </div>
            
            <div class="d-flex align-items-center gap-3 flex-shrink-1">
                <div class="notification-dropdown-container d-none d-md-inline">
                    <span id="notificationToggle" class="notification-icon-wrapper" style="cursor: pointer; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path d="M18 16v-5a6 6 0 10-12 0v5l-1.29 1.29A1 1 0 006 19h12a1 1 0 00.71-1.71L18 16z" stroke="#222" stroke-width="2" fill="none"/></svg>
                        
                        <span id="notificationBadge" class="notification-badge hidden"></span>
                    </span>

                    <div id="notificationBox" class="notification-box hidden">
                        <div class="notification-header">Notifications (<span id="unreadCount">0</span> unread)</div>
                        <ul id="notificationList" class="notification-list">
                            <li class="p-3 text-center text-secondary small">Loading...</li>
                        </ul>
                        <div class="notification-footer">
                            <a href="history(user).php">View All History</a>
                        </div>
                    </div>
                </div>
                <a href="profile.php" aria-label="Open profile" title="Profile">
                    <span class="profile-icon" style="background: #eaf6ee; border-radius: 50%; padding: 6px 8px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="#388e3c" stroke-width="2" fill="#fff"/><path d="M4 20c0-2.21 3.58-4 8-4s8 1.79 8 4" stroke="#388e3c" stroke-width="2" fill="none"/></svg>
                    </span>
                </a>
            </div>
        </div>
    </nav>

</body>
<script>
    // Function to handle fetching and displaying notifications
function fetchAndDisplayNotifications() {
    const list = document.getElementById('notificationList');
    const badge = document.getElementById('notificationBadge');
    const unreadCountSpan = document.getElementById('unreadCount');
    
    // 1. AJAX call to fetch data
    fetch('fetch_notifications.php')
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error("Failed to fetch notifications:", data.error);
                return;
            }

            const notifications = data.notifications;
            let html = '';
            let unreadCount = data.unread_count; 
            
            // --- UPDATE BADGE ---
            unreadCountSpan.textContent = unreadCount;
            if (unreadCount > 0) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }

            if (notifications.length === 0) {
                html = '<li class="p-3 text-center text-secondary small">No recent transaction updates.</li>';
            } else {
                notifications.forEach(notif => {
                    const status = notif.status;
                    let linkHref = '#';
                    let message = '';
                    
                    // Amount display logic
                    const amountValue = (notif.type.includes('deposit') || notif.type.includes('withdrawal')) 
                                        ? parseFloat(notif.price).toLocaleString('en') + ' Coins' 
                                        : notif.amount + ' ' + notif.currency;

 // NEW: Determine if it should be marked as read on click
                const isUnread = notif.is_read == 0; 
                 const markReadParam = isUnread ? '&mark_read=true' : ''; // Append this to the URL if unread

                    // 2. Link & Message Logic
              if (status === 'warn') {
                        // If the status is 'check', redirect to the pending page
                        linkHref = `pending(user).php?highlight_id=${notif.id}${markReadParam}`; // <<< MODIFIED
                        message = `<span class="fw-bold">${amountValue}</span> ${notif.type} requires further review. <span class="fw-bold text-warning">Action required!</span>`;
                    } else if (status === 'approved') {
                        // If the status is 'approved', redirect to the history page
                        linkHref = `history(user).php?highlight_id=${notif.id}${markReadParam}`; // <<< MODIFIED
                        message = `<span class="fw-bold">${amountValue}</span> ${notif.type} has been <span class="fw-bold text-success">approved</span>.`;
                    } else if (status === 'rejected') {
                        // If the status is 'rejected', redirect to the history page
                        linkHref = `history(user).php?highlight_id=${notif.id}${markReadParam}`; // <<< MODIFIED
                        message = `<span class="fw-bold">${amountValue}</span> ${notif.type} has been <span class="fw-bold text-danger">rejected</span>.`;
                     }

                    // 3. Build the List Item HTML
                    html += `
                        <li class="${status} ${notif.is_read == 0 ? 'unread' : ''}" data-id="${notif.id}">
                            <a href="${linkHref}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span>${message}</span>
                                </div>
                                <small class="text-muted d-block mt-1">${new Date(notif.date).toLocaleDateString()}</small>
                            </a>
                        </li>
                    `;
                });
            }

            list.innerHTML = html;

        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
            list.innerHTML = '<li class="p-3 text-center text-danger small">Could not load notifications.</li>';
        });
}




document.addEventListener('DOMContentLoaded', function () {
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationBox = document.getElementById('notificationBox');
    
    // Notification Icon click event
    if(notificationToggle) {
        notificationToggle.addEventListener('click', (e) => {
            e.stopPropagation(); 
            notificationBox.classList.toggle('hidden');
            
            if (!notificationBox.classList.contains('hidden')) {
                fetchAndDisplayNotifications(); 
                
            }
        });
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
        if (!notificationBox.classList.contains('hidden') && !e.target.closest('.notification-dropdown-container')) {
            notificationBox.classList.add('hidden');
        }
    });

    fetchAndDisplayNotifications(); 

    setInterval(fetchAndDisplayNotifications, 60000); 


    window.applyHighlight = function(transactionId) {
        const card = document.querySelector(`.pending-card[data-id='${transactionId}']`);
        
        if (card) {
            card.classList.add('highlight-flash');
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            setTimeout(() => {
                card.classList.remove('highlight-flash');
            }, 3000); 
        }
    }
    
    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight_id');
     const markRead = urlParams.get('mark_read');
    
    if (highlightId) {
        // Highlight logic (this should be inside pending.php or history.php's main JS block, 
        // but if it's placed here in header.php, we execute it)
     window.applyHighlight(highlightId); // Run the highlight effect
        
        // NEW: Mark as read only if the parameter is present
        if (markRead === 'true') {
            markSpecificNotificationAsRead(highlightId); // Mark the specific ID as read
            
            // Clean up the URL: Remove `mark_read=true` to prevent repeated marking on refresh.
            const cleanUrl = window.location.pathname + '?highlight_id=' + highlightId;
            history.replaceState(null, '', cleanUrl);
        }
     }
});
</script>