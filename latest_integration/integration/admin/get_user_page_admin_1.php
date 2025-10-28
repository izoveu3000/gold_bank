<?php

include('user_page_admin_data.php');
// / --- Final Step: Prepare and send the single JSON response ---

// Create an associative array with all the variables
$response_data = [
    'total_users' => $total_users,
    'total_gold'  => $total_gold,
    'total_dollars' => $total_dollars,
    'total_active' => $total_active
    
];

// Set the content-type header to 'application/json'
header('Content-Type: application/json');

// Encode the PHP array into a JSON string and echo it
echo json_encode($response_data);






?>