<?php
session_start();
include "config.php"; // Ensure config.php exists and is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate if all required form fields are present
    if (!isset($_POST["event_type"], $_POST["event_name"], $_POST["event_date"], $_POST["event_time"], $_POST["location"], $_POST["guest_count"], $_POST["user_name"])) {
        die("❌ ERROR: Missing form fields. Please check your form inputs.");
    }

    // Assign values from form
    $event_type = $_POST["event_type"];
    $event_name = $_POST["event_name"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $location = $_POST["location"];
    $guest_count = $_POST["guest_count"];
    $user_name = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : $_POST["user_name"];

    // Insert into database
    $sql = "INSERT INTO inquiries (event_type, event_name, event_date, event_time, location, guest_count, user_name) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("❌ SQL Prepare Error: " . $conn->error);
    }

    $stmt->bind_param("sssssis", $event_type, $event_name, $event_date, $event_time, $location, $guest_count, $user_name);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Inquiry Sent Successfully!'); window.location.href='success.php';</script>";
    } else {
        die("❌ SQL Execute Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
