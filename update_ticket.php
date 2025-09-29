<?php
session_start();
include 'database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Function to update a ticket (without using zone)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_ticket'])) {
    $ticket_id = $_POST['ticket_id']; 
    $ticket_type = $conn->real_escape_string($_POST['ticket_type']); 

    // Modify the query to update the ticket (replace `ticket_type` with your actual column)
    $sql = "UPDATE tickets SET ticket_type='$ticket_type' WHERE id=$ticket_id";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Ticket updated successfully!";
    } else {
        $message = "Error updating ticket: " . $conn->error;
    }

    // Display the message (optional)
    echo $message;
}

$conn->close();
?>

