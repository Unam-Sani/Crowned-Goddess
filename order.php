<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "P@ssword"; // specify your MySQL password here if there is one
$dbname = "shop_db"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Initialize date filter variables
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Build SQL query with optional date filter
$sql = "SELECT orders.id, orders.user_id, users.name, users.email, orders.address, orders.address_type, orders.method, orders.product_id, products.image, products.description, orders.price, orders.qty, orders.date
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN products ON orders.product_id = products.id
        WHERE orders.user_id = ?";

if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND orders.date BETWEEN ? AND ?";
}

$stmt = $conn->prepare($sql);

if (!empty($start_date) && !empty($end_date)) {
    $stmt->bind_param("iss", $user_id, $start_date, $end_date);
} else {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'header.php' ; ?>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script src="emailjs-config.js" defer></script> <!-- Include the initialization script -->
    <script src="script.js" defer></script> <!-- Include your main script -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .logo {
            text-align: center;
        }
        .filter-form {
            text-align: center;
            margin: 100px 0;
        }
        .orders {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .order {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            width: 48%;
            box-sizing: border-box;
        }
        .order img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-right: 20px;
        }
        .order-details {
            flex: 1;
        }
        .order-details h3, .order-details p {
            margin: 5px 0;
        }
        .order-details .price {
            font-size: 1.2em;
            color: red;
        }
        .order-details .description {
            color: grey;
            font-weight: normal;
        }
    </style>
</head>
<body>
    <br><br><br><br><br><br><br><br><br><br>
    <div class="logo">
        <img src="logo.png" alt="Logo" width="400">
        <!-- replace with the path to your logo -->
    </div>
    <div class="container">
        <h3>Order History</h3>
        <div class="filter-form">
            <form method="GET" action="">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <button type="submit">Filter</button>
            </form>
        </div>

        <div class="orders">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="order">';
                echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Product Image">';
                echo '<div class="order-details">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p class="description">' . htmlspecialchars($row['description']) . '</p>';
                echo '<p><span class="price">Price: R ' . htmlspecialchars($row['price']) . '</span></p>';
                echo '<p>Quantity: ' . htmlspecialchars($row['qty']) . '</p>';
                echo '<p>Order Date: ' . htmlspecialchars($row['date']) . '</p>';
                echo '<p>Customer: ' . htmlspecialchars($row['name']) . '</p>';
                echo '<p>Email: ' . htmlspecialchars($row['email']) . '</p>';
                echo '<p>Address: ' . htmlspecialchars($row['address']) . ' (' . htmlspecialchars($row['address_type']) . ')</p>';
                echo '<p>Payment Method: ' . htmlspecialchars($row['method']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No orders found.</p>';
        }
        ?>
        </div>
    </div>
</body>
</html>

<?php
?>
