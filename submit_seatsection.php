<?php
session_start();
require_once('database.php');

// Debug logging
error_log("Starting submit_seatsection.php");
error_log("Session data: " . print_r($_SESSION, true));
error_log("POST data: " . print_r($_POST, true));

if (!isset($_SESSION['user_id'])) {
    error_log("No user_id in session");
    header("Location: login.php");
    exit();
}

// Store seat selection in session
$_SESSION['selectedGate'] = $_POST['gate'];
$_SESSION['selectedLevel'] = $_POST['level'];
$_SESSION['seat_section'] = $_POST['seat'];

try {
    // First get section_id using the gate and level
    $sql = "SELECT id FROM seat_sections WHERE gate = ? AND level = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("si", $_SESSION['selectedGate'], $_SESSION['selectedLevel']);
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $section_id = $row['id'];
        
        // Get necessary data from session
        $user_id = $_SESSION['user_id'];
        $match_id = $_SESSION['ticket_id'];
        $quantity = isset($_SESSION['total_quantity']) ? $_SESSION['total_quantity'] : 1;
        $seat_number = $_SESSION['seat_section'];
        
        // Insert into purchases table
        $insert_sql = "INSERT INTO purchases (
                    user_id, 
                    used, 
                    quantity, 
                    match_id, 
                    section_id, 
                    seat_number, 
                    purchase_date
                ) VALUES (?, 0, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
                
        $insert_stmt = $conn->prepare($insert_sql);
        
        if ($insert_stmt === false) {
            throw new Exception("Failed to prepare insert statement: " . $conn->error);
        }
        
        $insert_stmt->bind_param("iiiii", 
            $user_id, 
            $quantity, 
            $match_id, 
            $section_id, 
            $seat_number
        );
        
        if ($insert_stmt->execute()) {
            // Get the insert ID from the statement
            $purchase_id = $insert_stmt->insert_id;
            $_SESSION['purchase_id'] = $purchase_id;
            
            error_log("Purchase successful. Purchase ID: " . $purchase_id);
            
            // Update available seats
            $update_sql = "UPDATE seat_sections 
                          SET available_seats = available_seats - ? 
                          WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $quantity, $section_id);
            $update_stmt->execute();
            
            // Log the final session state
            error_log("Final session state: " . print_r($_SESSION, true));
            
            header("Location: name.html");
            exit();
        } else {
            throw new Exception("Failed to insert purchase: " . $insert_stmt->error);
        }
    } else {
        throw new Exception("No section found with Gate: {$_SESSION['selectedGate']}, Level: {$_SESSION['selectedLevel']}");
    }
} catch (Exception $e) {
    error_log("Error in submit_seatsection.php: " . $e->getMessage());
    echo "An error occurred: " . $e->getMessage();
    exit();
}
?>