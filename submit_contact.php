<?php
include 'send_email.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Prepare email content
    $subject = "Contact Form Submission - Football Ticketing System";
    $email_content = "
    <html>
    <head>
        <style>
            body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
            .header { text-align: center; background-color: #333; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; }
            .header h2 { margin: 0; }
            .content { padding: 20px; }
            .content h3 { color: #333; }
            .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        </style>
    </head>
    <body>
    <div class='container'>
        <div class='header'>
            <h2>Football Ticketing System</h2>
            <p>Contact Form Submission</p>
        </div>
        <div class='content'>
            <h3>Hello $name,</h3>
            <p>Thank you for reaching out to us. Here is a copy of your message:</p>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
            <p>We will get back to you shortly.</p>
        </div>
        <div class='footer'>
            <p>&copy; 2024 Football Ticketing System. All rights reserved.</p>
        </div>
    </div>
    </body>
    </html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@yourcompany.com" . "\r\n" .
                "Reply-To: support@yourcompany.com" . "\r\n" .
                "X-Mailer: PHP/" . phpversion();

    // Send email using the sendEmail() function
    $send_success = sendEmail($email, $subject, $email_content, $headers);

    // Check if the email was sent successfully and set the confirmation message
    if ($send_success) {
        $confirmation = "Thank you for your message, $name! We will get back to you shortly.";
    } else {
        $confirmation = "Sorry, there was an error sending your message. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Submission Status</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            margin: 50px auto;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #004aad;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #004aad;
            padding: 10px 20px;
            border-radius: 5px;
        }
        a:hover {
            background-color: #003580;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Contact Us - Submission Status</h1>
    <p><?php echo $confirmation; ?></p>
    <a href="index.php">Back to Home</a>
</div>

</body>
</html>

