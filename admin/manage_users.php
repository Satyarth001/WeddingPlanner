<?php
session_start();
include 'config.php';
include 'header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}


// Fetch Users
$sql = "SELECT users.id, users.name, users.email, users.wedding_date, venues.name AS venue_name
        FROM users 
        LEFT JOIN venues ON users.venue_id = venues.id";
$users = $conn->query($sql);

if (!$users) {
    die("Query failed: " . $conn->error);
}
?>

<h3>Manage Users</h3>
<table border="1" style="width:70%;margin:auto;">
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Wedding Date</th>
        <th>Venue</th>
        <th>Actions</th>
    </tr>
    <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']); ?></td>
            <td><?= htmlspecialchars($user['name']); ?></td>
            <td><?= htmlspecialchars($user['email']); ?></td>
            <td><?= htmlspecialchars($user['wedding_date']); ?></td>
            <td><?= htmlspecialchars($user['venue_name'] ?: 'Not Assigned'); ?></td>
            <td>
            <a href="edit_user.php?user_id=<?= $user['id']; ?>" class="btn btn-warning">Edit</a>  |
                <a href="assign_venue.php?user_id=<?= $user['id']; ?>" class="btn btn-primary">Assign Venue</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include "footer.php"; ?>
