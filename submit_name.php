<?php
// In submit_name.php (the action of the form in name.html)
session_start();  // Always start the session first

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store form data in session variables
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['nric'] = $_POST['nric'];
    $_SESSION['phone'] = $_POST['phone'];
    
    // Debug - you can remove this later
    var_dump($_SESSION);
    
    // Redirect to payment page
    header('Location: payment.php');
    exit();
} else {
    // If someone tries to access this page directly without POST data
    header('Location: name.html');
    exit();
}
?>
