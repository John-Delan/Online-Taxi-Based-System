<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'cbsphp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get client information from the form
$firstname = $_POST['firstname'];
$middlename = isset($_POST['middlename']) ? $_POST['middlename'] : null;
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$email = isset($_POST['email']) ? $_POST['email'] : null;

// Insert client information into the database
$client_sql = "INSERT INTO client_list (firstname, middlename, lastname, gender, contact, address, email)
               VALUES ('$firstname', '$middlename', '$lastname', '$gender', '$contact', '$address', '$email')";

if ($conn->query($client_sql) === TRUE) {
    $client_id = $conn->insert_id; // Get the ID of the inserted client
} else {
    echo "<script>alert('Error inserting client information.'); window.location.href = '/CabBooking-PHP/staff/form.php';</script>";
    exit();
}

// Get booking information from the form
$driver_id = $_POST['driver'];
$pickup_zone = $_POST['pickup_zone'];
$drop_zone = $_POST['drop_zone'];
$cost = $_POST['cost'];

// Generate a reference code for the booking
$ref_code = 'REF' . time();

// Insert booking information into the booking_list
$booking_sql = "INSERT INTO booking_list (ref_code, client_id, cab_id, pickup_zone, drop_zone, cost, status)
                VALUES ('$ref_code', '$client_id', '$driver_id', '$pickup_zone', '$drop_zone', '$cost', 0)";

if ($conn->query($booking_sql) === TRUE) {
    // Show success message and redirect back to the form
    echo "<script>alert('Booking successful!'); window.location.href = '/CabBooking-PHP/staff/form.php';</script>";
} else {
    echo "<script>alert('Error inserting booking information.'); window.location.href = '/CabBooking-PHP/staff/form.php';</script>";
}

$conn->close();
?>
