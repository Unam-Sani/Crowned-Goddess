<?php
// Database connection setup
$db_name = "mysql:host=localhost;dbname=shop_db";
$db_user = "root";
$db_password = "P@ssword";

try {
    // Create a new PDO instance and set error mode to exception
    $conn = new PDO($db_name, $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, output the error message and terminate the script
    die("Connection failed: " . $e->getMessage());
}

// Function to generate a unique ID
function unique_id() {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Characters to use in the ID
    $charlength = strlen($chars); // Length of the characters string
    $randomString = '';
    for ($i = 0; $i < 16; $i++) { // Generate a 16-character random string
        $randomString .= $chars[mt_rand(0, $charlength - 1)]; // Append a random character from $chars to $randomString
    }
    return $randomString; // Return the generated string
}
?>
