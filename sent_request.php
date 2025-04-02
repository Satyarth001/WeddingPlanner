<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '';
    $venue = isset($_POST['venue']) ? mysqli_real_escape_string($conn, $_POST['venue']) : '';

    if (empty($name) || empty($phone) || empty($venue)) {
        die("Error: Missing required fields.");
    }

    $query = "INSERT INTO venue_requests (name, phone, venue) VALUES ('$name', '$phone', '$venue')";

    if (mysqli_query($conn, $query)) {
        echo "Your request has been sent successfully!";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>