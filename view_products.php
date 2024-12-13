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
    exit;
}

// Adding products to wishlist
if (isset($_POST['add_to_wishlist'])) {
    if (!empty($user_id)) {
        $id = uniqid();  // Generate a unique ID
        $product_id = intval($_POST['product_id']);
        
        $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->execute([$user_id, $product_id]);

        $cart_num = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $cart_num->execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your wishlist';
        } else if ($cart_num->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your cart';
        } else {
            $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            if ($fetch_price) {
                $insert_wishlist = $conn->prepare("INSERT INTO wishlist (id, user_id, product_id, price) VALUES (?, ?, ?, ?);");
                $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
                $success_msg[] = 'Product added to wishlist successfully';
            } else {
                $warning_msg[] = 'Product not found';
            }
        }
    } else {
        $warning_msg[] = 'Please login to add items to your wishlist';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Crowned Goddess - Services Offered </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br><br><br><br>
    <?php include 'header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Services</h1>
        </div>
        <div class="title2">
            <a href="home.php">HOME</a><span> | Services </span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM products");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <form action="" method="post" class="box">
                                <br><br>
                                <img src="<?= htmlspecialchars($fetch_products['image']); ?>" alt="image" class="img">
                                <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                                
                                <br><br><br><br>
                                
                                <div class="button">
                                    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                    <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bx bxs-show"></a>
                                </div>
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                                <div class="flex">
                                    <p class="price">price: R<?= htmlspecialchars($fetch_products['price']); ?></p>
                                </div>
                                <br>
                                <a href="bookings.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Book now</a>
                                <br><br>
                            </form>
                            <?php
                        }
                    } else {
                        echo '<p class="empty">No products added yet</p>';
                    }
                ?>
            </div>
        </section>
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'booky.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>
