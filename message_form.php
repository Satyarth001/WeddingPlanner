<?php
session_start();
$venue = isset($_GET['venue']) ? htmlspecialchars($_GET['venue']) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Vendor</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Include your CSS file -->
</head>
<body>

<form id="inquiryForm" action="store_message.php" method="POST" onsubmit="return validateForm()">
    <label>Event Type:</label>
    <input type="text" name="event_type" id="event_type" required>

    <label>Event Name:</label>
    <input type="text" name="event_name" id="event_name" required>

    <label>Event Date:</label>
    <input type="date" name="event_date" id="event_date" required>

    <label>Event Time:</label>
    <input type="time" name="event_time" id="event_time" required>

    <label>Location:</label>
    <input type="text" name="location" id="location" required>

    <label>Guest Count:</label>
    <input type="number" name="guest_count" id="guest_count" min="1" required>

    <label>Your Name:</label>
    <input type="text" name="user_name" id="user_name" required>

    <button type="submit">Send Inquiry</button>
</form>

<script>
    function validateForm() {
        let eventType = document.getElementById("event_type").value.trim();
        let eventName = document.getElementById("event_name").value.trim();
        let eventDate = document.getElementById("event_date").value;
        let eventTime = document.getElementById("event_time").value;
        let location = document.getElementById("location").value.trim();
        let guestCount = document.getElementById("guest_count").value;
        let userName = document.getElementById("user_name").value.trim();

        // Ensure no empty fields
        if (!eventType || !eventName || !eventDate || !eventTime || !location || !guestCount || !userName) {
            alert("❌ Please fill in all required fields.");
            return false;
        }

        // Validate event date (must not be in the past)
        let today = new Date().toISOString().split("T")[0];
        if (eventDate < today) {
            alert("❌ Event date cannot be in the past.");
            return false;
        }

        // Validate guest count (minimum 1)
        if (guestCount <= 0) {
            alert("❌ Guest count must be at least 1.");
            return false;
        }

        return true;
    }
</script>

</body>
</html>
