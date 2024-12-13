<style>
    footer {
    background-color: #333;
    color: white;
    padding: 20px;
    position: relative;
}

.footer-content {
    max-width: 1200px;
    margin: auto;
    display: flex;
    flex-direction: column;
}

.inner-footer {
    display: flex;
    justify-content: space-between;
}

.card {
    flex: 1;
    margin: 20px;
}

.card h3 {
    margin-bottom: 10px;
}

.card ul {
    list-style: none;
    padding: 0;
}

.card ul li {
    margin: 5px 0;
}

.card a {
    color: white;
    text-decoration: none;
}

.card a:hover {
    text-decoration: underline;
}

.bottom-footer {
    text-align: center;
    margin-top: 20px;
}

.social-links a {
    color: white;
    font-size: 24px;
    margin: 0 10px;
}

.social-links a:hover {
    color: #aaa;
}

</style>
<footer>
    <div class="overlay"></div>
    <div class="footer-content">
        <div class="inner-footer">
            <div class="card">
                <h3>About Us</h3>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="card">
                <h3>Services</h3>
                <ul>
                    <li><a href="view_products.php">Order Now</a></li>
                    <li><a href="view.php">Order History</a></li>
                </ul>
            </div>
            <div class="card">
                <h3>Newsletter</h3>
                <p>Sign Up for Newsletter</p>
                <div class="social-links">
                    <a href="#"><i class="bx bxl-instagram"></i></a>
                    <a href="#"><i class="bx bxl-twitter"></i></a>
                    <a href="#"><i class="bx bxl-youtube"></i></a>
                    <a href="#"><i class="bx bxl-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <p>All rights reserved - Clementine Swate</p>
        </div>
    </div>
</footer>
