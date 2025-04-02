<?php
include "header.php";
include "config.php";

if (!isset($_GET['task_id'])) {
    die("Invalid request!");
}

$task_id = intval($_GET['task_id']);
$task_query = $conn->query("SELECT * FROM tasks WHERE id = $task_id");
$task = $task_query->fetch_assoc();
if (!$task) {
    die("Task not found!");
}

// Update Task
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $conn->real_escape_string($_POST['status']);
    
    $update = $conn->query("UPDATE tasks SET status = '$status' WHERE id = $task_id");
    
    if ($update) {
        echo "<script>alert('Task updated successfully!'); window.location='manage_tasks.php';</script>";
    } else {
        echo "<p style='color: red;'>Error updating task: " . $conn->error . "</p>";
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
<h2>Edit Task</h2>

<form method="POST">
    <label for="status">Status:</label>
    <select name="status">
        <option value="Pending" <?= $task['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
        <option value="Completed" <?= $task['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
    </select>

    <button type="submit">Update Task</button>
</form>

<a href="manage_tasks.php">Back to Tasks</a>
</div></div></div>