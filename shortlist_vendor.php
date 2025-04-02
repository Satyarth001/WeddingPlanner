<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    echo "login";
    exit;
}

$user_id = $_SESSION['user'];
$vendor_id = intval($_POST['vendor_id']);

// Check if vendor is already shortlisted
$check_query = "SELECT * FROM shortlisted_vendors WHERE user_id = $user_id AND vendor_id = $vendor_id";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // Remove from shortlist
    $delete_query = "DELETE FROM shortlisted_vendors WHERE user_id = $user_id AND vendor_id = $vendor_id";
    mysqli_query($conn, $delete_query);
    echo "removed";
} else {
    // Add to shortlist
    $insert_query = "INSERT INTO shortlisted_vendors (user_id, vendor_id) VALUES ($user_id, $vendor_id)";
    mysqli_query($conn, $insert_query);
    echo "added";
}
?>
