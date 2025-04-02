<?php
include_once("header.php");
require_once "config.php";

// Ensure user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"];
$error = "";

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = intval($_POST["rating"]);
    $review_text = trim($_POST["review_text"]);

    if ($rating < 1 || $rating > 5) {
        $error = "Invalid rating! Please select between 1 and 5.";
    } elseif (empty($review_text)) {
        $error = "Review text cannot be empty!";
    } else {
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, rating, review_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $rating, $review_text);
        if ($stmt->execute()) {
            header("Location: index.php?success=Review submitted!");
            exit();
        } else {
            $error = "Error submitting review.";
        }
        $stmt->close();
    }
}
?>

<style>
.container {
    width: 90%;
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
h2 {
    text-align: center;
    color: #8c001a;
}
.error-message, .success-message {
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}
.error-message {
    background: #dc3545;
    color: white;
}
.success-message {
    background: #28a745;
    color: white;
}
label, select, textarea, button {
    display: block;
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
}
button {
    background: #8c001a;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}
button:hover {
    background: black;
}
</style>

<div class="container">
    <h2>Submit a Review</h2>

    <?php if (isset($_GET["success"])): ?>
        <p class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="rating">Rating (1-5):</label>
        <select id="rating" name="rating" required>
            <option value="1">⭐</option>
            <option value="2">⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
        </select>

        <label for="review_text">Review:</label>
        <textarea id="review_text" name="review_text" rows="4" required></textarea>

        <button type="submit">Submit Review</button>
    </form>
</div>

<?php include_once("footer.php"); ?>
