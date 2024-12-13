<?php
// Include the database connection file
include_once 'connection.php';

// Start session only if it hasn't started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize user ID variable
$user_id = $_SESSION['user_id'] ?? null;

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle logout
if (isset($_POST['logout'])) {
    if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        session_destroy();
        header('Location: login.php');
        exit;
    } else {
        echo "CSRF token mismatch.";
        exit;
    }
}
// Counting wishlist items
$total_wishlist_items = 0;
if ($user_id) {
    $count_wishlist_items = $conn->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ?");
    if ($count_wishlist_items->execute([$user_id])) {
        $total_wishlist_items = $count_wishlist_items->fetchColumn();
    }
}
// Counting cart items
$total_cart_items = 0;
if ($user_id) {
    $count_cart_items = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
    if ($count_cart_items->execute([$user_id])) {
        $total_cart_items = $count_cart_items->fetchColumn();
    }
}
?>
<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="Images/Hairstyles_clients/Logo.png" alt="Company Logo"></a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="bookings.php">Book</a>
            <a href="view_products.php"> Services</a>
            <a href="wishlist.php">wishlist</a>
            <a href="order.php">History</a>
            <a href="contact.php">Contact Us</a>
            <a href="login.php">Login</a>
        </nav>
        <div class="icons"> <!--the wishlist (heart-icon), cart, and eye icon-->

            <a href="wishlist.php" class="cart-btn">
                <i class="bx bx-heart"></i><sup><?= $total_wishlist_items ?></sup>
            </a>
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        </div>
    <div class="user-box">
        <p>Username: <span><?= htmlspecialchars($_SESSION['user_name'] ?? 'Guest'); ?></span></p>
        <p>Email: <span><?= htmlspecialchars($_SESSION['user_email'] ?? 'Not logged in'); ?></span></p>
        <?php if ($user_id): ?>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <button type="submit" name="logout" class="logout-btn">Log Out</button>
            </form>
        <?php else: ?>
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
        <?php endif; ?>
    </div>
</header>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="path/to/script.js"></script>
