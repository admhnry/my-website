

<?php
session_start();

// Sanitize the error message from URL
$error_message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Unknown error';

// Map error codes to user-friendly messages
$error_messages = [
    'invalid_session' => 'Your session has expired or is invalid. Please log in again.',
    'payment_failed' => 'Payment processing failed. Please try again.',
    'invalid_data' => 'Invalid or missing information. Please check your details.',
    'system_error' => 'A system error occurred. Please try again later.',
    'default' => 'An unexpected error occurred. Please try again.'
];

// Get appropriate message or default if message type not found
$display_message = isset($error_messages[$error_message]) ? 
    $error_messages[$error_message] : 
    $error_messages['default'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Football Ticketing System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .error-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        .error-icon {
            color: #dc3545;
            font-size: 48px;
            margin-bottom: 1rem;
        }
        .error-title {
            color: #dc3545;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #666;
            margin-bottom: 2rem;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .support-info {
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">??</div>
        <h1 class="error-title">Oops! Something went wrong</h1>
        <div class="error-message">
            <?php echo $display_message; ?>
        </div>
        <div>
            <a href="index.php" class="button">Return to Homepage</a>
        </div>
        <div class="support-info">
            <p>If you continue to experience issues, please contact our support team:</p>
            <p>Email: support@footballticketing.com</p>
            <p>Phone: 1-800-FOOTBALL</p>
        </div>
    </div>

    <?php
    // If it's a session error, clear the session
    if ($error_message === 'invalid_session') {
        session_destroy();
    }
    ?>
</body>
</html>
