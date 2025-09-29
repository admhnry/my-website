<?php
// Database configuration
$db_host = 'localhost';
$db_name = 'football_tickets';
$db_user = 'root';  // Change if you have a different username
$db_pass = '';      // Change if you have set a password

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>