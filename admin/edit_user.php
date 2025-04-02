<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['update'])) {
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $wedding_date = $_POST['wedding_date'];
    $password = $_POST['password'];

    // Update query without password
    $sql = "UPDATE users SET name=?, email=?, wedding_date=? WHERE id=?";
    $params = [$name, $email, $wedding_date, $userId];
    $types = "sssi";

    // If admin enters a new password, update it
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET name=?, email=?, wedding_date=?, password=? WHERE id=?";
        $params = [$name, $email, $wedding_date, $hashedPassword, $userId];
        $types = "ssssi";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.'); window.location='manage_users.php';</script>";
    } else {
        echo "Error updating user: " . $stmt->error;
    }
}

// Fetch user data
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$userId");
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

include 'header.php';
?>

<!-- Bootstrap Form Styling -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-dark text-white">
                    <h4>Edit User</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?= $user['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Wedding Date:</label>
                            <input type="date" name="wedding_date" class="form-control" value="<?= htmlspecialchars($user['wedding_date']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password (Leave blank to keep current password):</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="text-center">
                            <button type="submit" name="update" class="btn btn-success">Update User</button>
                            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
