<?php
include "header.php";
require_once "config.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["user"];

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch User Data
$user_query = $conn->prepare("SELECT name, wedding_date FROM users WHERE id = ?");
if (!$user_query) {
    die("Query Error (Users): " . $conn->error);
}
$user_query->bind_param("i", $id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
if (!$user) {
    die("User not found.");
}

// Fetch Budget Data
$budget_query = $conn->prepare("SELECT total_budget, task_estimate_total FROM budget WHERE user_id = ?");
if (!$budget_query) {
    die("Query Error (Budget): " . $conn->error);
}
$budget_query->bind_param("i", $id);
$budget_query->execute();
$budget_result = $budget_query->get_result();
$budget = $budget_result->fetch_assoc() ?: ["total_budget" => 0, "task_estimate_total" => 0];

// Fetch Guest Data
$guest_query = $conn->prepare("SELECT COUNT(*) AS total_invited, SUM(CASE WHEN rsvp_status = 'Confirmed' THEN 1 ELSE 0 END) AS confirmed FROM guestlist WHERE user_id = ?");
if (!$guest_query) {
    die("Query Error (Guests): " . $conn->error);
}
$guest_query->bind_param("i", $id);
$guest_query->execute();
$guest_result = $guest_query->get_result();
$guest = $guest_result->fetch_assoc() ?: ["total_invited" => 0, "confirmed" => 0];

// Fetch Task Data
$task_query = $conn->prepare("SELECT COUNT(*) AS total_tasks, SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed_tasks FROM tasks WHERE user_id = ?");
if (!$task_query) {
    die("Query Error (Tasks): " . $conn->error);
}
$task_query->bind_param("i", $id);
$task_query->execute();
$task_result = $task_query->get_result();
$task = $task_result->fetch_assoc() ?: ["total_tasks" => 0, "completed_tasks" => 0];

// Calculate Progress
$total_tasks = max($task["total_tasks"], 1);
$total_progress = round(($task["completed_tasks"] / $total_tasks) * 100, 2);

// Fetch Shortlisted Vendors
$vendor_query = $conn->prepare("
    SELECT v.id, v.name, v.contact_person, v.phone, v.email, v.address, v.image 
    FROM vendor v 
    JOIN shortlisted_vendors sv ON v.id = sv.vendor_id 
    WHERE sv.user_id = ?
");
if (!$vendor_query) {
    die("Query Error (Vendors): " . $conn->error);
}
$vendor_query->bind_param("i", $id);
$vendor_query->execute();
$vendor_result = $vendor_query->get_result();

// Fetch Reviews
$review_query = $conn->prepare("SELECT r.rating, r.review_text, r.created_at, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.user_id = ? ORDER BY r.created_at DESC");
if (!$review_query) {
    die("Query Error (Reviews): " . $conn->error);
}
$review_query->bind_param("i", $id);
$review_query->execute();
$review_result = $review_query->get_result();
?>
<head>
<style>
	h2{
		font-family:Bell TM;
		font-size:36px;
		font-weight:bold;
		color:#660000;
	}
	h4{
		font-family:Bell TM;
		font-size:36px;
		font-weight:bold;
		color:#660000;
		text-align:center;
	}
	 .shadow {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .rounded {
        border-radius: 10px;
    }
    .card {
        border-radius: 8px;
    }
    .card-body {
        padding: 15px;
    }
</style>
</head>
<div class="container mt-5">
    <h2 class="text-center fw-bold">Welcome back, <?php echo htmlspecialchars($user["name"]); ?>! 🎉</h2>
    <p class="text-center lead"> <strong id="countdown"></strong> days! left for Your Wedding💍</p>

    <!-- Wedding Progress -->
    <div class="progress my-4" style="height: 20px;">
        <div class="progress-bar bg-success fw-bold" role="progressbar" 
             style="width: <?php echo $total_progress; ?>%" 
             aria-valuenow="<?php echo $total_progress; ?>" 
             aria-valuemin="0" aria-valuemax="100">
            <?php echo $total_progress; ?>%
        </div>
    </div>

    <div class="row g-4">
        <!-- Budget Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-danger border-0 rounded-4 shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-cash-stack"></i> Budget Status</h5>
                    <p class="card-text">₹<?php echo number_format($budget["task_estimate_total"], 2); ?> / ₹<?php echo number_format($budget["total_budget"], 2); ?> spent</p>
                    <a href="budget.php" class="btn btn-light btn-sm rounded-pill">Manage Budget</a>
                </div>
            </div>
        </div>

        <!-- Guest List Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-danger border-0 rounded-4 shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-people-fill"></i> Guest List (RSVP)</h5>
                    <p class="card-text"><?php echo $guest["confirmed"]; ?> / <?php echo $guest["total_invited"]; ?> Confirmed</p>
                    <a href="guestlist.php" class="btn btn-light btn-sm rounded-pill">Manage Guests</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-danger border-0 rounded-4 shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-people-fill"></i> Checklist List (RSVP)</h5>
                    <p class="card-text"><?php echo $guest["confirmed"]; ?> / <?php echo $guest["total_invited"]; ?> Confirmed</p>
                    <a href="checklist.php" class="btn btn-light btn-sm rounded-pill">Manage Checklist</a>
                </div>
            </div>
        </div>
       <!-- Shortlisted Vendors -->
<div class="col-12 mt-4">
    <div class="p-4 bg-white shadow rounded">
        <h4 class="mb-3 text-center">Shortlisted Vendors ❤️</h4>
        <div class="row">
            <?php while ($vendor = $vendor_result->fetch_assoc()) { ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <img src="img/<?php echo $vendor['image']; ?>" class="card-img-top" alt="Vendor Image">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($vendor['name']); ?></h5>
                            <p class="card-text"><strong>Contact:</strong> <?php echo htmlspecialchars($vendor['contact_person']); ?></p>
                            <p class="card-text"><i class="bi bi-phone"></i> <?php echo htmlspecialchars($vendor['phone']); ?></p>
                            <a href="book_vendor.php?vendor_id=<?php echo $vendor['id']; ?>" class="btn btn-success btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


 <!-- Review Section -->
    <div class="col-6 mt-4">
        <div class="p-4 bg-white shadow rounded">
            <h4 class="mb-3 text-center">Your Reviews ✍️</h4>
            <form action="submit_review.php" method="POST">
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating:</label>
                    <select name="rating" class="form-control" required>
                        <option value="">Select</option>
                        <option value="1">1 ⭐</option>
                        <option value="2">2 ⭐</option>
                        <option value="3">3 ⭐</option>
                        <option value="4">4 ⭐</option>
                        <option value="5">5 ⭐</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="review_text" class="form-label">Your Review:</label>
                    <textarea name="review_text" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
            <hr>
        </div>
    </div>
            </div>
            </div>
<script>
    function updateCountdown() {
        const weddingDate = new Date("<?php echo date('Y-m-d', strtotime($user['wedding_date'])); ?>").getTime();
        const now = new Date().getTime();
        const distance = weddingDate - now;

        if (distance < 0) {
            document.getElementById("countdown").innerHTML = "Wedding Day has passed! 🎉";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        document.getElementById("countdown").innerHTML = days + " days left";
    }
    
    updateCountdown(); // Run once immediately
    setInterval(updateCountdown, 1000); // Update every second
</script>

<?php include "footer.php"; ?>
