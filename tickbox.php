<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            width: 100%;
            text-align: center;
            font-size: 24px;
        }

        .container {
            margin-top: 20px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
            color: #333;
        }

        .terms-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            background-color: #fafafa;
            border-radius: 5px;
            line-height: 1.6;
        }

        .terms-section p {
            margin: 10px 0;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .error-message {
            color: #d9534f;
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<header>Ticket Purchase System</header>

<div class="container">
    <h2>Terms and Conditions</h2>
    <h2>SILA BACA DENGAN TELITI!</h2>

    <div class="terms-section">
        <p><strong>PERINGATAN:</strong> Segala risiko pembelian tiket (E-Tiket) atas talian hendaklah difahami dan dipatuhi oleh PEMBELI. Sebelum membuat pembelian, pastikan anda telah memahami dan komited untuk mematuhi segala terma dan syarat yang telah ditetapkan.</p>

        <p><strong>PROSEDUR OPERASI STANDARD (SOP): KEMASUKAN PENONTON KE STADIUM</strong></p>
        <ul>
            <li>Kehadiran penonton/ penyokong adalah dibenarkan TANPA mengira had umur dan status vaksinasi.</li>
            <li>Tunjukkan status risiko Covid-19 di MySejahtera kepada petugas keselamatan.</li>
            <li>Individu dengan status HIGH RISK tidak dibenarkan memasuki stadium.</li>
        </ul>

        <p><strong>TERMA DAN SYARAT: PEMBELIAN E-TIKET ATAS TALIAN</strong></p>
        <ul>
            <li>Log masuk akaun Tickethotline untuk membuat pembelian.</li>
            <li>Satu akaun hanya boleh membeli empat (4) keping tiket sahaja.</li>
            <li>TIADA BAYARAN BALIK selepas pembelian dilakukan.</li>
        </ul>

        <p><strong>PEMBAYARAN BALIK:</strong> Jika perlawanan dibatalkan, hanya harga asas tiket akan dikembalikan.</p>
    </div>

    <form method="post">
        <div class="checkbox-container">
            <input type="checkbox" id="agree" name="agree">
            <label for="agree">I understand and agree to the terms and conditions.</label>
        </div>
        <input type="submit" value="Continue">
    </form>

    <?php
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if the checkbox is checked
        if (isset($_POST['agree'])) {
            // Redirect to trytry.html
            header("Location: buy_tickets.php");
            exit; // Important: Stop further execution after redirect
        } else {
            echo "<p class='error-message'>You must agree to the terms and conditions to continue.</p>";
        }
    }
    ?>
</div>

</body>
</html>