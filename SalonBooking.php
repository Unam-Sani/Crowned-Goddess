<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script src="emailjs-config.js" defer></script> <!-- Include the initialization script -->
    <script src="script.js" defer></script> <!-- Include your main script -->
    <?php include 'header.php'; ?> <!-- Include your header.php file -->
</head>
<body>
<div class="main">
    <div class="banner">
        <h3>Bookings</h3>
    </div>
    
    <section class="checkout">
            <div class="title">
                <img src="logo.png" class="logo">
                <h1>Salon Booking</h1>
                <p>We are delighted to offer you a seamless and convenient way to schedule your hair appointments. 
                    Simply enter the date and time you wish to visit, and we'll take care of the rest. Whether you need a fresh cut, 
                    color treatment, or styling, our skilled professionals are ready to provide you with exceptional service.
                     Choose your preferred date and time, and let us make you look and feel your best. We look forward to seeing you soon! 
                    Please come to 69 Hamlin street, Hawkins for your booking and mire information is at the bottom</p>
            </div>
    <div class="row">
        <form id="bookingForm" method="POST" action="process_booking.php" style="display: flex; flex-direction: column;">
            <h3>Customer Information</h3>
            <div class="flex">
                <div class="box">
                    <div class="input-field">
                        <p>Your Name<span>*</span></p>
                        <input type="text" id="name" name="name" required maxlength="50" placeholder="Enter Your name" class="input"> 
                    </div>
                    <div class="input-field">
                        <p>Your Number<span>*</span></p>
                        <input type="text" name="number" required maxlength="10" placeholder="Enter Your number" class="input"> 
                    </div>
                    <div class="input-field">
                        <p>Your Email<span>*</span></p>
                        <input type="email" id="email" name="email" required placeholder="Enter email address" class="input">
                    </div>
                    <div class="input-field">
                        <p>Payment Method <span>*</span></p>
                        <select name="method" class="input">
                            <option value="cash on delivery">Cash on Delivery</option>
                            <option value="credit or debit card">Credit or Debit Card</option>
                            <option value="net banking">Net Banking</option>
                            <option value="paytm">UPI or PayPal</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <p>Address Type<span>*</span></p>
                        <select name="address_type" class="input">
                            <option value="home">Home</option>
                            <option value="office">Office</option>
                            <option value="apartment">Apartment</option>
                        </select> 
                    </div>
             
                    <div class="input-field">
                        <label for="date">Appointment Date:</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    
                    <div class="input-field">
                        <label for="time">Choose a time:</label>
                        <select name="time" id="time" required>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Place Order</button>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
    </section>
<?php include 'footer.php'; ?> <!-- Include your footer.php file -->
<?php include 'alert.php'; ?>
</body>
</html>
