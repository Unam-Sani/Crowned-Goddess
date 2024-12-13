<?php 
include 'connection.php'; 
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    $user_id ='';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Crowned Goddess - Contact Page</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'header.php'; ?>
</head>
<body>
    <br><br><br><br><br>
<div class="main">
<div class="banner">
    <h1>Contact Us</h1>
</div>
<div class="title2">
<a href="home.php">HOME </a><span> | Contact us</span>
</div>
<section class="services">
      <div class="box-container">
        <div class="box">
          <img src="img/icon.png" alt="icon.png">
          <div class="detail">
          <h3>great savings</h3>
          <p>Affordable prices</p>
          </div>
        </div>
        <div class="box">
          <img src="img/icon1.png" alt="icon1.png">
          <div class="detail">
          <h3>24*7</h3>
          <p>Make booking at anytime</p>
          </div>
        </div>
          <div class="box">
          <img src="img/icon0.png" alt="icon0.png">
          <div class="detail">
          <h3> Premium Quality</h3>
          <p>best materials and techniques </p>
          </div>
          </div>
          <div class="box">
          <img src="img/icon.png" alt="icon.png">
          <div class="detail">
          <h3>At Home bookings</h3>
          <p>Home appointments</p>
          </div>
        </div>
      </div>

    </section>

    <p>Looking to book an appointment? Give us a call or send us an email to schedule your visit. We can’t wait to help you achieve your dream hairstyle!</p>

<div class="form-container">
    <form method="post">
        <div class="title">
            <img src="logo.png" class="logo">
            <h1>leave a message</h1>
        </div>

        <div class="input-field">
            <p>your name<p>
            <input type="text" name="name" placeholder="enter your name" >
        </div>

        <div class="input-field">
            <p>your email</p>
            <input type="text" name="email" placeholder="enter your email" >
        </div>

        <div class="input-field">
            <p>your number</p>
            <input type="text" name="number" placeholder="enter your number" >
        </div>

        <div class="input-field">
            <p>your message</p>
           <textarea name="message"></textarea>
        </div>
        <button type="submit" name="submit-btn" class="btn"> send message</button>
    </form>

</div>

<div class = "address">

<div class = "title">
<img src="logo.png" class="logo">
<h1>Contact Detail</h1>
<p>Have a question or need more information? Don’t hesitate to reach out! Our friendly and knowledgeable team is here to assist you. We aim to respond to all inquiries within 24 hours </p>
</div>

<div class="box-container">
    <div class="box">
<i class = "bx bxs-map-pin"></i>
<div>
    <h4>address</h4>
    <p> 69 Hamlin street, Hawkin</p>
</div>
</div>

<div class="box">
<i class="bx bxs-phone-call"></i>
<div>
    <h4>073 432 5119</h4>
</div>
</div>

<div class="box">
    <i class="bx bxs-envelope"></i>
    <div>
    <h4>email</h4>
    <p>Clementine@CrownedGodess.co.za</p>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 
<script src="script.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
