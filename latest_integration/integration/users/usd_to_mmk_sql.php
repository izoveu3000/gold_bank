<?php
// Assume 'database.php' contains your mysqli connection setup ($conn)
include 'database.php'; 

// Set the content type header to application/json
header('Content-Type: application/json');

$response = [
    'rate' => 0.00, 
    'success' => false
];

// Check for a valid database connection
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    // SQL Query: Get the latest 'price' for 'dollar' (currency_id = 2)
    // The result will be ordered by 'changed_at' descending, taking the top (LIMIT 1).
    $sql = "SELECT price FROM currency_price WHERE currency_id = 2 ORDER BY changed_at DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Convert the decimal price to a floating-point number
        $response['rate'] = floatval($row['price']);
        $response['success'] = true;
    }
    
    // Close the connection
    if (isset($conn)) {
        $conn->close();
    }
}

// Output the JSON response for the JavaScript to read
echo json_encode($response);
exit;
?>