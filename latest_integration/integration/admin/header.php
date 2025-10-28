<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Investment Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/user.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php if (!empty($extra_css)) {
        // allow pages to inject a page-specific stylesheet
        echo '<link rel="stylesheet" href="' . htmlspecialchars($extra_css, ENT_QUOTES, 'UTF-8') . '">';
    } ?>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white header-shiftable" style="border-bottom: 1px solid #e0e0e0; min-height: 30px;">
        <div class="header-content container-fluid d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center flex-shrink-1">
                <button id="toggleSidebar" class="expand-icon btn btn-link d-flex align-items-center justify-content-center" style="background: #eaf6ee; border: none; margin-right: 10px; color: #388e3c; border-radius: 50%; width: 40px; height: 40px; box-shadow: 0 2px 8px rgba(56,142,60,0.08);">
                    <!-- Gold Vault SVG Icon -->
                    <!-- Sidebar Box Icon (Feather 'box') -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="#222" stroke-width="2" fill="#fff"/>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="#222" stroke-width="2" fill="none"/>
                            <line x1="12" y1="22.08" x2="12" y2="12" stroke="#222" stroke-width="2"/>
                        </svg>
                </button>
            </div>
            <div class="d-flex align-items-center gap-3 flex-shrink-1">
                <!-- Notification Icon -->
               
                <!-- Profile Icon (clickable) -->
                <a href="profile.php" style="text-decoration:none;">
                    <span class="profile-icon" style="background: #eaf6ee; border-radius: 50%; padding: 6px 8px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="#388e3c" stroke-width="2" fill="#fff"/><path d="M4 20c0-2.21 3.58-4 8-4s8 1.79 8 4" stroke="#388e3c" stroke-width="2" fill="none"/></svg>
                    </span>
                </a>
            </div>
        </div>
    </nav>
