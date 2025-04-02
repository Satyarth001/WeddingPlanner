<?php
include "header.php";
include "config.php";

// Get user ID
if (!isset($_GET['user_id'])) {
    die("Invalid request!");
}

$user_id = intval($_GET['user_id']);

// Fetch user details
$user_query = $conn->query("SELECT id, name, venue_id FROM users WHERE id = $user_id");
$user = $user_query->fetch_assoc();
if (!$user) {
    die("User not found!");
}

// Fetch available venues
$venues_query = $conn->query("SELECT id, name FROM venues");

// Assign venue (if form is submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_id = intval($_POST['venue_id']);
    
    // Update user's venue
    $update = $conn->query("UPDATE users SET venue_id = $venue_id WHERE id = $user_id");
    
    if ($update) {
        echo "<script>alert('Venue assigned successfully!'); window.location='manage_users.php';</script>";
    } else {
        echo "<p style='color: red;'>Error assigning venue: " . $conn->error . "</p>";
    }
}
?>

<h3>Assign Venue to <?= htmlspecialchars($user['name']); ?></h3>

<form method="POST">
    <label for="venue">Select Venue:</label>
    <select name="venue_id" required>
        <option value="">-- Choose a Venue --</option>
        <?php while ($venue = $venues_query->fetch_assoc()): ?>
            <option value="<?= $venue['id']; ?>" <?= $venue['id'] == $user['venue_id'] ? 'selected' : ''; ?>>
                <?= htmlspecialchars($venue['name']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <br><br>
    <button type="submit" >Assign Venue</button>
</form>

<a href="manage_users.php" class="delete-btn">Back to Users</a>
