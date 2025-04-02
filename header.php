<?php 
session_start();

// Database connection
include 'config.php'; // Ensure config.php contains database connection details

// Fetch vendor categories from the database
$query = "SELECT id, category_name FROM vendor_category ORDER BY category_name ASC";
$result = mysqli_query($conn, $query);
?>
<html>
<head>
    <title>Kalyanam Kart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/first.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="<?php echo isset($_SESSION['user']) ? 'dashboard.php' : 'index.php'; ?>">KalyanamKart</a>
            </div>
            <div class="nav-bar" id="nav-menu">
                <a href="about.php">About</a>
                <a href="venue.php">Venue</a>
                <div class="dropdown">
                    <a href="wed_plan_tools.php" class="dropdown-toggle">Wedding Planning Tools</a>
                   <?php if (isset($_SESSION['user'])): ?>
						<div class="dropdown-content">
							<a href="budget.php">Budget Planner</a>
							<a href="checklist.php">Tasks & Checklist</a>
							<a href="guestlist.php">Guest List Manager</a>
						</div>
					<?php else: ?>
						<div class="dropdown-content">
							<a href="register.php">Budget Planner</a>
							<a href="register.php">Tasks & Checklist</a>
							<a href="register.php">Guest List Manager</a>
						</div>
					<?php endif; ?>
                </div>
                <a href="vendor.php">Vendors</a>
                <a href="inspiration.php">Inspiration</a>
                <a href="contact.php">Contact</a>
            </div>

            <?php if (isset($_SESSION['user'])): ?>
                <button class="login-btn"><a href="logout.php">Logout</a></button>
            <?php else: ?>
                <button class="login-btn"><a href="login.php">Log In</a></button>
            <?php endif; ?>
        </nav>
    </header>

    <script>
        function searchFunction() {
            let input = document.getElementById("search-input").value.toLowerCase();
            let resultsBox = document.getElementById("search-results");

            if (input.length === 0) {
                resultsBox.innerHTML = "";
                resultsBox.style.display = "none";
                return;
            }

            $.ajax({
                url: "search.php", 
                type: "POST",
                data: { search_query: input },
                success: function(response) {
                    resultsBox.innerHTML = response;
                    resultsBox.style.display = "block";
                }
            });
        }
    </script>

   
</body>
</html>
