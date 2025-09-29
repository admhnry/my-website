<?php
require 'vendor/autoload.php';
include('database.php');

function sendEmail($userEmail, $subject, $body, $qrCodePath) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'adamhenri21@gmail.com';
        $mail->Password = 'olfcwezh pweqigto'; // App-specific password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('adamhenri21@gmail.com', 'Ticketing System');
        $mail->addAddress($userEmail);

        // Attach QR code image
        if (file_exists($qrCodePath)) {
            $mail->addEmbeddedImage($qrCodePath, 'qr_code');
        }

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


?>





		