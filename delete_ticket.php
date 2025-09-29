<?php
session_start();
include 'database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Function to delete a ticket
function deleteTicket($ticket_id, $conn) {
    $sql = "DELETE FROM tickets WHERE id=$ticket_id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Example call to delete a ticket
deleteTicket(1, $conn);

$conn->close();
?>
