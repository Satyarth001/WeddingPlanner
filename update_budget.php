<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch the user ID from session
    $user_id = $_SESSION["user"];
    
    // Fetch the total budget from the POST request
    $total_budget = $_POST['total_budget'];

    // Check if the user already has a budget
    $stmt = $conn->prepare("SELECT * FROM budget WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user already has a budget, update it
    if ($result->num_rows > 0) {
        // Update the existing budget
        $stmt = $conn->prepare("UPDATE budget SET total_budget = ? WHERE user_id = ?");
        $stmt->bind_param("di", $total_budget, $user_id);
        
        if ($stmt->execute()) {
            // If update is successful, redirect back to manage budget page
            $_SESSION['message'] = "Budget updated successfully!";
            header('Location: budget.php');
            exit();
        } else {
            $_SESSION['error'] = "Error updating the budget!";
        }
    } else {
        // If no budget is set, insert a new budget
        $stmt = $conn->prepare("INSERT INTO budget (user_id, total_budget) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $total_budget);

        if ($stmt->execute()) {
            // If insert is successful, redirect back to manage budget page
            $_SESSION['message'] = "Budget added successfully!";
            header('Location: budget.php');
            exit();
        } else {
            $_SESSION['error'] = "Error adding the budget!";
        }
    }
}

header('Location: manage_budget.php'); // Redirect to budget page if accessed without form submission
exit();
?>
