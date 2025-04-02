<?php
include 'config.php';
include 'header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION["user"];

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM budget WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$budget_result = $stmt->get_result();

if (!$budget_result) {
    die("Query failed: " . $conn->error);
}

$budget = $budget_result->fetch_assoc();
$total_budget = $budget['total_budget'] ?? 0; // If no budget, set default to 0
$task_estimate_total = $budget['task_estimate_total'] ?? 0;
$remaining_budget = $total_budget - $task_estimate_total;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Budget</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        /* 🌟 General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fc;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h3 {
            color: #8c001a;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* 📋 Budget Table */
        .budget-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        th, td {
            padding: 18px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #8c001a;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #f3c0c7;
            transition: 0.3s;
        }

        /* 🎨 Input and Button Styling */
        .budget-form {
            text-align: left;
            margin-top: 20px;
        }

        .budget-form label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            color: #333;
        }

        .budget-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .budget-form button {
            padding: 12px 30px;
            background-color: #8c001a;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .budget-form button:hover {
            background-color: #7a0014;
        }

        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .alert-success {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Manage Budget</h3>

    <?php if ($total_budget == 0): ?>
        <!-- If no budget set, show the 'Add Budget' form -->
        <h4>Add Your Total Budget</h4>
        <form action="update_budget.php" method="POST" class="budget-form">
            <div>
                <label for="total_budget">Set Total Budget: </label>
                <input type="number" id="total_budget" name="total_budget" value="<?= $total_budget ?>" required>
            </div>
            <button type="submit">Add Budget</button>
        </form>
    <?php else: ?>
        <!-- If budget is set, show the 'Update Budget' form -->
        <h4>Your Current Budget</h4>
        <table class="budget-table">
            <tr>
                <th>Total Budget</th>
                <th>Spent Amount</th>
                <th>Remaining Budget</th>
            </tr>
            <tr>
                <td>₹<?= number_format($total_budget, 2); ?></td>
                <td>₹<?= number_format($task_estimate_total, 2); ?></td>
                <td>₹<?= number_format($remaining_budget, 2); ?></td>
            </tr>
        </table>

        <h4>Update Your Budget</h4>
        <form action="update_budget.php" method="POST" class="budget-form">
            <div>
                <label for="total_budget">Update Total Budget: </label>
                <input type="number" id="total_budget" name="total_budget" value="<?= $total_budget ?>" required>
            </div>
            <button type="submit">Update Budget</button>
        </form>
    <?php endif; ?>

</div>

<?php include "footer.php"; ?>
</body>
</html>
