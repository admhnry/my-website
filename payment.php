<?php
session_start();

// Check for critical session data
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

// Check if session variables are set and assign default values if not
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Unknown';
$nric = isset($_SESSION['nric']) ? $_SESSION['nric'] : 'Not provided';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : 'Not provided';
$ticket_type_1 = isset($_SESSION['ticket_type_1']) ? intval($_SESSION['ticket_type_1']) : 0;
$ticket_type_2 = isset($_SESSION['ticket_type_2']) ? intval($_SESSION['ticket_type_2']) : 0;
$ticket_type_3 = isset($_SESSION['ticket_type_3']) ? intval($_SESSION['ticket_type_3']) : 0;
$ticket_type_4 = isset($_SESSION['ticket_type_4']) ? intval($_SESSION['ticket_type_4']) : 0;
$selectedGate = isset($_SESSION['selectedGate']) ? $_SESSION['selectedGate'] : 'Not selected';
$selectedLevel = isset($_SESSION['selectedLevel']) ? $_SESSION['selectedLevel'] : 'Not selected';
$seat_section = isset($_SESSION['seat_section']) ? $_SESSION['seat_section'] : 'Not specified';
$payment_method = isset($_SESSION['payment_method']) ? $_SESSION['payment_method'] : 'Not specified';
$card_number = isset($_SESSION['card_number']) ? $_SESSION['card_number'] : 'Not Specified';
$expiry_date = isset($_SESSION['expiry_date']) ? $_SESSION['expiry_date'] : 'Not Specified';
$cvv = isset($_SESSION['cvv']) ? $_SESSION['cvv'] : 'Not specified';

// Prices for different ticket types
$price_open_adult = 35.50;
$price_open_child = 10.00;    
$price_grandstand = 55.00;
$price_premium = 65.00;

// Calculate the total price
$total_price = ($ticket_type_1 * $price_open_adult) + ($ticket_type_2 * $price_open_child) + ($ticket_type_3 * $price_grandstand) + ($ticket_type_4 * $price_premium);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #141E30, #243B55);
            color: #fff;
            margin: 0;
            padding: 0;
        }
        header {
            background: rgba(0, 0, 0, 0.8);
            color: #FFD700;
            text-align: center;
            padding: 20px;
            font-size: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .container {
            max-width: 700px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            color: #FFD700;
            margin-bottom: 30px;
        }
        .ticket-details {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .ticket-details p {
            font-size: 1.1rem;
            line-height: 1.8;
        }
        label {
            font-size: 1rem;
            color: #FFD700;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"] {
            width: calc(100% - 24px); /* Adjust for padding */
            max-width: 100%; /* Prevent overflow */
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            box-sizing: border-box; /* Ensure padding is included in width */
        }
        button {
            background: #FFD700;
            color: #141E30;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            width: 100%;
        }
        button:hover {
            background: #FFC107;
            transform: scale(1.05);
        }
        .footer {
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 30px;
        }
    </style>
    
</head>
<body>
<header>
    <h1>Payment</h1>
</header>

<div class="container">
    <h2>Complete Your Purchase</h2>

    <div class="ticket-details">
        <?php
        echo "<p><strong>Name:</strong> " . $name . "</p>";
        echo "<p><strong>NRIC:</strong> " . $nric . "</p>";
        echo "<p><strong>Phone:</strong> " . $phone . "</p>";
        echo "<p><strong>Selected Gate:</strong> " . $selectedGate . "</p>";
        echo "<p><strong>Selected Level:</strong> " . $selectedLevel . "</p>";
        echo "<p><strong>Seat Section:</strong> " . $seat_section . "</p>";

        echo "<p><strong>Open Adult Tickets:</strong> " . $ticket_type_1 . " x RM" . $price_open_adult . "</p>";
        echo "<p><strong>Open Child Tickets:</strong> " . $ticket_type_2 . " x RM" . $price_open_child . "</p>";
        echo "<p><strong>Grandstand Tickets:</strong> " . $ticket_type_3 . " x RM" . $price_grandstand . "</p>";
        echo "<p><strong>Premium Tickets:</strong> " . $ticket_type_4 . " x RM" . $price_premium . "</p>";

        echo "<p><strong>Total Price:</strong> RM" . number_format($total_price, 2) . "</p>";
        ?>
    </div>

    <form method="POST" action="process_payment.php">
        <label for="payment_method">Payment Method:</label>
        <div id="payment_method" class="payment-methods">
            <input type="radio" id="visa" name="payment_method" value="Visa" required>
            <label for="visa">Visa</label><br>
        
            <input type="radio" id="mastercard" name="payment_method" value="MasterCard">
            <label for="mastercard">MasterCard</label><br>
        
            <input type="radio" id="amex" name="payment_method" value="American Express">
            <label for="amex">American Express</label><br>
        
            <input type="radio" id="discover" name="payment_method" value="Discover">
            <label for="discover">Discover</label>
        </div>
	</br>
    
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>
    
        <label for="expiry_date">Expiry Date:</label>
        <input type="text" id="expiry_date" name="expiry_date" required>
    
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>
    
        <button type="submit">Pay Now</button>
    </form>
    
    
</div>

<div class="footer">
    <p>&copy; 2025 Football Ticketing System, All Rights Reserved.</p>
</div>

</body>
</html>




