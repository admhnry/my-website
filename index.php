<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Ticketing System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            position: relative; /* Position relative for absolute elements */
            overflow: hidden; /* Hide scrollbars */
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
        .slideshow-container {
            position: absolute; /* Make slideshow absolute */
            top: 0; /* Align to top */
            left: 0; /* Align to left */
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            z-index: 1; /* Send behind header and container */
            overflow: hidden; /* Hide overflow */
        }
        .slides {
            display: none; /* Hide all slides by default */
            width: 100%;
            height: 100%; /* Ensure each slide covers full height */
        }
        .slideshow-container img {
            width: 100%; /* Responsive width */
            height: 100%; /* Full height */
            object-fit: cover; /* Cover the entire area while maintaining aspect ratio */
        }
        .container {
            text-align: center; /* Center text in the container */
            padding: 50px; /* Container padding */
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            margin: 50px auto; /* Center the container */
            width: 80%; /* Container width */
            border-radius: 15px; /* Rounded corners for the container */
            position: relative; /* Keep container in flow */
            z-index: 2; /* Bring to front */
        }
        .container h2 {
            color: #004aad; /* Color for the heading */
        }
        .btn {
            background-color: #28a745; /* Button background color */
            color: white; /* Button text color */
            padding: 15px 30px; /* Button padding */
            text-decoration: none; /* Remove underline from button */
            border-radius: 5px; /* Rounded corners for button */
            font-size: 18px; /* Font size for button */
            display: inline-block; /* Inline block for button */
            margin-top: 20px; /* Margin above button */
        }
        .btn:hover {
            background-color: #218838; /* Button background color on hover */
            transition: 0.3s; /* Smooth transition */
        }
        footer {
            background-color: rgba(0, 53, 128, 0.8); /* Semi-transparent Footer */
            color: white; /* Footer text color */
            text-align: center; /* Center footer text */
            padding: 10px 0; /* Footer padding */
            position: relative; /* Keep footer in flow */
            bottom: 0; /* Position at the bottom */
            width: 100%; /* Full width */
            z-index: 2; /* Bring to front */
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

<div class="slideshow-container">
    <div class="slides">
        <img src="images/bjs.jpeg" alt="Football Stadium 1">
    </div>
    <div class="slides">
        <img src="images/jaliln.jpg" alt="Football Stadium 2">
    </div>
    <div class="slides">
        <img src="images/jd.jpeg" alt="Football Stadium 3">
    </div>
</div>

<div class="container">
    <h2>Welcome to the Football Ticketing System!</h2>
    <p>Get your tickets now and enjoy the excitement of live football matches.</p>
    <p>Stay updated with the latest match schedules and buy tickets online!</p>

    <a href="tickets.php" class="btn">Buy Tickets Now</a>
</div>

<footer>
    <p>&copy; 2024 Football Ticketing System. All rights reserved.</p>
</footer>

<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let slides = document.getElementsByClassName("slides");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none"; // Hide all slides
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1; // Reset to first slide
        }
        slides[slideIndex - 1].style.display = "block"; // Show the current slide
        setTimeout(showSlides, 5000); // Change slide every 3 seconds
    }
</script>

</body>
</html>
