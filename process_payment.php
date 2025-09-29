<?php
session_start();
include 'send_email.php'; // Include the email function
require 'generate_qr.php'; // Include QR code generator
require 'phpqrcode/qrlib.php';
include 'database.php'; 




if (!isset($_SESSION)) {
    header('Location: login.php');
    exit();
}

// Check if session exists, if not, allow access but show a warning message
if (!isset($_SESSION['user_email']) || !isset($_SESSION['name'])) {
    echo "<p>Warning: You are not logged in. Proceeding without session data.</p>";
}

// Sanitize and validate inputs
$card_number = isset($_POST['card_number']) ? preg_replace('/[^0-9]/', '', $_POST['card_number']) : '';
$expiry_date = isset($_POST['expiry_date']) ? htmlspecialchars($_POST['expiry_date']) : '';
$cvv = isset($_POST['cvv']) ? preg_replace('/[^0-9]/', '', $_POST['cvv']) : '';

// Mask credit card number - only keep last 4 digits
// Check if the card number is at least 4 characters long
if (strlen($card_number) >= 4) {
    // Mask all but the last 4 digits of the card number
    $masked_card_number = str_repeat('*', strlen($card_number) - 4) . substr($card_number, -4);
} else {
    // Return the card number as-is if it's less than 4 characters
    $masked_card_number = $card_number;
}


// Get current date for booking
$booking_date = date('Y-m-d H:i:s');

// Securely retrieve session data with validation
$match_details = isset($_SESSION['match_details']) ? 
    htmlspecialchars($_SESSION['match_details']['home_team']) . " vs " . 
    htmlspecialchars($_SESSION['match_details']['away_team']) : 
    'Match information not available';
    
$seat_section = isset($_SESSION['seat_section']) ? htmlspecialchars($_SESSION['seat_section']) : null;

$payment_method = isset($_POST['payment_method']) ? htmlspecialchars($_POST['payment_method']) : 'Not specified';
$_SESSION['payment_method'] = $payment_method;

$stadium_name = isset($_SESSION['match_details']) ? 
    htmlspecialchars($_SESSION['match_details']['stadium']) : 
    'Stadium information not available';


// Secure session data retrieval with validation
$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : null;
$nric = isset($_SESSION['nric']) ? htmlspecialchars($_SESSION['nric']) : null;
$phone = isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : null;
$email = isset($_SESSION['user_email']) ? filter_var($_SESSION['user_email'], FILTER_VALIDATE_EMAIL) : null;

//Ticket Verification purposes
$user_id = isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : null;
$purchase_id = isset($_SESSION['purchase_id']) ? htmlspecialchars($_SESSION['purchase_id']) : null;

// Ensure $user_email is defined
$user_email = $email; // Assign the session email to $user_email

// Check if ticket types are set
$ticket_type_1 = isset($_SESSION['ticket_type_1']) ? intval($_SESSION['ticket_type_1']) : 0;
$ticket_type_2 = isset($_SESSION['ticket_type_2']) ? intval($_SESSION['ticket_type_2']) : 0;
$ticket_type_3 = isset($_SESSION['ticket_type_3']) ? intval($_SESSION['ticket_type_3']) : 0;
$ticket_type_4 = isset($_SESSION['ticket_type_4']) ? intval($_SESSION['ticket_type_4']) : 0;

// Check if gate and level are set
$selectedGate = isset($_SESSION['selectedGate']) ? $_SESSION['selectedGate'] : 'Not selected';
$selectedLevel = isset($_SESSION['selectedLevel']) ? $_SESSION['selectedLevel'] : 'Not selected';
$seat_section = isset($_SESSION['seat_section']) ? $_SESSION['seat_section'] : 'Not specified';

// Prices for different ticket types
$price_open_adult = 35.50;
$price_open_child = 10.00;
$price_grandstand = 55.00;
$price_premium = 65.00;

// Calculate the total price
$total_price = ($ticket_type_1 * $price_open_adult) + ($ticket_type_2 * $price_open_child) + ($ticket_type_3 * $price_grandstand) + ($ticket_type_4 * $price_premium);

// Simulate payment processing (you can replace this with a real payment gateway)
$is_payment_successful = true; // Change this based on the actual payment result

