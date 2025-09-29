<?php
session_start();
require_once('database.php');

// Debug session data
error_log("Session data in buy_tickets: " . print_r($_SESSION, true));

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $ticketId = $_POST['ticket_id'];
        
        // Get match details using prepared statement
        $sql = "SELECT * FROM matches WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ticketId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['match_details'] = [
                'home_team' => $row['home_team'],
                'away_team' => $row['away_team'],
                'match_date' => $row['match_date'],
                'stadium' => $row['stadium'],
                'price_range' => "RM35 - RM65"
            ];

            $_SESSION['ticket_id'] = $ticketId;
            
            // Debug log
            error_log("Match selected. Session data: " . print_r($_SESSION, true));
            
            header("Location: tickettype.php");
            exit();
        } else {
            echo "Match not found.";
            exit();
        }
    } else {
        echo "User ID not found in session.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Tickets - Football Ticketing System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        .ticket {
            background-color: #f1f1f1;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .ticket-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px 0;
        }
        .ticket-form label {
            margin-right: 10px;
        }
        .ticket-form select, .ticket-form input {
            margin-bottom: 10px;
        }
        .payment-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #004aad;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .payment-button:hover {
            background-color: #00378a;
        }
        .team-logo {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .match-info {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #ff4444;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>
    
    <div class="container">
        <h2>Matches Available</h2>
        <?php
                // Get available matches using prepared statement
                $sql = "SELECT DISTINCT matches.id, matches.home_team, matches.away_team, 
                        matches.match_date, matches.stadium
                        FROM tickets
                        JOIN matches ON tickets.match_id = matches.id
                        WHERE tickets.available = TRUE";
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Sanitize team names for logo filenames
                        $homeLogo = strtolower(str_replace(' ', '_', $row['home_team'])) . '_logo.png';
                        $awayLogo = strtolower(str_replace(' ', '_', $row['away_team'])) . '_logo.png';
        
                        echo "<div class='ticket'>";
                        echo "<div class='match-info'>";
                        // Display team logos
                        echo "<img src='images/logos/" . htmlspecialchars($homeLogo) . "' alt='" . htmlspecialchars($row['home_team']) . " Logo' class='team-logo'>";
                        echo "<h3>Match: " . htmlspecialchars($row['home_team']) . " vs " . htmlspecialchars($row['away_team']) . "</h3>";
                        echo "<img src='images/logos/" . htmlspecialchars($awayLogo) . "' alt='" . htmlspecialchars($row['away_team']) . " Logo' class='team-logo'>";
                        echo "</div>";
                        echo "<p>Date: " . htmlspecialchars($row['match_date']) . "</p>";
                        echo "<p>Stadium: " . htmlspecialchars($row['stadium']) . "</p>";
                        echo "<p>Price: RM35 - RM65 per ticket</p>";
                        echo "<form method='POST' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' class='ticket-form'>";
                        echo "<input type='hidden' name='ticket_id' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='submit' class='payment-button'>Proceed</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No tickets available at the moment.</p>";
                }
                ?>
            </div>
        

    <script>
        // Optional: Add any client-side validations or enhancements here
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Confirm before proceeding
            const forms = document.querySelectorAll('.ticket-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Proceed with ticket purchase?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>




	