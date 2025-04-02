<?php
include 'config.php';
include "header.php";

$sql = "SELECT id, name, email, message, created_at FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
<main>
    <h3>Contact Messages</h3>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" width="100%" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date Submitted</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["id"]) ?></td>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= nl2br(htmlspecialchars($row["message"])) ?></td>
                    <td><?= $row["created_at"] ?></td>
                    <td>
                        <a href="delete_contact.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>

</main>
    </div></div></div>
<?php
$conn->close();
include "footer.php"; // Include your admin panel's footer
?>