<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information Form</title>
    <style>
        /* Your existing styles here... */
    </style>
</head>
<body>

<!-- Header Section -->
<div class="header">
    User Information
</div>

<div class="container">
    <h2>User Information Form</h2>
    <form method="post" action="submit_info.php">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label for="nric">NRIC Number</label>
            <input type="text" id="nric" name="nric" placeholder="Enter your NRIC number" inputmode="numeric" pattern="[0-9]+" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" inputmode="numeric" pattern="[0-9]+" required>
        </div>

        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
