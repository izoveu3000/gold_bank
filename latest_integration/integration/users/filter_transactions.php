<?php
include 'database.php';

// Set response header
header('Content-Type: application/json');

// ⚠️ SECURITY FIX: Define the user ID here, matching your existing logic.
// In a real application, this MUST come from session_start() and $_SESSION['user_id'].
$user_id = 5; 

try {
    // Get filter parameters
    $search_id = isset($_GET['search_id']) ? trim($_GET['search_id']) : '';
    $transaction_type = isset($_GET['transaction_type']) ? $_GET['transaction_type'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 6; // 6 transactions per page
    $offset = ($page - 1) * $limit;

    // Check if any real filter is applied
    $has_search = !empty($search_id);
    $has_type_filter = $transaction_type !== '' && $transaction_type !== 'all';
    $has_status_filter = $status !== '' && $status !== 'all';
    $has_all_types = $transaction_type === 'all';
    $has_all_status = $status === 'all';

    // Check if we should show filtered results
    $is_filtered = $has_search || $has_type_filter || $has_status_filter || $has_all_types || $has_all_status;

    // Build base query
    $query = "SELECT 
                t.transaction_id,
                t.user_id,
                t.currency_id,
                t.amount,
                t.price,
                t.transaction_type,
                t.transaction_status,
                t.date,
                t.is_read,
                c.currency_name,
                ta.reference_number
            FROM transaction t
            LEFT JOIN currency c ON t.currency_id = c.currency_id
            LEFT JOIN transaction_approve ta ON t.transaction_id = ta.tran_id
            WHERE t.transaction_status != 'pending' AND t.transaction_status != '1'
            AND t.user_id = ?"; // <-- SECURITY FIX: User ID is ALWAYS filtered here

    $params = [$user_id]; // <-- SECURITY FIX: User ID is the first parameter
    $types = 'i';         // <-- 'i' for integer type

    // --- 1. DEFAULT/RECENT TRANSACTIONS BRANCH (No filters applied) ---
    if (!$is_filtered) {
        $query .= " ORDER BY t.date DESC LIMIT ?";
        $params[] = $limit;
        $types .= 'i';
        
        $stmt = $conn->prepare($query);
        if (!$stmt) throw new Exception("Error preparing query (Default): " . $conn->error);

        // Bind parameters: first $user_id, then $limit
        if (!$stmt->bind_param($types, ...$params)) throw new Exception("Error binding params (Default): " . $stmt->error);
        
        $stmt->execute();
        $result = $stmt->get_result();

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }

        // ... (rest of the default response is unchanged) ...
        echo json_encode([
            'success' => true,
            'transactions' => $transactions,
            'pagination' => [
                'current_page' => 1,
                'total_pages' => 1,
                'total_count' => count($transactions),
                'has_previous' => false,
                'has_next' => false
            ],
            'is_filtered' => false
        ]);

        $stmt->close();
        // $conn->close(); // Keep connection open for now to avoid issues
        exit();
    }

    // --- 2. FILTERED TRANSACTIONS BRANCH ---

    // Apply search ID filter
    if ($has_search) {
        $query .= " AND ta.reference_number LIKE ?";
        $params[] = "%$search_id%";
        $types .= 's';
    }

    // Apply transaction type filter
    if ($has_type_filter) {
        if ($transaction_type === 'Account Recharge') {
            $query .= " AND t.transaction_type = 'deposit'";
        } elseif ($transaction_type === 'Gold Purchase') {
            $query .= " AND t.transaction_type = 'gold purchase'";
        } elseif ($transaction_type === 'Withdrawal Request') {
            $query .= " AND t.transaction_type = 'withdrawal request'";
        }
    }

    // Apply status filter
    if ($has_status_filter) {
        if ($status === 'Completed') {
            $query .= " AND t.transaction_status = 'approved'";
        } elseif ($status === 'Rejected') {
            $query .= " AND t.transaction_status = 'rejected'";
        }
    }

    // Add ordering and pagination for filtered results
    $query .= " ORDER BY t.date DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= 'ii';

    // Prepare and execute query
    $stmt = $conn->prepare($query);
    if (!$stmt) throw new Exception("Error preparing query (Filtered): " . $conn->error);
    
    // Bind all parameters
    if (!$stmt->bind_param($types, ...$params)) throw new Exception("Error binding parameters (Filtered): " . $stmt->error);
    
    $stmt->execute();
    $result = $stmt->get_result();

    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }

    // --- Get total count for pagination ---
    // The count query MUST use prepared statements too to be safe, but since you are using 
    // a non-prepared query for count, we must manually inject the user ID here too.
    
    // We rebuild the WHERE clause for the count query to mirror the main query filters
    $count_where_clause = "WHERE t.transaction_status != 'pending' AND t.transaction_status != '1' AND t.user_id = $user_id"; // <-- SECURITY FIX: Injected $user_id

    // Check for search filter (NOTE: This must be converted to prepared statement for full security,
    // but preserving your original structure, we just inject the safe $user_id here)
    if ($has_search) {
        // Since you're not using prepared statements for COUNT, you MUST escape the search_id if it came from user input.
        // Assuming $conn is mysqli and using real_escape_string for safety in non-prepared count query
        $safe_search_id = $conn->real_escape_string($search_id);
        $count_where_clause .= " AND ta.reference_number LIKE '%$safe_search_id%'";
    }
    
    // Apply the same type filters for count query
    if ($has_type_filter) {
        // ... (your existing type filter logic) ...
        if ($transaction_type === 'Account Recharge') {
            $count_where_clause .= " AND t.transaction_type = 'deposit'";
        } elseif ($transaction_type === 'Gold Purchase') {
            $count_where_clause .= " AND t.transaction_type = 'gold purchase'";
        } elseif ($transaction_type === 'Withdrawal Request') {
            $count_where_clause .= " AND t.transaction_type = 'withdrawal request'";
        }
    }

    // Apply the same status filters for count query
    if ($has_status_filter) {
        // ... (your existing status filter logic) ...
        if ($status === 'Completed') {
            $count_where_clause .= " AND t.transaction_status = 'approved'";
        } elseif ($status === 'Rejected') {
            $count_where_clause .= " AND t.transaction_status = 'rejected'";
        }
    }

    $count_query = "SELECT COUNT(*) as total FROM transaction t 
                    LEFT JOIN transaction_approve ta ON t.transaction_id = ta.tran_id 
                    $count_where_clause"; // <-- Updated

    $count_result = $conn->query($count_query);
    if (!$count_result) throw new Exception("Error running count query: " . $conn->error);

    $total_count = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_count / $limit);

    // Close connections
    $stmt->close();
    // $conn->close(); // Closing happens in finally block below, but we'll leave it as is for now

    // Return response
    echo json_encode([
        'success' => true,
        'transactions' => $transactions,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_count' => $total_count,
            'has_previous' => $page > 1,
            'has_next' => $page < $total_pages
        ],
        'is_filtered' => true,
        'filter_info' => [
            'has_search' => $has_search,
            'has_type_filter' => $has_type_filter,
            'has_status_filter' => $has_status_filter,
            'has_all_types' => $has_all_types,
            'has_all_status' => $has_all_status
        ]
    ]);

} catch (Exception $e) {
    error_log("Transaction Filter Error: " . $e->getMessage()); // Log error internally
    http_response_code(500); // Set HTTP status code for error
    echo json_encode([
        'success' => false,
        'error' => 'Server Error: Unable to process request.'
    ]);
} finally {
    // Ensure connection is closed cleanly, even on error
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>