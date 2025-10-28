<?php
include 'database.php';

// Set the directory where images are uploaded (needs to be writable by the web server)
$target_dir = "uploads/";

// Response array
$response = ['success' => false, 'error' => ''];

// Helper function for dynamic bind_param (required for older PHP versions)
function refValues($arr) {
    $refs = [];
    foreach ($arr as $key => $value) {
        $refs[$key] = &$arr[$key];
    }
    return $refs;
}

try {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }
    
    // 2. Input Validation and Sanitization
    $transactionId = filter_input(INPUT_POST, 'transaction_id', FILTER_VALIDATE_INT);
    $bankId = filter_input(INPUT_POST, 'bank_id', FILTER_VALIDATE_INT);
    $referenceNumber = filter_input(INPUT_POST, 'reference_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$transactionId) {
        throw new Exception("Missing or invalid transaction ID.");
    }

    // Get transaction type to determine required fields
    $transactionType = '';
    if ($transactionId) {
        $stmt_type = $conn->prepare("SELECT transaction_type FROM transaction WHERE transaction_id = ?");
        $stmt_type->bind_param("i", $transactionId);
        $stmt_type->execute();
        $result_type = $stmt_type->get_result();
        if ($result_type->num_rows > 0) {
            $transactionData = $result_type->fetch_assoc();
            $transactionType = strtolower($transactionData['transaction_type']);
        }
        $stmt_type->close();
    }

    // Conditional validation based on transaction type
    if ($transactionType === 'deposit') {
        // Deposit requires bank and reference number
        if (!$bankId || !$referenceNumber) {
            throw new Exception("For deposit transactions, both bank and reference number are required.");
        }
    } elseif ($transactionType === 'withdraw') {
        // Withdraw requires bank only (no reference number required)
        if (!$bankId) {
            throw new Exception("For withdrawal transactions, bank selection is required.");
        }
        // For withdraw, reference number can be empty
        $referenceNumber = $referenceNumber ?: '';
    } else {
        // For gold purchase and sell gold, bank and reference are not required
        $bankId = $bankId ?: NULL;
        $referenceNumber = $referenceNumber ?: '';
    }

    $image_file = '';

    // 3. Handle File Upload (Receipt Image) - Only for deposit and withdraw
    if (($transactionType === 'deposit' || $transactionType === 'withdraw') && 
        isset($_FILES["new_image"]) && $_FILES["new_image"]["error"] === UPLOAD_ERR_OK) {
        
        $file_info = pathinfo($_FILES["new_image"]["name"]);
        $extension = strtolower($file_info['extension']);
        
        $new_file_name = "proof_" . uniqid(rand(), true) . '.' . $extension;
        $target_file = $target_dir . $new_file_name;

        // Basic MIME type check
        $image_mime = mime_content_type($_FILES["new_image"]["tmp_name"]);
        if (!in_array($image_mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            throw new Exception("Invalid file type. Only JPG, PNG, GIF, or WebP allowed.");
        }
        
        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
            $image_file = $conn->real_escape_string($new_file_name);
        } else {
            throw new Exception("Failed to move uploaded file.");
        }
    }

    // 4. Update the 'transaction_approve' table (UPSERT Logic)
    $stmt_check = $conn->prepare("SELECT 1 FROM transaction_approve WHERE tran_id = ?");
    $stmt_check->bind_param("i", $transactionId);
    $stmt_check->execute();
    $found = $stmt_check->fetch();
    $stmt_check->close();
    
    $types = '';
    $params = [];
    
    if ($found) {
        // UPDATE existing record in transaction_approve
        $sql_approve = "UPDATE transaction_approve SET bank_id = ?, reference_number = ?";
        $types = "is";
        $params = [$bankId, $referenceNumber];
        
        if ($image_file) {
            $sql_approve .= ", image = ?";
            $types .= "s";
            $params[] = $image_file;
        }
        
        $sql_approve .= " WHERE tran_id = ?";
        $types .= "i";
        $params[] = $transactionId;

    } else {
        // INSERT new record into transaction_approve
        $sql_approve = "INSERT INTO transaction_approve (tran_id, bank_id, reference_number, image) VALUES (?, ?, ?, ?)";
        $types = "iiss";
        $insert_image = $image_file ?: ''; 
        $params = [$transactionId, $bankId, $referenceNumber, $insert_image];
    }

    $stmt_approve = $conn->prepare($sql_approve);
    
    // Bind parameters dynamically
    $bind_params = array_merge([$types], $params);
    call_user_func_array([$stmt_approve, 'bind_param'], refValues($bind_params));
    
    $stmt_approve->execute();
    
    if ($stmt_approve->error) {
        throw new Exception("Error updating transaction_approve: " . $stmt_approve->error);
    }
    $stmt_approve->close();

    $response['success'] = true;

} catch (Exception $e) {
    // If an error occurred, set the error message
    $response['error'] = $e->getMessage();
} finally {
    // Close the connection only if it's still open
    if (isset($conn) && $conn->ping()) {
        $conn->close();
    }
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>