<?php
include_once 'connection.php';
session_start();

// Redirect to home if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

// Login user
if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    // Prepare and execute SELECT query
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0 && password_verify($pass, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        header('Location: home.php');
        exit;
    } else {
        $message[] = 'Incorrect email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowned Goddess- Login Now</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="logo - Copy.png" alt="Logo">
                <h1>Login Now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your Email</p>
                    <input type="email" name="email" placeholder="Enter your email" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Your Password</p>
                    <input type="password" name="pass" placeholder="Enter your password" required maxlength="50">
                </div>
                <input type="submit" name="submit" value="Login Now" class="btn">
                
                <p>Don't have an account? <a href="register.php">Register now</a></p>
            
            </form>
            <p>
            </p>
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
