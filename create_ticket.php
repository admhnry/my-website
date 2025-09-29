<?php
session_start();
include 'database.php'; // Ensure this file correctly connects to your database

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Function to create a ticket
function createTicket($user_id, $match_id, $conn) {
    $sql = "INSERT INTO tickets (user_id, match_id) VALUES ('$user_id', '$match_id')";
    if ($conn->query($sql) === TRUE) {
        echo "New ticket created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Example call to create a ticket
$user_id = 1; // Example user_id, ideally this should be dynamic
$match_id = 1; // Example match_id, should be dynamic based on the match
createTicket($user_id, $match_id, $conn);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket - Football Ticketing System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            background-image: url('images/football_bg.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
        }
        header {
            background-color: #004aad;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            margin: 50px auto;
            padding: 50px;
            width: 80%;
            text-align: center;
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    </header>
    <div class="container">
        <h2>Create Your Ticket Here</h2>
        <!-- Form for ticket creation if you need additional inputs from the user -->
    </div>
</body>
</html>

