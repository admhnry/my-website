<?php
session_start();
include('database.php');


if (!isset($_SESSION['username'])) {
    header("Location: login_history.php");
    exit();
}
// Fetch purchase history for the logged-in user
$username = $_SESSION['username'];

// Query to get purchase history from the view
$sql = "SELECT 
    purchase_id,
    user_name,
    home_team,
    away_team,
    match_date,
    section_name,
    gate,
    level,
    seat_number,
    quantity,
    purchase_date,
    ticket_status
FROM purchases_view 
WHERE user_name = ?
ORDER BY purchase_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the external CSS file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #001f3f; /* Soft background color */
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #e91e63; 
            padding-top: 30px;
            margin-bottom: 30px;
            font-size: 32px;
            text-transform: uppercase;
        }

        table {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #001f3f; /* PINK */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Light gray for even rows */
        }

        tr:hover {
            background-color: #e6f0ff; /* Light blue on hover */
        }

        table td {
            word-wrap: break-word;
            max-width: 250px;
        }

        .no-data {
            text-align: center;
            font-size: 1.5em;
            color: #ff5733; /* Red for no data message */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            display: inline-block;
            margin-bottom: 30px;
            padding: 12px 25px;
            background-color: #FF5733; /* Orange button */
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #d84315; /* Darker orange on hover */
        }

        .logout-btn:active {
            background-color: #bf360c; /* Even darker orange when clicked */
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Purchase History</h1>
        <a href="logout_history.php" class="logout-btn">Logout</a>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Purchase ID</th>
                        <th>User Name</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Match Date</th>
                        <th>Section Name</th>
                        <th>Gate</th>
                        <th>Level</th>
                        <th>Seat Number</th>
                        <th>Quantity</th>
                        <th>Purchase Date</th>
                        <th>Ticket Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['purchase_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['home_team']); ?></td>
                            <td><?php echo htmlspecialchars($row['away_team']); ?></td>
                            <td><?php echo htmlspecialchars($row['match_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['section_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['gate']); ?></td>
                            <td><?php echo htmlspecialchars($row['level']); ?></td>
                            <td><?php echo htmlspecialchars($row['seat_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['purchase_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['ticket_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No purchase history found.</p>
        <?php endif; ?>

        <?php
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </div>

</body>
</html>




