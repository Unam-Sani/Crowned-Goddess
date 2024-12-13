<?php
include 'connection.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: login_admin.php");
    exit;
}

// Handle product actions
if (isset($_POST['add_product'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $image, $description]);
        $message = "Product added successfully!";
    } else {
        $message = "Failed to upload image.";
    }
}

if (isset($_POST['delete_product'])) {
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $message = "Product deleted successfully!";
}

if (isset($_POST['edit_product'])) {
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $price, $description, $product_id]);
    $message = "Product updated successfully!";
}

// Handle role assignment
if (isset($_POST['assign_role'])) {
    $employee_id = filter_var($_POST['employee_id'], FILTER_SANITIZE_NUMBER_INT);
    $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
    $stmt = $conn->prepare("UPDATE employees SET role = ? WHERE id = ?");
    $stmt->execute([$role, $employee_id]);
    $message = "Role assigned successfully!";
}

// Handle service actions
if (isset($_POST['add_service'])) {
    $service_name = filter_var($_POST['service_name'], FILTER_SANITIZE_STRING);
    $service_description = filter_var($_POST['service_description'], FILTER_SANITIZE_STRING);
    $service_price = filter_var($_POST['service_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $stmt = $conn->prepare("INSERT INTO services (name, description, price) VALUES (?, ?, ?)");
    $stmt->execute([$service_name, $service_description, $service_price]);
    $message = "Service added successfully!";
}

if (isset($_POST['delete_service'])) {
    $service_id = filter_var($_POST['service_id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$service_id]);
    $message = "Service deleted successfully!";
}

// Handle appointment actions
if (isset($_POST['add_appointment'])) {
    $employee_id = filter_var($_POST['employee_id'], FILTER_SANITIZE_NUMBER_INT);
    $service_id = filter_var($_POST['service_id'], FILTER_SANITIZE_NUMBER_INT);
    $appointment_date = filter_var($_POST['appointment_date'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $stmt = $conn->prepare("INSERT INTO appointments_Employee (employee_id, service_id, appointment_date, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$employee_id, $service_id, $appointment_date, $status]);
    $message = "Appointment added successfully!";
}

if (isset($_POST['delete_appointment'])) {
    $appointment_id = filter_var($_POST['appointment_id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare("DELETE FROM appointments_Employee WHERE id = ?");
    $stmt->execute([$appointment_id]);
    $message = "Appointment deleted successfully!";
}

// Fetch data for display
$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
$employees = $conn->query("SELECT * FROM employees")->fetchAll(PDO::FETCH_ASSOC);
$appointments = $conn->query("SELECT * FROM appointments_Employee")->fetchAll(PDO::FETCH_ASSOC);
$services = $conn->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
$inventory = $conn->query("SELECT * FROM inventory")->fetchAll(PDO::FETCH_ASSOC);
$invoices = $conn->query("SELECT * FROM invoices")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Crowned Goddess</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Shop</h1>
    </div>
    <div class="title2">
        <a href="home.php">HOME</a><span> | ADMINISTRATION </span>
    </div>

    <div class="main">
        <h1>Admin Panel</h1>

        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Products Management -->
        <section class="admin-section">
            <h2>Manage Products</h2>
            <form action="admin.php" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Product Name" required>
                <input type="number" name="price" placeholder="Price" step="0.01" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="file" name="image" required>
                <button type="submit" name="add_product">Add Product</button>
            </form>

            <section class="products">
            <div class="box-container">
                <?php foreach ($products as $product): ?>
                    <form action="admin.php" method="post" class="box">
                        <br><br>
                        <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="image" class="img">
                        <h3 class="name"><?= htmlspecialchars($product['name']); ?></h3>
                        
                        <br><br><br><br>
                        
                        <div class="button">
                            <a href="view_page.php?pid=<?= $product['id']; ?>"><i class="bx bx-show"></i></a>
                            <button type="submit" name="delete_product" onclick="return confirm('delete this item');">
                            <i class="bx bx-x"></i></button>
                        </div>
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                        <div class="flex">
                            <p class="price">price: R<?= htmlspecialchars($product['price']); ?></p>
                        </div>
                        <br>
                        <a href="bookings.php?get_id=<?= htmlspecialchars($product['id']); ?>" class="btn">Book now</a>
                        <br><br>
                    </form>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                    <p class="empty">No products added yet</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Appointments Management -->
        <section class="admin-section">
            <h2>Manage Appointments</h2>
            <form action="admin.php" method="post">
                <select name="employee_id" required>
                    <?php foreach ($employees as $employee): ?>
                        <option value="<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['username']) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="service_id" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?= htmlspecialchars($service['id']) ?>"><?= htmlspecialchars($service['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="datetime-local" name="appointment_date" required class="qty">
                <input type="text" name="status" placeholder="Status" required class="qty">
                <button type="submit" name="add_appointment" class="btn">Add Appointment</button>
            </form>
            <h3>Existing Appointments</h3>
            <ul>
                <?php foreach ($appointments as $appointment): ?>
                    <li>
                        Appointment ID: <?= htmlspecialchars($appointment['id']) ?> - Employee ID: <?= htmlspecialchars($appointment['employee_id']) ?> - Service ID: <?= htmlspecialchars($appointment['service_id']) ?> - Date: <?= htmlspecialchars($appointment['appointment_date']) ?> - Status: <?= htmlspecialchars($appointment['status']) ?>
                        <form action="admin.php" method="post" style="display:inline;">
                            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['id']) ?>" class="qty">
                            <button type="submit" name="delete_appointment">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>
