<?php

    // Include your database connection and data retrieval logic
include('gold_purchase_page_data.php');

// Set the content type header to JSON
header('Content-Type: application/json');

// Echo the JSON-encoded transactions array
echo json_encode($requests);


?>