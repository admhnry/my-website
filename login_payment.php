<?php
session_start(); // Start the session

// If the user is already logged in, redirect to the next page (like 'buy_tickets.php')
if (isset($_SESSION['user_email'])) {
    header('Location: process_payment.php');
    exit();
}

// Define some variables
$email = '';
$password = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form inputs
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Sample validation logic (You should replace this with actual authentication)
    if (empty($email) || empty($password)) {
        $error = 'Both fields are required!';
    } else {
        // For demonstration purposes, we're just checking if the email is 'user@example.com' and password is 'password123'
        // Replace with your actual authentication logic (e.g., querying the database)
        if ($email === 'adamhenri21@gmail.com' && $password === 'password123') {
            // Set session variables if authentication is successful
            $_SESSION['user_email'] = $email;
            // Redirect to the next page
            header('Location: buy_tickets.php');
            exit();
        } else {
            $error = 'Invalid email or password. Please try again.';
        }
    }
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #ff4d4d;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            margin: 20px 0;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #ff4d4d;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login Required</h1>
        <p>You need to log in first before proceeding to payment. Please log in to continue your purchase.</p>';

if ($error) {
    echo '<p class="error-message">' . $error . '</p>';
}

echo '<form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your email" value="' . htmlspecialchars($email) . '" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit">Login</button>
      </form>
    </div>
</body>
</html>';
?>
