<?php
session_start();
include 'config.php';
include 'header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Fetch all users for the dropdown
$users_query = $conn->query("SELECT id, name FROM users");

// Handle filtering by user
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$task_status = isset($_GET['status']) ? $_GET['status'] : '';

$task_query = "SELECT tasks.id, tasks.task_name, tasks.status, tasks.estimated_cost, users.name AS user_name 
               FROM tasks 
               JOIN users ON tasks.user_id = users.id";

if ($user_id > 0) {
    $task_query .= " WHERE tasks.user_id = $user_id";
    if ($task_status === 'pending') {
        $task_query .= " AND tasks.status = 'Pending'";
    }
} elseif ($task_status === 'pending') {
    $task_query .= " WHERE tasks.status = 'Pending'";
}

$tasks = $conn->query($task_query);

// Handle Estimated Cost Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cost'])) {
    $task_id = intval($_POST['task_id']);
    $estimated_cost = floatval($_POST['estimated_cost']);
    $conn->query("UPDATE tasks SET estimated_cost = $estimated_cost WHERE id = $task_id");
    
    header("Location: manage_tasks.php");
    exit();
}

// Handle Status Update (AJAX)
if (isset($_POST['update_status']) && isset($_POST['task_id']) && isset($_POST['status'])) {
    $task_id = intval($_POST['task_id']);
    $status = $_POST['status'];

    $conn->query("UPDATE tasks SET status = '$status' WHERE id = $task_id");
    echo json_encode(['status' => 'success', 'new_status' => $status]);
    exit();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Manage Tasks</h3>
            <center><a href="add_tasks.php" class="delete-btn">Add New Task</a></center>

            <!-- Filter by User -->
            <form method="GET">
                <label for="user">Filter by User:</label>
                <select name="user_id">
                    <option value="0">All Users</option>
                    <?php while ($user = $users_query->fetch_assoc()): ?>
                        <option value="<?= $user['id']; ?>" <?= $user['id'] == $user_id ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($user['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <!-- Filter by Status -->
                <label for="status">Task Status:</label>
                <select name="status">
                    <option value="">All</option>
                    <option value="pending" <?= $task_status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                </select>

                <button type="submit">Filter</button>
            </form>
        </div>
    </div>
</div>

<!-- Task Table -->
<table border="1">
    <tr>
        <th>Task ID</th>
        <th>Task Name</th>
        <th>User</th>
        <th>Status</th>
        <th>Estimated Cost (₹)</th>
        <th colspan="2">Actions</th>
    </tr>
    <?php while ($task = $tasks->fetch_assoc()): ?>
        <tr>
            <td><?= $task['id']; ?></td>
            <td><?= htmlspecialchars($task['task_name']); ?></td>
            <td><?= htmlspecialchars($task['user_name']); ?></td>
            <td id="status_<?= $task['id']; ?>"><?= htmlspecialchars($task['status']); ?></td>
            <td>
                <form method="post" style="display: flex; gap: 5px;">
                    <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                    <input type="number" step="0.01" name="estimated_cost" value="<?= $task['estimated_cost']; ?>" required>
                    <button type="submit" name="update_cost">Update</button>
                </form>
            </td>
            <td>
                <!-- Update Status Button -->
                <button class="update-status-btn" data-task-id="<?= $task['id']; ?>" data-status="Completed">Complete</button></td><td>
                <button class="update-status-btn" data-task-id="<?= $task['id']; ?>" data-status="Pending">Mark as Pending</button>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<script>
    // Update status using AJAX
    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const status = this.getAttribute('data-status');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'manage_tasks.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // Immediately update the status in the DOM without a page refresh
                        document.getElementById('status_' + taskId).innerText = response.new_status;

                        // Optionally, you can change the button to reflect the new status (if needed)
                        const statusButton = document.querySelector(`[data-task-id='${taskId}']`);
                        statusButton.innerText = response.new_status === 'Completed' ? 'Mark as Pending' : 'Complete';
                    }
                }
            };
            xhr.send('update_status=true&task_id=' + taskId + '&status=' + status);
        });
    });
</script>

<?php include "footer.php"; ?>
