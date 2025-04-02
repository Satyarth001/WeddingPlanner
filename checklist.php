<?php
include_once("header.php");
require_once "config.php"; // Database connection

// Ensure user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"];

// 📝 Handle Add Task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_name"])) {
    $task_name = trim($_POST["task_name"]);
    
    if (!empty($task_name)) {
        $sql = "INSERT INTO tasks (user_id, task_name, status) VALUES (?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("is", $user_id, $task_name);
            $stmt->execute();
            $stmt->close();
            header("Location: checklist.php?success=Task added!");
            exit();
        } else {
            die("SQL Error: " . $conn->error);
        }
    }
}

// ✅ Handle Task Update (Mark as Completed)
if (isset($_GET["complete_id"])) {
    $task_id = $_GET["complete_id"];
    $sql = "UPDATE tasks SET status = 'Completed' WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: checklist.php?success=Task marked as completed!");
        exit();
    }
}

// ❌ Handle Task Delete
if (isset($_GET["delete_id"])) {
    $task_id = $_GET["delete_id"];
    $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: checklist.php?success=Task deleted!");
        exit();
    }
}

// 📋 Fetch Tasks
$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$task_result = $stmt->get_result();
?>
<style>
    .container {
    width: 80%;
    margin: 30px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2{
    text-align: center;
    color: #660000;
    margin-bottom: 20px;
	font-size:40px;
	font-family:Bell MT;
	font-weight:bold;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 15px;
}

/* 📋 Task Form */
.task-form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.task-form input {
    flex: 1;
    padding: 10px;
    border: 2px solid #8c001a;
    border-radius: 5px;
    font-size: 16px;
}

.task-form button {
    background: #8c001a;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.task-form button:hover {
    background: black;
}

/* 📋 Checklist Table */
.checklist-table table {
    width: 100%;
    border-collapse: collapse;
}

.checklist-table th, .checklist-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

.checklist-table th {
    background: #8c001a;
    color: white;
}

/* ✅ Task Status */
.completed {
    color: green;
    font-weight: bold;
}

.pending {
    color: orange;
    font-weight: bold;
}

/* 🛠️ Action Buttons */
.complete-btn {
    background: green;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    margin-right: 5px;
}

.complete-btn:hover {
    background: darkgreen;
}

.delete-btn {
    background: red;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
}

.delete-btn:hover {
    background: darkred;
}
</style>
<div class="container">
    <h2 class="page-title">Wedding Checklist</h2>

    <?php if (isset($_GET["success"])): ?>
        <p class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></p>
    <?php endif; ?>

    <form method="POST" class="task-form">
        <input type="text" name="task_name" placeholder="Enter a new task..." required>
        <button type="submit">Add Task</button>
    </form>

    <div class="checklist-table">
        <table>
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Estimated Cost ($)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($task = $task_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task["task_name"]); ?></td>
                        <td class="<?php echo ($task["status"] == "Completed") ? "completed" : "pending"; ?>">
                            <?php echo htmlspecialchars($task["status"]); ?>
                        </td>
                        <td>$<?php echo number_format($task["estimated_cost"], 2); ?></td>
                        <td>
                            <a href="checklist.php?delete_id=<?php echo $task["id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure?');">❌ Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const taskForm = document.querySelector(".task-form");
        const taskInput = document.querySelector("input[name='task_name']");

        taskForm.addEventListener("submit", function (event) {
            let taskName = taskInput.value.trim();
            let taskRegex = /^[a-zA-Z0-9\s.,!?'-]+$/;
            let numberOnlyRegex = /^\d+$/; // Matches only numbers

            if (taskName === "") {
                alert("Task name cannot be empty!");
                event.preventDefault();
                return;
            }
            if (numberOnlyRegex.test(taskName)) {
                alert("Task name cannot contain only numbers!");
                event.preventDefault();
                return;
            }
            if (!taskRegex.test(taskName)) {
                alert("Task name contains invalid characters!");
                event.preventDefault();
            }
        });
    });
</script>


<?php include_once("footer.php"); ?>
