<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Ensure task_id is provided and valid
if (isset($_GET['task_id']) && is_numeric($_GET['task_id'])) {
    $task_id = intval($_GET['task_id']);

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Task deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete task.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid task ID.";
}

$conn->close();
header("Location: manage_tasks.php");
exit();
?>
