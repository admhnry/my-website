<?php
session_start();
// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "football_tickets"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch existing matches
$sql = "SELECT * FROM matches ORDER BY match_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Schedule</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            position: relative;
            overflow: hidden;
        }
        header {
            background-color: rgba(0, 74, 173, 0.8); /* Semi-transparent Header */
            color: white; /* Header text color */
            padding: 20px 0; /* Header padding */
            text-align: center; /* Center the text */
            position: relative; /* Keep header in flow */
            z-index: 2; /* Bring to front */
        }
        nav {
            display: flex; /* Flexbox for navigation */
            justify-content: center; /* Center navigation items */
            background-color: rgba(0, 53, 128, 0.8); /* Semi-transparent Navigation */
            padding: 10px 0; /* Navigation padding */
            position: relative; /* Keep nav in flow */
            z-index: 2; /* Bring to front */
        }
        nav a {
            color: white; /* Link color */
            padding: 15px 30px; /* Link padding */
            text-decoration: none; /* Remove underline from links */
            text-transform: uppercase; /* Uppercase letters for links */
            font-weight: bold; /* Bold text for links */
            margin: 0 10px; /* Margin between links */
        }
        nav a:hover {
            background-color: #007BFF; /* Background color on hover */
            transition: 0.3s; /* Smooth transition */
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #004aad;
            color: white;
        }
    </style>
</head>
<body>

<header>
    <h1>Football Ticketing System</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="tickets.php">Buy Tickets</a> 
    <a href="schedule.php">Match Schedule</a>
    <a href="contact.php">Contact Us</a>
    <a href="admin_login.php">Admin Login</a>
    <a href="purchase_history.php">History</a>
</nav>

<table>
    <tr>
        <th>ID</th>
        <th>Home</th>
        <th>Away</th>
        <th>Match Date</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['home_team']; ?></td>
                <td><?php echo $row['away_team']; ?></td>
                <td><?php echo date('F j, Y', strtotime($row['match_date'])); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4">No matches scheduled.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
