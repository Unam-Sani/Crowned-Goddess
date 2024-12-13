<?php
include_once 'connection.php'; 
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

    if ($pass != $cpass) {
        $message[] = 'Passwords do not match!';
    } else {
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
        if ($select_user->rowCount() > 0) {
            $message[] = 'User already exists!';
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (?, ?, ?, 'customer')");
            $insert_user->execute([$name, $email, $hashed_password]);
            $message[] = 'Registered successfully!';
            header('Location: home.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea - Register Now</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="logo - Copy.png" alt="Green Tea">
                <h1>Register Now</h1>
                <p>Welcome to our registration page! We're excited to have you join our community. </p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your Name</p>
                    <input type="text" name="name" placeholder="Enter your name" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Your Email</p>
                    <input type="email" name="email" placeholder="Enter your email" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Your Password</p>
                    <input type="password" name="pass" placeholder="Enter your password" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Confirm Password</p>
                    <input type="password" name="cpass" placeholder="Confirm password" required maxlength="50">
                </div>
                <input type="submit" name="submit" value="Register Now" class="btn">
                <p>Already have an account? <a href="login.php">Login now</a></p>
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
