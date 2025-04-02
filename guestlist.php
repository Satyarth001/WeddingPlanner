<?php
include_once("header.php");
require_once "config.php"; // Adjust path if needed

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"];

// Fetch guest list
$guest_query = $conn->prepare("SELECT id, guest_name, rsvp_status FROM guestlist WHERE user_id = ?");
$guest_query->bind_param("i", $user_id);
$guest_query->execute();
$guest_result = $guest_query->get_result();

// Update RSVP status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guest_id"], $_POST["rsvp_status"])) {
    $guest_id = $_POST["guest_id"];
    $rsvp_status = $_POST["rsvp_status"];

    $update_query = $conn->prepare("UPDATE guestlist SET rsvp_status = ? WHERE id = ? AND user_id = ?");
    $update_query->bind_param("sii", $rsvp_status, $guest_id, $user_id);
    $update_query->execute();
    header("Location: guestlist.php?success=1");
    exit();
}

// Delete Guest
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_guest"])) {
    $guest_id = $_POST["delete_guest"];
    $delete_query = $conn->prepare("DELETE FROM guestlist WHERE id = ? AND user_id = ?");
    $delete_query->bind_param("ii", $guest_id, $user_id);
    $delete_query->execute();
    header("Location: guestlist.php?deleted=1");
    exit();
}
?>
<style>
    /* 📝 Guest List Page */
.container {
    width: 90%;
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* 🏷️ Page Title */
.page-title {
   text-align: center;
    color: #660000;
    margin-bottom: 20px;
	font-size:40px;
	font-family:Bell MT;
	font-weight:bold;
}

/* ✅ Success Message */
.success-message {
    text-align: center;
    background: #28a745;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}

/* 📋 Guest Table */
.guest-table {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background: #8c001a;
    color: white;
    font-size: 16px;
}

/* 🖱️ Hover Effect */
tr:hover {
    background: #f8d7da;
}

/* 🔄 Form Elements */
select, button {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* 🎯 Update Button */
button {
    background: #8c001a;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #720014;
}

/* 🗑️ Delete Button */
.delete-btn {
    background: #dc3545;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.delete-btn:hover {
    background: #a71d2a;
}
</style>
<div class="container">
    <h2 class="page-title">Guest List</h2>
    <center><a href="add_guest.php" class="delete-btn">Add Guest</a></center>  <br/><br/>
    <?php if (isset($_GET["success"])): ?>
        <p class="success-message">RSVP status updated successfully!</p>
    <?php elseif (isset($_GET["deleted"])): ?>
        <p class="success-message" style="background: #dc3545;">Guest deleted successfully!</p>
    <?php endif; ?>

    <div class="guest-table">
        <table>
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>RSVP Status</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($guest = $guest_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($guest["guest_name"]); ?></td>
                        <td><?php echo htmlspecialchars($guest["rsvp_status"]); ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="guest_id" value="<?php echo $guest["id"]; ?>">
                                <select name="rsvp_status">
                                    <option value="Pending" <?php echo ($guest["rsvp_status"] == "Pending") ? "selected" : ""; ?>>Pending</option>
                                    <option value="Confirmed" <?php echo ($guest["rsvp_status"] == "Confirmed") ? "selected" : ""; ?>>Confirmed</option>
                                    <option value="Declined" <?php echo ($guest["rsvp_status"] == "Declined") ? "selected" : ""; ?>>Declined</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="delete_guest" value="<?php echo $guest["id"]; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once("footer.php"); ?>
