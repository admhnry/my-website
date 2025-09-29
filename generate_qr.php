<?php
function generateQRCode($data, $filename) {
    $directory = dirname($filename);
    
    // Create the directory if it doesn't exist
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);  // Create directory with proper permissions
    }
    
    // Encode the data for the QR code
    $encodedData = urlencode($data);
    
    // Create the API URL for GoQR.me (size of the QR code can be adjusted)
    $url = "http://api.qrserver.com/v1/create-qr-code/?data=$encodedData&size=300x300";
    
    // Get the image from the API URL and save it to the file
    file_put_contents($filename, file_get_contents($url));
}
?>






		