<?php
session_start();
if(isset($_SESSION['user_id'])&& $_SESSION['user_type']==="admin"){

}else{
  header('Location: ../admin/login.php');
}
include('deposite_page_data.php');

// Ensure $requests is an array
if (!isset($requests) || !is_array($requests)) {
    $requests = [];
}

// Set JSON header and prevent caching
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Output JSON
echo json_encode($requests, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
