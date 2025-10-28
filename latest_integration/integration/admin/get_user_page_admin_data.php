<?php

// Include your database connection and data retrieval logic
include('user_page_admin_data.php');

// Set the content type header to JSON
header('Content-Type: application/json');

// Echo the JSON-encoded transactions array
echo json_encode($final_users);





?>