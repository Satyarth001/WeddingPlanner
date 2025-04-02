<?php
require_once "config.php";

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"];
$vendor_id = $_GET["vendor_id"] ?? null;

if (!$vendor_id) {
    die("Invalid vendor selection.");
}

// Insert booking request
$query = $conn->prepare("INSERT INTO vendor_bookings (user_id, vendor_id, status) VALUES (?, ?, 'Pending')");
if (!$query) {
    die("Query Error: " . $conn->error);
}
$query->bind_param("ii", $user_id, $vendor_id);
$query->execute();

// Remove vendor from shortlist after booking
$remove_query = $conn->prepare("DELETE FROM shortlisted_vendors WHERE user_id = ? AND vendor_id = ?");
if (!$remove_query) {
    die("Query Error: " . $conn->error);
}
$remove_query->bind_param("ii", $user_id, $vendor_id);
$remove_query->execute();

// Redirect to confirmation page
header("Location: booking_confirmation.php");
exit();
?>
