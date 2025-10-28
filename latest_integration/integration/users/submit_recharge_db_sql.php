<?php
// Include your database connection
include 'database.php';
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve data from the form
    // $userId = $_SESSION['user_id']; // Get the user ID from the session
    $userId=5;
    $amount = $_POST['amount'];
    $price = 1000;


    $transactionId = $_POST['transaction_id'];

    $bankId = isset($_POST['bank_id']) ? (int)$_POST['bank_id'] : null;
    // Start a transaction
    $conn->begin_transaction();
    $success = true;

    try {
        // Prepare and execute the first statement for the transaction table
        $stmt = $conn->prepare("INSERT INTO `transaction` (`user_id`, `amount`, `price`, `transaction_type`, `transaction_status`, `date`) VALUES (?, ?, ?, ?, ?, NOW())");
        $currencyId = 2; // For dollar
        $transactionType = "deposit";
        $transactionStatus = "pending";
        $stmt->bind_param("iddss", $userId, $amount, $price, $transactionType, $transactionStatus);
        $stmt->execute();
        $newTransactionId = $stmt->insert_id; // Get the ID of the newly inserted row
        $stmt->close();

        // Handle file upload
        if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] == 0) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = basename($_FILES["payment_screenshot"]["name"]);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueFileName = uniqid('proof_', true) . '.' . $fileExtension;
            $targetFile = $targetDir . $uniqueFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["payment_screenshot"]["tmp_name"], $targetFile)) {
                // Prepare and execute the second statement for the transaction_approve table
                $stmt = $conn->prepare("INSERT INTO `transaction_approve` (`tran_id`, `reference_number`, `bank_id`, `image`) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiss", $newTransactionId, $transactionId, $bankId, $uniqueFileName);
                $stmt->execute();
                $stmt->close();

                
            } else {
                // File upload failed
                $success = false;
            }
        } else {
            // No file uploaded
            $success = false;
        }

        if ($success) {
            // Commit the transaction if all queries were successful
            $conn->commit();
            header("Location: pending(user).php");
        } else {
            // Rollback if any part failed
            $conn->rollback();
            header("Location: dashboard(user).php");
        }

    } catch (Exception $e) {
        // Rollback on any exception
        $conn->rollback();
        header("Location: dashboard(user).php");
    }

    $conn->close();
    exit();
} else {
    // Redirect if accessed directly without form submission
    header("Location: withdraw(user).php");
    exit();
}
?>