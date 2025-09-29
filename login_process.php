<?php
session_start();
require 'send_email.php';  // Include the email sending script

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "football_tickets";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id']; // Ensure user_id is set in the session
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_email'] = $row['email']; // Set the user's email in the session

            // Send login confirmation email with an optional attachment argument
            $subject = 'Welcome Back to Football Ticketing System';
            $body = "Hi $username, <br>You just logged in.";
            sendEmail($row['email'], $subject, $body, null);  // Pass `null` for the 4th argument

            // Redirect after successful login
            header("Location: tickbox.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found!";
    }
}

$conn->close();
?>








