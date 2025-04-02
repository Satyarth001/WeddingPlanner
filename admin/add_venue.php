<?php
session_start();
include 'config.php';
include 'header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$message = "";

// Handle Venue Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $location = trim($_POST["location"]);
    $type = trim($_POST["type"]);
    $capacity = intval($_POST["capacity"]);
    $price_per_person = floatval($_POST["price_per_person"]);
    $rating = floatval($_POST["rating"]);
    $reviews = intval($_POST["reviews"]);
    $image = "";

    // Handle Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "img/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Insert into Database
    $stmt = $conn->prepare("INSERT INTO venues (name, location, type, capacity, price_per_person, rating, reviews, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiddis", $name, $location, $type, $capacity, $price_per_person, $rating, $reviews, $image);
    
    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Venue added successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error adding venue.</div>";
    }
}
?>

<div class="container mt-5">
    <h3 class="text-center">Add New Venue</h3>
    <?= $message ?>
    <form action="" method="POST" enctype="multipart/form-data" class="w-50 mx-auto p-4 border rounded shadow">
        <div class="mb-3">
            <label class="form-label">Venue Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Type</label>
            <input type="text" name="type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price per Person</label>
            <input type="number" step="0.01" name="price_per_person" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating (0-5)</label>
            <input type="number" step="0.1" name="rating" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Reviews Count</label>
            <input type="number" name="reviews" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Venue Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Venue</button>
    </form>
</div>

<?php include "footer.php"; ?>
