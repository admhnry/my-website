<?php
session_start();
require_once 'database.php';
require_once 'config.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_ticket'])) {
    $purchase_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM purchases_view
            WHERE purchase_id = ? AND ticket_status != 'Used'
        ");
        $stmt->execute([$purchase_id]);
        
        if ($ticket = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (strtotime($ticket['match_date']) < time()) {
                $message = [
                    'type' => 'error',
                    'text' => 'This ticket is expired. Match date: ' . htmlspecialchars($ticket['match_date'])
                ];
            } else {
                // Update the purchase to mark it as used
                $update = $pdo->prepare("UPDATE purchases SET used = 1 WHERE id = ?");
                $update->execute([$purchase_id]);

                $message = [
                    'type' => 'success',
                    'text' => sprintf(
                        'Ticket verified successfully! Match: %s vs %s on %s<br>Section: %s, Gate: %s, Level: %s, Seat: %s',
                        htmlspecialchars($ticket['home_team']),
                        htmlspecialchars($ticket['away_team']),
                        htmlspecialchars($ticket['match_date']),
                        htmlspecialchars($ticket['section_name']),
                        htmlspecialchars($ticket['gate']),
                        htmlspecialchars($ticket['level']),
                        htmlspecialchars($ticket['seat_number'])
                    )
                ];
            }
        } else {
            $message = [
                'type' => 'error',
                'text' => 'Invalid ticket ID or ticket already used!'
            ];
        }
    } catch (PDOException $e) {
        $message = [
            'type' => 'error',
            'text' => 'Database error occurred!'
        ];
        error_log($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Verification</title>
    <style>
        /* Your existing styles remain the same */
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_dashboard.php" class="btn back-btn">Back to Dashboard</a>
        
        <h2>Ticket Verification</h2>

        <?php if (isset($message)): ?>
            <div class="message <?php echo $message['type']; ?>">
                <?php echo $message['text']; ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="id">Purchase ID:</label>
                    <input type="number" id="id" name="id" required>
                </div>
                <button type="submit" name="verify_ticket" class="btn">Verify Ticket</button>
            </form>
        </div>
    </div>
</body>
</html>