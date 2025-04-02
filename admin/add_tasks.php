<?php
include "header.php";
include "config.php";

// Fetch all users
$users_query = $conn->query("SELECT id, name FROM users");

// Add Task
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = intval($_POST['user_id']);
    $task_name = $conn->real_escape_string($_POST['task_name']);

    $insert = $conn->query("INSERT INTO tasks (user_id, task_name, status) VALUES ($user_id, '$task_name', 'Pending')");
    
    if ($insert) {
        echo "<script>alert('Task added successfully!'); window.location='manage_tasks.php';</script>";
    } else {
        echo "<p style='color: red;'>Error adding task: " . $conn->error . "</p>";
    }
}
?>

<h3>Add New Task</h3>

<form method="POST">
    <label for="user_id">Assign to User:</label>
    <select name="user_id" required>
        <option value="">-- Select User --</option>
        <?php while ($user = $users_query->fetch_assoc()): ?>
            <option value="<?= $user['id']; ?>"><?= htmlspecialchars($user['name']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="task_name">Task Name:</label>
    <input type="text" name="task_name" required>

    <button type="submit">Add Task</button>
</form>

<center><a href="manage_tasks.php" class="delete-btn">Back to Tasks</a></center>
<?php include "footer.php"; ?>