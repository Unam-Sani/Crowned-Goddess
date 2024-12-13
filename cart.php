<?php 
include 'connection.php'; 
session_start();

if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
} else {
    $user_id = 0; 
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Updating product in cart
if (isset($_POST['update_cart'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    $update_qty = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);

    $success_msg[] = 'Cart quantity updated successfully';
}

// Adding products to cart
if (isset($_POST['add_to_cart'])) {
    $id = unique_id();
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $verify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if ($verify_cart->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else if ($max_cart_items->rowCount() >= 20) {
        $warning_msg[] = 'Cart is full';
    } else {
        $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        if ($fetch_price) {
            $insert_cart = $conn->prepare("INSERT INTO cart (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?);");
            $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
            $success_msg[] = 'Product added to cart successfully';
        } else {
            $warning_msg[] = 'Product not found';
        }
    }
}

// Adding products to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $id = unique_id();
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);

    $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
    $verify_wishlist->execute([$user_id, $product_id]);

    if ($verify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your wishlist';
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
}

// Deleting products from wishlist
if (isset($_POST['delete_item'])) {
    if (isset($_POST['wishlist_id'])) {
        $wishlist_id = filter_var($_POST['wishlist_id'], FILTER_SANITIZE_STRING);

        $verify_delete_item = $conn->prepare("SELECT * FROM wishlist WHERE id = ?");
        $verify_delete_item->execute([$wishlist_id]);

        if ($verify_delete_item->rowCount() > 0) {
            $delete_item = $conn->prepare("DELETE FROM wishlist WHERE id = ?");
            $delete_item->execute([$wishlist_id]);
            $success_msg[] = 'Product removed from wishlist successfully';
        } else {
            $warning_msg[] = 'Wishlist item already deleted';
        }
    } else {
        $warning_msg[] = 'Wishlist ID not provided';
    }
}

// Empty cart
if (isset($_POST['empty_cart'])) {
    $verify_empty_item = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $verify_empty_item->execute([$user_id]);

    if ($verify_empty_item->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart_id->execute([$user_id]);
        $success_msg[] = "Cart emptied successfully";
    } else {
        $warning_msg[] = "Cart is already empty";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>View Products</h1>
        </div>
        <div class="title2">
            <a href="home.php">HOME</a><span> | Cart</span></div>
        <section class="products">
            <h1 class="title">Products added to your cart</h1>
            <div class="box-container">
                <?php
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                $select_cart->execute([$user_id]);
                if ($select_cart->rowCount() > 0) {
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
                        $select_products->execute([$fetch_cart['product_id']]);
                        if ($select_products->rowCount() > 0) {
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="post" action="" class="box">
                    <input type="hidden" name="cart_id" value="<?= htmlspecialchars($fetch_cart['id']); ?>">
                    <img src="<?= htmlspecialchars($fetch_products['image']); ?>" alt="<?= htmlspecialchars($fetch_products['name']); ?>" class="img">
                    <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                    <div class="flex">
                        <p class="price">Price: R<?= number_format($fetch_products['price'], 2); ?></p>
                        <input type="number" name="qty" required min="1" value="<?= htmlspecialchars($fetch_cart['qty']); ?>" max="99" class="qty">
                        <button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>
                    </div>
                    <div class="button">
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>"><i class="bx bx-show"></i></a>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                    </div>
                    <p class="subtotal">Sub-total: <span>R<?= number_format($sub_total = ($fetch_cart['qty'] * $fetch_products['price']), 2); ?></span></p>
                    <button type="submit" name="delete_item" class="btn" onclick="return confirm('Delete this item?')">Delete</button>
                </form>
                <?php
                        $grand_total += $sub_total;
                    }
                }
                } else {
                    echo '<p class="empty">No products added yet</p>';
                }
                ?>
            </div>
            <?php
            if ($grand_total != 0) {
                ?>
            <div class="cart-total">
                <p>Total amount payable: <span>R<?= number_format($grand_total, 2); ?></span></p>

                <div class="button">
                    <form method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure you want to empty your cart?')">Empty Cart</button>
                    </form>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            </div>
            <?php }?>
        </section>
    </div>
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>
