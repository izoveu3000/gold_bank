<?php

include('dashboard_admin_data.php');

// allow header to include a page-specific stylesheet
$extra_css = '../assets/css/dashboard(admin).css';
include('header.php');

?>
  <style>
    /* Page-specific full-width overrides */
    html, body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      overflow-x: hidden;
      background: #f8faf9;
    }
    /* force dashboard area to use full viewport width */
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
