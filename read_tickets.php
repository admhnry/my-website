<?php
session_start();
include 'database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Function to fetch and display tickets
function fetchTickets($conn) {
    $sql = "SELECT * FROM tickets";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Adjusted to remove zone and show other ticket details (e.g., ticket_type, user_id, match_id)
            echo "ID: " . $row["id"]. " - User ID: " . $row["user_id"]. " - Match ID: " . $row["match_id"]. " - Ticket Type: " . $row["ticket_type"] . "<br>";
        }
    } else {
        echo "0 results";
    }
}

fetchTickets($conn);
$conn->close();
?>

