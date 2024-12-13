<?php 
include_once 'connection.php'; 
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit;
}

// Example usage where you might need to check for 'wishlist_id'
if (isset($_POST['wishlist_id'])) {
    $wishlist_id = $_POST['wishlist_id'];
    // Your logic using $wishlist_id
} else {
    $wishlist_id = ''; // Or handle the case where 'wishlist_id' is not set
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:order.php');
    exit;
}

if (isset($_POST['cancel'])) {
    // Correct the SQL query to use 'id' instead of 'order_id'
    $update_order = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $update_order->execute(['canceled', $get_id]);
    header('location:order.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - Order Detail</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main">
        <div class="container">
            <h1>Order Detail</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span> | Order Detail</span>
        </div>

        <section class="orders">
            <div class="title">
                <img src="img/download.png" class="logo" alt="download/png">
                <h1>Order Detail</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac justo euismod, tincidunt nunc vel, venenatis urna.</p>
            </div>

            <div class="box-container">
                <?php
                $grand_total = 0;
                // Correct the SQL query to use 'id' instead of 'order_id'
                $select_orders = $conn->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1"); // Changed 'order' to 'orders'
                $select_orders->execute([$get_id]);
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        $select_product = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
                        $select_product->execute([$fetch_order['product_id']]);
                        if ($select_product->rowCount() > 0) {
                            while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                                $grand_total += $sub_total;
                                ?>
                                <div class="box">
                                    <div class="col">
                                        <p class="title"><i class="bx bx-calendar"></i><?= $fetch_order['date']; ?></p>
                                        <img src="<?= $fetch_product['image'] ?>" alt="image" class="image">
                                        <p class="price"><?= $fetch_product['price']; ?> x <?= $fetch_order['qty']; ?></p>
                                        <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                        <p class="grand-total">Total amount payable: R <span><?= $grand_total; ?></span></p>
                                    </div>

                                    <div class="col">
                                        <p class="title">Billing Address</p>
                                        <p class="user"><i class="bx bx-user"></i><?= $fetch_order['name']; ?></p>
                                        <p class="user"><i class="bx bx-envelope"></i><?= $fetch_order['email']; ?></p>
                                        <p class="user"><i class="bx bx-map"></i><?= $fetch_order['address']; ?></p>

                                        <p class="title">Status</p>
                                        <p class="status" style="color:<?php if ($fetch_order['status'] == 'delivered') { echo 'green'; } elseif ($fetch_order['status'] == 'cancelled') { echo 'red'; } else { echo 'orange'; } ?>"><?= $fetch_order['status']; ?></p>

                                        <?php if ($fetch_order['status'] == 'cancelled') { ?>
                                            <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Order Again</a>
                                        <?php } else { ?>
                                            <form method="post">
                                                <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this order?')">Cancel Order</button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="empty">No product found</p>';
                        }
                    }
                } else {
                    echo '<p class="empty">No order found</p>';
                }
                ?>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>
