<?php
// api/save_message.php
header('Content-Type: application/json');

// Database connection
require_once 'db_connection.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method'
    ]);
    exit;
}

// Get message from POST data
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate message
if (empty($message)) {
    echo json_encode([
        'success' => false,
        'error' => 'Message cannot be empty'
    ]);
    exit;
}

try {
    // Connect to database
    $conn = getDatabaseConnection();
    
    // Insert message into database
    $query = "INSERT INTO messages (message) VALUES (:message)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Message saved successfully'
    ]);
} catch (PDOException $e) {
    // Return error response
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
