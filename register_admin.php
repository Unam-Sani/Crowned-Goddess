<?php
include_once 'connection.php'; 
session_start();

if (isset($_SESSION['employee_id'])) {
    header('Location: admin.php');
    exit;
}

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
    $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);

    if ($pass != $cpass) {
        $message[] = 'Passwords do not match!';
    } else {
        $select_user = $conn->prepare("SELECT * FROM `employees` WHERE email = ?");
        $select_user->execute([$email]);
        if ($select_user->rowCount() > 0) {
            $message[] = 'User already exists!';
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $insert_user = $conn->prepare("INSERT INTO `employees` (username, email, password, role) VALUES (?, ?, ?, ?)");
            $insert_user->execute([$name, $email, $hashed_password, $role]);
            $message[] = 'Registered successfully!';
            header('Location: home.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowned Goddess - Register Now</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png" alt="Crowned Goddess">
                <h1>Register Employee</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Employee Name</p>
                    <input type="text" name="name" placeholder="Enter employee name" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Employee Email</p>
                    <input type="email" name="email" placeholder="Enter employee email" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Employee Password</p>
                    <input type="password" name="pass" placeholder="Enter your password" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>Confirm Employee Password</p>
                    <input type="password" name="cpass" placeholder="Confirm password" required maxlength="50">
                </div>
                <div class="input-field">
                    <label for="role">Choose a Employee role:</label>
                    <select name="role" id="role">
                        <option value="Receptionists">Receptionists</option>
                        <option value="Assistant">Assistant</option>
                        <option value="Hair Stylists">Hair Stylists</option>
                        <option value="Manager">Manager</option>
                    </select>
                    <br><br>
                </div>      
                <input type="submit" name="submit" value="Register Now" class="btn">
                <p>Already have an account? <a href="login_admin.php">Login now</a></p>
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
