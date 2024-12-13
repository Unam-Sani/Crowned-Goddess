<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script src="emailjs-config.js" defer></script> <!-- Include the initialization script -->
    <script src="script.js" defer></script> <!-- Include your main script -->
    <title>Salon Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 100%;
            max-height: auto;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        img {
            max-width: 70%;
            height: auto;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            font-size: 18px;
            line-height: 1.6;
        }
        .buttons {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<?php include 'header.php'; ?>
<br><br><br><br><br><br><br><br><br>
    <div class="container">
        <img src="logo.png" alt="Salon Logo">
        <h1>Welcome to Our Salon</h1>
        <p>We offer you the best salon experience either at our salon or in the comfort of your own home. 
            Choose whichever you are comfortable with and let us take care of the rest.</p>
        <div class="buttons">
            <a href="book.php" class="button">Salon Booking</a>
            <a href="SalonBooking.php" class="button">Home  Booking</a>
        </div>
    </div>
</body>
</html>
