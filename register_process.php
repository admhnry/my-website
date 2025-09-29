<?php
session_start();
require 'send_email.php';  // Include the email sending script
require 'generate_qr.php'; // Include the QR code generation script

// Database connection
$servername = "localhost";
$db_username = "root"; 
$db_password = ""; 
$dbname = "football_tickets"; 

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate and sanitize input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = validateInput($_POST['username']);
    $email = validateInput($_POST['email']);
    $password = validateInput($_POST['password']);
    
    // After successful registration (add this part)
        $_SESSION['user_email'] = $email;
        $_SESSION['name'] = $username;

    // Validate inputs
    if (strlen($username) < 3) {
        echo "Username must be at least 3 characters long.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user'; // Default role

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
    
        $user_id = $stmt->insert_id;
	
        // Set session variable to indicate user is logged in
        $_SESSION['username'] = $username;
	$_SESSION['user_id'] = $user_id;
	 echo "User  ID set in session: " . $_SESSION['user_id']; // Debugging line
        $_SESSION['role'] = $role; // Store user role in session
	$_SESSION['user_email'] = $email; // Set the user's email in the session

        // Generate QR code for registration
        $qr_code_data = "Registration successful for $username";
        $qr_code_filename = "path/to/store/qr_codes/" . md5($qr_code_data) . ".png";
        generateQRCode($qr_code_data, $qr_code_filename);

        // Send registration confirmation email with QR code
        $subject = 'Welcome to Ticketing System';
        $body = "Hi $username, <br>Thank you for registering at Ticketing System.<br>Here is your QR code.";
        sendEmail($email, $subject, $body, $qr_code_filename);

        // Redirect to the buy tickets page
        header("Location: buy_tickets.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>