// Prepare email content with a beautiful layout
$email_subject = "Payment Confirmation - Your Ticket Booking";
$email_body = "
<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content h3 {
            color: #333;
        }
        .ticket-summary, .payment-details {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .ticket-summary p, .payment-details p {
            font-size: 14px;
            margin: 5px 0;
        }
        .total-price {
            font-weight: bold;
            font-size: 16px;
            color: #333;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 40px;
        }
        .success {
            color: green;
        }
        .failure {
            color: red;
        }
    </style>
</head>
<body>

<div class='container'>
    <div class='header'>
        <h2>Football Ticketing System</h2>
        <p>Booking Confirmation</p>
    </div>

    <div class='content'>
        <h3>Hello $name,</h3>
        <p>Thank you for your purchase! Your booking has been confirmed.</p>

        <div class='payment-details'>
            <h3>Payment Status:</h3>
            <p class='" . ($is_payment_successful ? 'success' : 'failure') . "'>
                <strong>" . ($is_payment_successful ? 'Payment Successful!' : 'Payment Failed') . "</strong>
            </p>
            <p>Total Amount Paid: RM" . number_format($total_price, 2) . "</p>
        </div>

        <div class='ticket-summary'>
            <h3>Booking Details:</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>NRIC:</strong> $nric</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Gate:</strong> $selectedGate</p>
            <p><strong>Level:</strong> $selectedLevel</p>
            <p><strong>Seat Section:</strong> $seat_section</p>
	    <p><strong>Payment Method:</strong> $payment_method</p>
	    <p><strong>Card Number:</strong> $masked_card_number</p>
	    <p><strong>Match Details:</strong> $match_details</p>
	    <p><strong>Stadium:</strong> $stadium_name</p>
	    <p><strong>Booking Date:</strong> $booking_date</p>

            <h3>Ticket Summary:</h3>
            <p><strong>Open Adult Tickets:</strong> $ticket_type_1 x RM$price_open_adult</p>
            <p><strong>Open Child Tickets:</strong> $ticket_type_2 x RM$price_open_child</p>
            <p><strong>Grandstand Tickets:</strong> $ticket_type_3 x RM$price_grandstand</p>
            <p><strong>Premium Tickets:</strong> $ticket_type_4 x RM$price_premium</p>
        </div>

        <p>We look forward to seeing you at the event!</p>
    </div>

    <div class='footer'>
        <p>&copy; 2025 Football Ticketing. All Rights Reserved.</p>
    </div>
</div>

</body>
</html>
";

$email = isset($_SESSION['user_email']) ? filter_var($_SESSION['user_email'], FILTER_VALIDATE_EMAIL) : null;

// Validate required fields
if (!$username || !$email) {
    header('Location: error.php?message=invalid_session');
    exit();
}

// The QR code filename for email attachment (optional)
$qr_code_data = <<<EOT
Booking Confirmation
---------------------
Name: $name
Status: VERIFIED
Booking Date: $booking_date
Match: $match_details
Gate: $selectedGate
Level: $selectedLevel
Seat Section: $seat_section
Stadium: $stadium_name
User ID: $user_id
Ticket ID: $purchase_id
Thank you for booking with us!
EOT;

$save_path = "path/to/store/qr_codes/";
if (!is_dir($save_path)) {
    mkdir($save_path, 0755, true); // Create the directory if it doesn't exist
}

$qr_code_filename = $save_path . md5($qr_code_data) . ".png";
generateQRCode($qr_code_data, $qr_code_filename);

// Send the registration confirmation email with QR code
$headers = "MIME-Version: 1.0" . "\r\n" .
           "Content-Type: text/html; charset=UTF-8" . "\r\n" .
           "From: no-reply@yourcompany.com" . "\r\n" .
           "Reply-To: support@yourcompany.com" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

// Send the email only if payment is successful
if ($is_payment_successful) {
    sendEmail($email, $email_subject, $email_body, $qr_code_filename);
}

// HTML output for the browser
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
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
        .payment-status {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .payment-status p {
            font-size: 16px;
            margin: 10px 0;
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

    <div class="payment-status">
        <?php
        if ($is_payment_successful) {
            echo "<p class='success'><strong>Payment Successful!</strong></p>";
            echo "<p>Thank you for your purchase, " . htmlspecialchars($name) . ". Your booking has been confirmed.</p>";
            echo "<p><strong>Total Amount Paid:</strong> RM" . number_format($total_price, 2) . "</p>";
        } else {
            echo "<p class='failure'><strong>Payment Failed</strong></p>";
            echo "<p>Please try again or contact support.</p>";
        }
        ?>

        <h3>Booking Details:</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>NRIC:</strong> <?php echo htmlspecialchars($nric); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        <p><strong>Gate:</strong> <?php echo htmlspecialchars($selectedGate); ?></p>
        <p><strong>Level:</strong> <?php echo htmlspecialchars($selectedLevel); ?></p>
        <p><strong>Seat Section:</strong> <?php echo htmlspecialchars($seat_section); ?></p>
	<p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
	<p><strong>Card Number:</strong> <?php echo htmlspecialchars($masked_card_number); ?></p>
	<p><strong>Expiry Date:</strong> <?php echo htmlspecialchars($expiry_date); ?></p>
	<p><strong>CVV:</strong> <?php echo htmlspecialchars($cvv); ?></p>

        <h3>Ticket Summary:</h3>
        <p><strong>Open Adult Tickets:</strong> <?php echo $ticket_type_1; ?> x RM<?php echo $price_open_adult; ?></p>
        <p><strong>Open Child Tickets:</strong> <?php echo $ticket_type_2; ?> x RM<?php echo $price_open_child; ?></p>
        <p><strong>Grandstand Tickets:</strong> <?php echo $ticket_type_3; ?> x RM<?php echo $price_grandstand; ?></p>
        <p><strong>Premium Tickets:</strong> <?php echo $ticket_type_4; ?> x RM<?php echo $price_premium; ?></p>
    </div>

    <a href="index.php">Back to Home</a>
</div>

<div class="footer">
    <p>&copy; 2025 Football Ticketing. All Rights Reserved.</p>
</div>

</body>
</html>



