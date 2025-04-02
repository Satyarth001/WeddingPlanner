<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query the database for username & password (without hashing)
    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Direct string comparison (⚠ NOT secure for production)
    if ($admin && $password === $admin['password']) {
        $_SESSION['admin'] = $admin['id']; // Store admin ID in session
        header("Location: index.php"); // Redirect to admin panel
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Wedding Planner</title>
    <link rel="stylesheet" href="/WeddingPlanner/assets/css/style.css">
</head>
<body>
<div class="register-wrapper">
    <div class="register-container">
        <h2>Admin Login</h2>
        
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</div>
</body>
</html>
