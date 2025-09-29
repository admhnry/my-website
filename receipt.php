<?php
session_start();

// Retrieve session data for the receipt
$name = $_SESSION['name'];
$nric = $_SESSION['nric'];
$phone = $_SESSION['phone'];
$ticket_type_1 = $_SESSION['ticket_type_1'];
$ticket_type_2 = $_SESSION['ticket_type_2'];
$ticket_type_3 = $_SESSION['ticket_type_3'];
$ticket_type_4 = $_SESSION['ticket_type_4'];
$selectedGate = $_SESSION['selectedGate'];
$selectedLevel = $_SESSION['selectedLevel'];
$seat_section = $_SESSION['seat_section'];

// Prices for different ticket types
$price_open_adult = 35.50;
$price_open_child = 10.00;
$price_grandstand = 55.00;
$price_premium = 65.00;

// Calculate the total price
$total_price = ($ticket_type_1 * $price_open_adult) + ($ticket_type_2 * $price_open_child) + ($ticket_type_3 * $price_grandstand) + ($ticket_type_4 * $price_premium);

// Simulate payment processing (you can replace this with a real payment gateway)
$is_payment_successful = true; // Change this based on the actual payment result
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Ticket Purchase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .receipt-details {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .receipt-details p {
            font-size: 16px;
            margin: 10px 0;
        }
        .payment-status {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .success {
            color: green;
        }
        .failure {
            color: red;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>Payment Status</h1>
</header>

<div class="container">
    <h2>Payment Details</h2>

    <div class="receipt-details">
        <div class="payment-status">
            <?php
            if ($is_payment_successful) {
                echo "<p class='success'><strong>Payment Successful!</strong></p>";
                echo "<p>Thank you for your purchase, " . $name . ". Your booking has been confirmed.</p>";
                echo "<p><strong>Total Amount Paid:</strong> RM" . number_format($total_price, 2) . "</p>";
            } else {
                echo "<p class='failure'><strong>Payment Failed</strong></p>";
                echo "<p>Please try again or contact support.</p>";
            }
            ?>

            <h3>Booking Details:</h3>
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>NRIC:</strong> <?php echo $nric; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            <p><strong>Gate:</strong> <?php echo $selectedGate; ?></p>
            <p><strong>Level:</strong> <?php echo $selectedLevel; ?></p>
            <p><strong>Seat Section:</strong> <?php echo $seat_section; ?></p>

            <h3>Ticket Summary:</h3>
            <p><strong>Open Adult Tickets:</strong> <?php echo $ticket_type_1; ?> x RM<?php echo number_format($price_open_adult, 2); ?></p>
            <p><strong>Open Child Tickets:</strong> <?php echo $ticket_type_2; ?> x RM<?php echo number_format($price_open_child, 2); ?></p>
            <p><strong>Grandstand Tickets:</strong> <?php echo $ticket_type_3; ?> x RM<?php echo number_format($price_grandstand, 2); ?></p>
            <p><strong>Premium Tickets:</strong> <?php echo $ticket_type_4; ?> x RM<?php echo number_format($price_premium, 2); ?></p>
        </div>
    </div>

    <a href="index.php">Back to Home</a>
</div>

<div class="footer">
    <p>&copy; 2025 Your Company. All Rights Reserved.</p>
</div>

</body>
</html>


