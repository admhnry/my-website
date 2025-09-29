<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Tickets - Football Ticketing System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            position: relative;
            overflow: hidden;
        }
        header {
            background-color: rgba(0, 74, 173, 0.8); /* Semi-transparent Header */
            color: white; /* Header text color */
            padding: 20px 0; /* Header padding */
            text-align: center; /* Center the text */
            position: relative; /* Keep header in flow */
            z-index: 2; /* Bring to front */
        }
        nav {
            display: flex; /* Flexbox for navigation */
            justify-content: center; /* Center navigation items */
            background-color: rgba(0, 53, 128, 0.8); /* Semi-transparent Navigation */
            padding: 10px 0; /* Navigation padding */
            position: relative; /* Keep nav in flow */
            z-index: 2; /* Bring to front */
        }
        nav a {
            color: white; /* Link color */
            padding: 15px 30px; /* Link padding */
            text-decoration: none; /* Remove underline from links */
            text-transform: uppercase; /* Uppercase letters for links */
            font-weight: bold; /* Bold text for links */
            margin: 0 10px; /* Margin between links */
        }
        nav a:hover {
            background-color: #007BFF; /* Background color on hover */
            transition: 0.3s; /* Smooth transition */
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 50px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            margin: 10px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<header>
    <h1>Football Ticketing System</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="tickets.php">Buy Tickets</a>
    <a href="schedule.php">Match Schedule</a>
    <a href="contact.php">Contact Us</a>
    <a href="admin_login.php">Admin Login</a>
    <a href="purchase_history.php">History</a>
</nav>

<div class="container">
    <h2>To buy tickets, please login or register</h2>
    <a href="register.php" class="btn">Register</a>
    <a href="login.php" class="btn">Login</a>
</div>

</body>
</html>