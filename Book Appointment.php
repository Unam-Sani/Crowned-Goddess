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
</head>
<body>
<?php include 'header.php'; ?>
<div class="main">
    <div class="banner">
        <h3>Bookings</h3>
    </div>
    
    <section class="checkout">
            <div class="title">
                <img src="logo.png" class="logo">
                <h1>Home Booking</h1>
                <p>Please specify your details and the location you want to meet the hairstylists.</p>
            </div>
    <div class="row">
        <form id="bookingForm" method="POST" action="book.php" style="display: flex; flex-direction: column;">
            <h3>Customer Information</h3>
            <div class="flex">
                <div class="box">
                    <div class="input-field">
                        <p>Your Name<span>*</span></p>
                        <input type="text" id="name" name="name" required maxlength="50" placeholder="Enter Your name" class="input"> 
                    </div>
                    <div class="input-field">
                        <p>Your Number<span>*</span></p>
                        <input type="text" name="number" required maxlength="10" placeholder="Enter Your number" class="input" min="10" max="10"> 
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
                        <p>Address Line 01<span>*</span></p>
                        <input type="text" name="flat" required maxlength="50" placeholder="e.g., Flat & Building Number" class="input"> 
                    </div>
                    <div class="input-field">
                        <p>Address Line 02<span>*</span></p>
                        <input type="text" name="street" required maxlength="50" placeholder="e.g., Street Name" class="input"> 
                    </div>
                </div>
                <div class="box">
                    
                   
                    <div class="input-field">
                        <p>City Name<span>*</span></p>
                        <input type="text" name="city" required maxlength="50" placeholder="Enter City Name" class="input"> 
                    </div>
                    <div class="input-field">
                        <p>Country<span>*</span></p>
                        <input type="text" name="country" required maxlength="50" placeholder="Enter Country Name" class="input"> 
                    </div>
                    <div class="input-field">
                        <p>Postal code<span>*</span></p>
                        <input type="text" name="pincode" required maxlength="6" placeholder="110022" class="input"> 
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
                    <button type="submit" class="btn">place order</button>
                </div>
            </div>
        </form>
    </div>
</div>
    </section>
<?php include 'footer.php'; ?> <!-- Include your footer.php file -->
<?php include 'alert.php'; ?>

</script>
</body>
</html>
