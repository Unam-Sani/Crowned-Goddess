<?php 
include 'connection.php'; 
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
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
    <title> Crowned Goddess - Home Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /*------------------About section---------------*/
        .about-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }
        .about-content h2 {
            text-align: center;
            color: #6b8e23;
        }
        .about-content p {
            text-align: center;
            color: #333;
        }
        .stylist {
            text-align: center;
            margin-top: 2rem;
        }
        .stylist img {
            border-radius: 50%;
            width: 250px;
            height: 250px;
            object-fit: cover;
        }
        .stylist h3 {
            margin: 0.5rem 0;
        }
        .stylist p {
            color: #777;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <br><br>
    <div class="main">
        <section class="home-section"> 
            <div class="slider">
                <div class="slider_slider slide1">
                    <div class="overlay"></div>
                    <div class="slide-detail"> 
                        <h1>Welcome to Crowned Goddess Salon</h1>
                        <br><br><br>
                        <a href="book.php" class="btn">Book Now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>

                <div class="slider_slider slide2">
                    <div class="overlay"></div>
                    <div class="slide-detail"> 
                        <h1>Welcome to Crowned Goddess Salon</h1>
                        <p>Own Your Crown</p>
                        <br><br><br>
                        <a href="book.php" class="btn">Book Now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>

                <div class="slider_slider slide3">
                    <div class="overlay"></div>
                    <div class="slide-detail"> 
                        <h1>Welcome to Crowned Goddess Salon</h1>
                        <p>Unlock your glam</p>
                        <br><br>
                        <a href="book.php" class="btn">Book Now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div> 

                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div>
        </section>
        <!--home slider end-->

        <!--images that rotate-->
        <section class="thumb"> 
            <div class="box-container">
                <div class="box">
                    <img src="Images/Icons/2.png" alt="Green Tea Thumbnail">
                    <h3>Soft Curly Afro</h3>
                    <p>Treat your natural hair. We also unbraid hair.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>

               <div class="box">
                    <img src="Images/Icons/4.png" >
                    <h3>Luscious Curls</h3>
                    <p>Come and get yourself luscious braiding curls</p>
                    <i class="bx bx-chevron-right"></i>
                </div>

                <div class="box">
                    <img src="Images/Icons/3.jpg" >
                    <h3>Sleek and Chic </h3>
                    <p> Perfect, neat Ponytails for Every Occasion</p>
                    <i class="bx bx-chevron-right"></i>
                </div>

                <div class="box">
                    <img src="Images/Icons/5.jpg" alt="Green Tea Thumbnail">
                    <h3>Silky waves</h3>
                    <p>Luxurious waves that cascade down like silk.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
            </div>
        </section>

        <section class="shop">
            <div class="title">
                <img src="logo - Copy.png" alt="Download Image">
                <h1>Trending </h1>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="Images/Hairstyles/4.jpg" alt="Card Image">
                    <a href="book.php" class="btn">Book Now</a>
                </div>
                <div class="box">
                    <img src="Images/Hairstyles/5.jpg" alt="Card Image 0">
                    <a href="book.php" class="btn">Book Now</a>
                </div>
                <div class="box">
                    <img src="Images/Hairstyles/6.jpg" alt="Card Image 1">
                    <a href="book.php" class="btn">Book Now</a>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="about-content">
            <br><br>
                <h2>About Us</h2>
                <p>Welcome to Crowned Goddess Hair Salon, your local destination for exceptional hair care services. Founded over 5 years ago, our salon has been dedicated to helping our clients look and feel their best. Located at 69 Hamlin Street, Hawkins, Norwood, we provide a warm and welcoming atmosphere where your beauty and comfort are our top priorities.</p>
                <br><br>
                <h2>Our Philosophy</h2>
                <p>At Crowned Goddess Hair Salon, we believe that everyone deserves to feel like royalty. We are committed to providing personalized hair care services that enhance your natural beauty. Our skilled stylist stays updated with the latest trends and techniques to ensure you receive the highest quality of care and attention.</p>
                <br><br>
                <h2>Meet Our Stylist</h2>
                <div class="image-row">
                <div class="stylist">
                    <img src="Clementine_Profile.jpg" alt="Stylist Image">
                    </div>
                    <br><br>
                    <h2>Clementine Swate</h2>
                    <p>Founder & Lead Stylist</p>
                    <br><br>
                    <p>Our founder and lead stylist, has over 5 years of experience in the hair care industry. Clementine excels in all aspects of hair styling, from cutting and coloring to intricate braiding and treatments. Her passion for hair care and commitment to her clients ensures that everyone leaves the salon feeling confident and beautiful.</p>
                </div>
<br><br>
                <h2>Our Services</h2>
                <p>We offer a comprehensive range of hair care services, including haircuts, styling, coloring, braiding, and treatments. Whether you're looking for a classic style or something more contemporary, Jane is here to help you achieve the perfect look that suits your personality and lifestyle</p>
                <br><br><h2>Contact Us</h2>
                <p>If you have any questions or would like to book an appointment, please don't hesitate to contact us at 0734261119. We look forward to welcoming you to Crowned Goddess Hair Salon and helping you look and feel your best</p>
            </div>
        </div>

    <section class="brand">
            <div class="title">
                <img src="Images/Logo.jpg" alt="Download Image">
               <a href><h1>More Hair style inspiration </h1></a> 
               Press on an image to see more hairstyles.
            </div>
            <div class="image-row">
               <a href="view_products.php">
               <img src="Images/Hairstyles/24.jpg" alt="Image 1" class="circular-image">
                <img src="Images/Hairstyles/25.jpg" alt="Image 2" class="circular-image">
                <img src="Images/Hairstyles/26.jpg" alt="Image 3" class="circular-image">
                <img src="Images/Hairstyles/27.jpg" alt="Image 4" class="circular-image">
                <img src="Images/Hairstyles/31.jpg" alt="Image 5" class="circular-image">
                <img src="Images/Hairstyles/29.jpg" alt="Image 6" class="circular-image">
    </a>
            </div>

        </section>

        <?php include 'footer.php'; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 
        <script src="script.js"></script>
        <?php include 'alert.php'; ?>
    </div>
</body>
</html>
