<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Football Ticketing System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            background-image: url('images/football_bg.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
        }
        header {
            background-color: #004aad;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            margin: 50px auto;
            padding: 50px;
            width: 80%;
            text-align: center;
            border-radius: 15px;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .link {
            margin-top: 20px;
            display: block;
        }
    </style>
</head>
<body>

<header>
    <h1>User Registration</h1>
</header>

<div class="container">
    <form action="register_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </form>
    <a href="login.php" class="link">Already have an account? Login here.</a>
</div>

</body>
</html>