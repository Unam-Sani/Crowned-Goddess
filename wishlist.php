<?php 
include 'connection.php'; 
session_start();

if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
} else {
    $user_id = 0; 
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Adding products to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $id = uniqid();
    $product_id = $_POST['product_id'];

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

        $insert_wishlist = $conn->prepare("INSERT INTO wishlist (id, user_id, product_id, price) VALUES (?, ?, ?, ?);");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = 'Product added to wishlist successfully';
    }
}

// Deleting products from wishlist
if (isset($_POST['delete_item'])) {
    $wishlist_id = $_POST['wishlist_id'];
    $delete_wishlist = $conn->prepare("DELETE FROM wishlist WHERE id = ?");
    $delete_wishlist->execute([$wishlist_id]);
    $success_msg[] = 'Product removed from wishlist successfully';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - Wishlist Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <br><br><br><br>
    <div class="main">
        <div class="banner">
            <h1>My Wishlist</h1>
        </div>
        <div class="title2">
            <a href="home.php">HOME</a><span> / Wishlist</span>
        </div>
        <section class="products">
            <h1 class="title">Products Added in Wishlist</h1>
            <div class="box-container">
                <?php
                $grand_total = 0;
                $select_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
                $select_wishlist->execute([$user_id]);
                if ($select_wishlist->rowCount() > 0) {
                    while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                        $select_products = $conn->prepare("SELECT * FROM products WHERE id=?");
                        $select_products->execute([$fetch_wishlist['product_id']]);
                        if ($select_products->rowCount() > 0) {
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <form method="post" action="" class="box">
                            <input type="hidden" name="wishlist_id" value="<?=$fetch_wishlist['id']; ?>">
                            <img src="<?=$fetch_products['image']; ?>" alt="image">
                            <br><br>
                            <div class="button">
                                <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>"><i class="bx bx-show"></i></a>
                                <button type="submit" name="delete_item" onclick="return confirm('delete this item');">
                                <i class="bx bx-x"></i></button>
                            </div>
                            <br><br><br><br><br>
                            <h3 class="name"><?=$fetch_products['name']; ?></h3>
                            <input type="hidden" name="product_id" value="<?=$fetch_products['id']; ?>">
                            <div class="flex">
                                <p class="price">Price: R<?=$fetch_products['price']; ?></p>
                            </div>
                            <a href="checkout.php?get_id=<?=$fetch_products['id']; ?>" class="btn">Buy Now</a>
                        </form>
                        <?php
                        $grand_total+=$fetch_wishlist['price'];
                        }
                    }
                } else {

                    echo '<p class="empty">No products added in yet.<a href="register.php"><br>
                     Register </a> to add to your wishlist </p> ';
                }
                ?>
            </div>
        </section>
        <?php include 'footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>
