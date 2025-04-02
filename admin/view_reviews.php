<?php
session_start();
include 'config.php';
include 'header.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
// Fetch all reviews with error handling
$sql = "SELECT reviews.id, users.name, reviews.rating, reviews.review_text, reviews.created_at 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id
        ORDER BY reviews.created_at DESC";

$result = $conn->query($sql);

// Debugging: Check if query failed
if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<div class="container">
    <h3>All Reviews</h3>
    <table style="width:70%;margin:auto">
        <thead>
            <tr>
                <th>User</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($review = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review["name"]); ?></td>
                    <td><?php echo str_repeat("⭐", $review["rating"]); ?></td>
                    <td><?php echo htmlspecialchars($review["review_text"]); ?></td>
                    <td><?php echo $review["created_at"]; ?></td>
                    <td>
                        <a href="delete_review.php?id=<?php echo $review["id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure?');">❌ Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once("footer.php"); ?>
