<?php
session_start();
include 'config.php';
include 'header.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle Venue Deletion
if (isset($_GET['delete'])) {
    $venueId = intval($_GET['delete']);
    
    // Use prepared statements for security
    $stmt = $conn->prepare("DELETE FROM venues WHERE id = ?");
    $stmt->bind_param("i", $venueId);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Venue deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error deleting venue: " . $conn->error . "</div>";
    }
    $stmt->close();
    header("Refresh: 2; URL=manage_venues.php");
}

// Fetch Venue Data
$venues = $conn->query("SELECT * FROM venues");
?>
<div class="wrapper">
<div class="container mt-4">
    <h3 class="text-center">Manage Venues</h3>
    <div class="text-center mb-3">
        <a href="add_venue.php" class="btn btn-primary">Add New Venue</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Price Per Person</th>
                    <th>Rating</th>
                    <th>Reviews</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($venue = $venues->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($venue['id']); ?></td>
                        <td><?= htmlspecialchars($venue['name']); ?></td>
                        <td><?= htmlspecialchars($venue['type']); ?></td>
                        <td><?= htmlspecialchars($venue['location']); ?></td>
                        <td><?= htmlspecialchars($venue['capacity']); ?></td>
                        <td>$<?= number_format($venue['price_per_person'], 2); ?></td>
                        <td><?= htmlspecialchars($venue['rating']); ?></td>
                        <td><?= htmlspecialchars($venue['reviews']); ?></td>
                        <td><img src="../img/<?= htmlspecialchars($venue['image']); ?>" alt="Venue Image" width="80"></td>
                        <td>
                            <a href="edit_venue.php?id=<?= $venue['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete=<?= $venue['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this venue?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "footer.php"; ?>
                </div>