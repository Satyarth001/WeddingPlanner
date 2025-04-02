<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JavaScript Bundle (Popper included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="/weddingplanner/admin/assets/css/admin.css">
</head>
<body>
    <header>
        <h2>Welcome, <?php echo htmlspecialchars($admin['name'] ?? 'Admin'); ?>!</h2>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_venues.php">Manage Venues</a></li>
                <li><a href="manage_tasks.php">Manage Tasks</a></li>
                <li><a href="manage_bugdet.php">Manage Budget</a></li>
                <li><a href="contact_info.php">Contact Info</a></li>
                <li><a href="view_reviews.php">Reviews</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>