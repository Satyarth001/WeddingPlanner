<?php
session_start();
include 'config.php';
include 'header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch updated budget data with spent amount
$budgets = $conn->query("SELECT b.id, b.user_id, u.name AS user_name, b.total_budget, 
                                b.task_estimate_total
                         FROM budget b 
                         LEFT JOIN users u ON b.user_id = u.id
                         GROUP BY b.id, b.user_id, u.name, b.total_budget");

if (!$budgets) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Budget</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <h3>Manage Budget</h3>
    <table style="width:70%;margin:auto;margin-bottom:100px">
        <tr>
            <th>User Name</th>
            <th>Total Budget</th>
            <th>Spent Amount</th>
            <th>Remaining Budget</th>
       
        </tr>
        <?php while ($budget = $budgets->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($budget['user_name']); ?></td>
                <td>₹<?= number_format($budget['total_budget'], 2); ?></td>
                <td>₹<?= number_format($budget['task_estimate_total'], 2); ?></td>
                <td>₹<?= number_format(($budget['total_budget'] - ($budget['task_estimate_total'] ?? 0)), 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php include "footer.php"; ?>
</body>
</html>
