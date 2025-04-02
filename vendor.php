<?php include_once("header.php"); ?>
<html>
<head>
    <title>Vendors | KalyanamKart</title>
    <link rel="stylesheet" href="assets/css/vendor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
</head>
<body>

<h1>Explore Vendors</h1>

<!-- Vendor Categories -->
<div class="vendor-categories">
    <?php
    include 'config.php';

    // Fetch categories dynamically
    $query = "SELECT * FROM vendor_category";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching categories: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($category = mysqli_fetch_assoc($result)) {
            echo '<a href="vendor.php?category=' . urlencode($category['id']) . '">' . htmlspecialchars($category['category_name']) . '</a>';
        }
    } else {
        echo "<p>No categories found.</p>";
    }
    ?>
</div>

<!-- Vendor List -->
<section class="vendor-list">
<?php

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Get shortlisted vendors for the user
$shortlisted_vendors = [];
if ($user_id) {
    $shortlist_query = "SELECT vendor_id FROM shortlisted_vendors WHERE user_id = $user_id";
    $shortlist_result = mysqli_query($conn, $shortlist_query);
    while ($row = mysqli_fetch_assoc($shortlist_result)) {
        $shortlisted_vendors[] = $row['vendor_id'];
    }
}

// Filter vendors by category if selected
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : '';

$query = "SELECT * FROM vendor";
if (!empty($category_filter)) {
    $query .= " WHERE category_id = $category_filter";
}

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching vendors: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    while ($vendor = mysqli_fetch_assoc($result)) {
        $vendor_id = $vendor['id'];
        $is_shortlisted = in_array($vendor_id, $shortlisted_vendors);

        echo '<div class="vendor">';
        echo '<img src="img/' . htmlspecialchars($vendor['image']) . '" alt="' . htmlspecialchars($vendor['name']) . '">';
        echo '<h2>' . htmlspecialchars($vendor['name']) . '</h2>';
        echo '<p><i class="fa fa-user"></i> Contact: ' . htmlspecialchars($vendor['contact_person']) . '</p>';
        echo '<p><i class="fa fa-map-marker"></i> ' . htmlspecialchars($vendor['address']) . '</p>';
        echo '<p><i class="fa fa-phone"></i> ' . htmlspecialchars($vendor['phone']) . '</p>';
        echo '<p><i class="fa fa-envelope"></i> ' . htmlspecialchars($vendor['email']) . '</p>';
        echo '<p><i class="fa fa-globe"></i> <a href="' . htmlspecialchars($vendor['website']) . '" target="_blank">Website</a></p>';
        echo '<p><i class="fa fa-star"></i> ' . htmlspecialchars($vendor['rating']) . '</p>';
        echo '<button class="shortlist-btn" data-vendor-id="' . $vendor_id . '">';
        echo $is_shortlisted ? '❤️' : '🤍';
        echo '</button>';
        echo '</div>';
    }
} else {
    echo "<p style='text-align:center; color: #8c001a;'>No vendors found in this category.</p>";
}
?>
</section>

<script>
$(document).ready(function() {
    $(".shortlist-btn").click(function() {
        let button = $(this);
        let vendorId = button.data("vendor-id");

        $.ajax({
            url: "shortlist_vendor.php",
            type: "POST",
            data: { vendor_id: vendorId },
            success: function(response) {
                if (response === "added") {
                    button.html("❤️");
                } else if (response === "removed") {
                    button.html("🤍");
                } else if (response === "login") {
                    window.location.href = "login.php";
                }
            }
        });
    });
});
</script>

</body>
</html>
