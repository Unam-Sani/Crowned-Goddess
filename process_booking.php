<?php
include 'connection.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $id = unique_id();
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address_type = $_POST['address_type'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $pincode = $_POST['pincode'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Insert data into the database
    try {
        $sql = "INSERT INTO bookings (id, name, number, email, method, address_type, flat, street, city, country, pincode, date, time) 
                VALUES (:id, :name, :number, :email, :method, :address_type, :flat, :street, :city, :country, :pincode, :date, :time)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':method', $method);
        $stmt->bindParam(':address_type', $address_type);
        $stmt->bindParam(':flat', $flat);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':pincode', $pincode);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->execute();

        // Redirect to a thank you page or display a success message
        header("Location: thank_you.php");
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
?>
