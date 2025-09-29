<?php
// Start session
session_start();

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: login_history.php"); // Replace with your login page URL
exit();
?>
