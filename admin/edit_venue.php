<?php
session_start();
include 'config.php';
include 'header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    die("Invalid Request.");
}

$venueId = intval($_GET['id']);
$message = "";

// Fetch Venue Data
$stmt = $conn->prepare("SELECT * FROM venues WHERE id = ?");
$stmt->bind_param("i", $venueId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Venue not found.");
}
$venue = $result->fetch_assoc();

// Handle Venue Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $location = trim($_POST["location"]);
    $type = trim($_POST["type"]);
    $capacity = intval($_POST["capacity"]);
    $price_per_person = floatval($_POST["price_per_person"]);
    $rating = floatval($_POST["rating"]);
    $reviews = intval($_POST["reviews"]);
    $image = $venue['image'];

    // Handle Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Update Query
    $stmt = $conn->prepare("UPDATE venues SET name=?, location=?, type=?, capacity=?, price_per_person=?, rating=?, reviews=?, image=? WHERE id=?");
    $stmt->bind_param("sssiddisi", $name, $location, $type, $capacity, $price_per_person, $rating, $reviews, $image, $venueId);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Venue updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error updating venue.</div>";
    }
}
?>

<div class="container mt-5">
    <h3 class="text-center">Edit Venue</h3>
    <?= $message ?>
    <form action="" method="POST" enctype="multipart/form-data" class="w-50 mx-auto p-4 border rounded shadow">
        <div class="mb-3">
            <label class="form-label">Venue Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($venue['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($venue['location']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Type</label>
            <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($venue['type']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" value="<?= $venue['capacity']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price per Person</label>
            <input type="number" step="0.01" name="price_per_person" class="form-control" value="<?= $venue['price_per_person']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating (0-5)</label>
            <input type="number" step="0.1" name="rating" class="form-control" value="<?= $venue['rating']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Reviews Count</label>
            <input type="number" name="reviews" class="form-control" value="<?= $venue['reviews']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Venue Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Venue</button>
    </form>
</div>

<?php include "footer.php"; ?>
