<?php
// Start the session
session_start();
require_once('database.php');

$_SESSION['ticket_type_1'] = $_POST['ticket_type_1'];
$_SESSION['ticket_type_2'] = $_POST['ticket_type_2'];
$_SESSION['ticket_type_3'] = $_POST['ticket_type_3'];
$_SESSION['ticket_type_4'] = $_POST['ticket_type_4'];

// Calculate total quantity
$_SESSION['total_quantity'] = (int)$_SESSION['ticket_type_1'] + 
                             (int)$_SESSION['ticket_type_2'] + 
                             (int)$_SESSION['ticket_type_3'] + 
                             (int)$_SESSION['ticket_type_4'];
			     
header("Location: seatsection.php");
exit();
?>


