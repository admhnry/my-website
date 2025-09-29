<?php


// Include the database connection
include 'database.php';

// Functions
function createMatch($match_id, $home_team, $away_team, $date, $time, $stadium) {
    global $conn;

    $sql = "INSERT INTO matches (match_id, home_team, away_team, date, time, stadium)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $match_id, $home_team, $away_team, $date, $time, $stadium);
    $stmt->execute();
    $stmt->close();
}

function createTicket($match_id, $ticket_type, $price, $quantity) {
    global $conn;

    $sql = "INSERT INTO tickets (match_id, ticket_type, price, quantity)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $match_id, $ticket_type, $price, $quantity);
    $stmt->execute();
    $stmt->close();
}

function sellTickets($match_id, $ticket_type, $quantity) {
    global $conn;

    $sql = "UPDATE tickets SET quantity = quantity - ? WHERE match_id = ? AND ticket_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $quantity, $match_id, $ticket_type);
    $stmt->execute();
    $stmt->close();
}

function getMatchDetails($match_id) {
    global $conn;

    $sql = "SELECT * FROM matches WHERE match_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $match_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_assoc();
}

function getTicketDetails($match_id) {
    global $conn;

    $sql = "SELECT * FROM tickets WHERE match_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $match_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Sample usage
createMatch("M001", "Team A", "Team B", "2023-10-28", "15:00", "Stadium X");
createTicket("M001", "VIP", 100, 100);
createTicket("M001", "General Admission", 50, 200);
sellTickets("M001", "General Admission", 50);

// Retrieve and display match details
$match_id = "M001";
$match_details = getMatchDetails($match_id);
echo "Match ID: " . $match_details['match_id'] . "<br>";
echo "Home Team: " . $match_details['home_team'] . "<br>";
echo "Away Team: " . $match_details['away_team'] . "<br>";
echo "Date: " . $match_details['date'] . "<br>";
echo "Time: " . $match_details['time'] . "<br>";
echo "Stadium: " . $match_details['stadium'] . "<br>";

// Retrieve and display ticket details
$ticket_details = getTicketDetails($match_id);
echo "Ticket Details:<br>";
foreach ($ticket_details as $ticket) {
    echo "Ticket Type: " . $ticket['ticket_type'] . "<br>";
    echo "Price: " . $ticket['price'] . "<br>";
    echo "Quantity Available: " . $ticket['quantity'] . "<br><br>";
}