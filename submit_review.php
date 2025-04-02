<?php
require_once "config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $user_name = $_SESSION['user'];
    $rating = intval($_POST["rating"]);
    $review_text = htmlspecialchars($_POST["review_text"]);

    // Insert into database
    $sql = "INSERT INTO reviews (user_id, rating, review_text, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("❌ SQL Error: " . $conn->error);
    }

    $stmt->bind_param("sis", $user_name, $rating, $review_text);

    if ($stmt->execute()) {
        echo "✅ Review Submitted Successfully!";
        header("Location: index.php"); // Redirect to home after submission
    } else {
        die("❌ SQL Execution Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
