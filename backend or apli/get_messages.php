<?php
// api/get_messages.php
header('Content-Type: application/json');

// Database connection
require_once 'db_connection.php';

try {
    // Connect to database
    $conn = getDatabaseConnection();
    
    // Query to get messages
    $query = "SELECT * FROM messages ORDER BY created_at DESC LIMIT 10";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Fetch all messages
    $messages = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $messages[] = [
            'id' => $row['id'],
            'message' => $row['message'],
            'created_at' => $row['created_at']
        ];
    }
    
    // Return success response with messages
    echo json_encode([
        'success' => true,
        'messages' => $messages
    ]);
} catch (PDOException $e) {
    // Return error response
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
