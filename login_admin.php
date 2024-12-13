<?php
include_once 'connection.php';
session_start();

// Redirect to home if already logged in
if (isset($_SESSION['employee_id'])) {
    header('Location: admin.php');
    exit;
}

// Login user
if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

 {
        // Prepare and execute SELECT query
        $select_employee = $conn->prepare("SELECT * FROM `employees` WHERE email = ?");
        $select_employee->execute([$email]);
        $row = $select_employee->fetch(PDO::FETCH_ASSOC);

        if ($select_employee->rowCount() > 0 && password_verify($pass, $row['password'])) {
            $_SESSION['employee_id'] = $row['id'];
            $_SESSION['employee_name'] = $row['name'];
            $_SESSION['employee_email'] = $row['email'];
            header('Location: admin.php');
            exit;
        } else {
            $message[] = 'Incorrect email or password';
        }
 }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowned Goddess - Login Now</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <section class="container">
            <div class="title2">
                <img src="img/download.png" alt="Green Tea">
                <h1>Login Employee</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div class="user-box">
            <form action="" method="post">
                <div>
                <div class="input-field">
                    <p>Your Email</p>
                    <input type="email" name="email" placeholder="Enter your email" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Your Password</p>
                    <input type="password" name="pass" placeholder="Enter your password" required maxlength="50">
                </div>
                <input type="submit" name="submit" value="Login Now" class="btn">
                <p>NEW EMPLOYEE <a href="register_admin.php">Register Employee</a></p>
                </div>
            </form>
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . htmlspecialchars($msg) . '</div>';
                }
            }
            ?>
        </section>
    </div>
</body>
</html>
