<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Football Ticketing System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            background: url('images/bg.jpg') no-repeat center fixed;
            background-size: cover;
            color: #333;
        }
        header {
            background-color: #004aad;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #003580;
            padding: 10px 0;
        }
        nav a {
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0 10px;
        }
        nav a:hover {
            background-color: #007BFF;
            transition: 0.3s;
        }
        .container {
            text-align: center;
            padding: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            margin: 50px auto;
            width: 80%;
            border-radius: 15px;
        }
        h2 {
            color: #004aad;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input, textarea {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
            transition: 0.3s;
        }
        footer {
            background-color: #003580;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h1>Contact Us</h1>
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
    <h2>Get in Touch</h2>
    <p>If you have any questions, feel free to reach out to us!</p>
    <form action="submit_contact.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <input type="submit" value="Send Message">
    </form>
</div>

<footer>
    <p>&copy; 2024 Football Ticketing System. All rights reserved.</p>
</footer>

</body>
</html>