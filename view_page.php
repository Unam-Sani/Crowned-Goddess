<?php 
include 'connection.php'; 
session_start();

// Securely fetch user ID
$user_id = isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

function handleProductAction($conn, $user_id, $action) {
    if (!in_array($action, ['wishlist', 'cart'])) return;

    $id = uniqid(); // Assuming this function generates a unique ID
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $quantity = isset($_POST['qty']) ? filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT) : 1;

    $table = $action === 'wishlist' ? 'wishlist' : 'cart';
    $verify_stmt = $conn->prepare("SELECT * FROM $table WHERE user_id = ? AND product_id = ?");
    $verify_stmt->execute([$user_id, $product_id]);

    if ($verify_stmt->rowCount() > 0) {
        $GLOBALS['warning_msg'][] = "Product already exists in your $action";
    } else {
        if ($action === 'cart') {
            $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
            $max_cart_items->execute([$user_id]);

            if ($max_cart_items->rowCount() >= 20) {
                $GLOBALS['warning_msg'][] = 'Cart is full';
                return;
            }
        }

        $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        if ($fetch_price) {
            $price = $fetch_price['price'];
            $columns = $action === 'wishlist' ? '(id, user_id, product_id, price)' : '(id, user_id, product_id, price, qty)';
            $values = $action === 'wishlist' ? '?, ?, ?, ?' : '?, ?, ?, ?, ?';
            $stmt = $conn->prepare("INSERT INTO $table $columns VALUES ($values)");
            $params = $action === 'wishlist' ? [$id, $user_id, $product_id, $price] : [$id, $user_id, $product_id, $price, $quantity];
            $stmt->execute($params);
            $GLOBALS['success_msg'][] = "Product added to $action successfully";
        } else {
            $GLOBALS['warning_msg'][] = 'Product not found';
        }
    }
}

if (isset($_POST['add_to_wishlist'])) {
    handleProductAction($conn, $user_id, 'wishlist');
}

if (isset($_POST['add_to_cart'])) {
    handleProductAction($conn, $user_id, 'cart');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - View Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Product Detail Page</h1>
        </div>
        <div class="title2">
            <a href="home.php">HOME</a><span> | Product Detail</span>
        </div>
        <section class="view_page">
            <?php
            if (isset($_GET['pid'])) {/*PID = product_id*/
                $pid = filter_var($_GET['pid'], FILTER_SANITIZE_STRING);
                $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $select_products->execute([$pid]);

                if ($select_products->rowCount() > 0) {
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="post">
                <img src="<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="<?php echo htmlspecialchars($fetch_products['name']); ?>">
                <div class="detail">
                    <div class="price">R<?php echo htmlspecialchars($fetch_products['price']); ?></div>
                    <div class="name"><?php echo htmlspecialchars($fetch_products['name']); ?></div>
                    <div class="description">
                        <p><?php echo htmlspecialchars($fetch_products['description']); ?></p>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_products['id']); ?>">
                    <div class="button">
                        <button type="submit" name="add_to_wishlist" class="btn">Add to Wishlist <i class="bx bx-heart"></i></button>
                        <button type="submit" name="add_to_cart" class="btn">Add to Cart <i class="bx bx-cart"></i></button>
                    </div>
                </div>
            </form>
            <?php
                } else {
                    echo '<p class="empty">Product not found!</p>';
                }
            } else {
                echo '<p class="empty">No product selected!</p>';
            }
            ?>
        </section>
        <?php include 'footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>
