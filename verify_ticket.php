<?php
session_start();
require_once('database.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['purchase_id']) ? $_POST['id'] : null;
    
    if ($purchase_id) {
        try {
            // Start transaction
            $conn->begin_transaction();
            
            // Check if ticket exists and hasn't been used
            $check_sql = "SELECT id, used FROM purchases WHERE id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("i", $purchase_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($result->num_rows > 0) {
                $ticket = $result->fetch_assoc();
                
                if ($ticket['used'] == 0) {
                    // Update ticket to used
                    $update_sql = "UPDATE purchases SET used = 1 WHERE id = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("i", $purchase_id);
                    
                    if ($update_stmt->execute()) {
                        $conn->commit();
                        echo json_encode([
                            'success' => true,
                            'message' => 'Ticket marked as used'
                        ]);
                    } else {
                        throw new Exception("Failed to update ticket");
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Ticket has already been used'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid ticket'
                ]);
            }
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Purchase ID not provided'
        ]);
    }
}
?>



		