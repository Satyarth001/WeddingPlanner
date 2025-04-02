<?php
include_once("header.php");
require_once "config.php"; // Adjust path if needed

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"];
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guest_name"])) {
    $guest_name = trim($_POST["guest_name"]);
    $rsvp_status = $_POST["rsvp_status"];

    if (!preg_match("/^[a-zA-Z\s]+$/", $guest_name)) {
        $error = "Guest name can only contain letters and spaces!";
    } else {
        $insert_query = $conn->prepare("INSERT INTO guestlist (user_id, guest_name, rsvp_status) VALUES (?, ?, ?)");
        $insert_query->bind_param("iss", $user_id, $guest_name, $rsvp_status);
        $insert_query->execute();
        header("Location: guestlist.php?added=1");
        exit();
    }
}
?>

<style>
    .container {
        width: 90%;
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .page-title {
        text-align: center;
        font-size: 28px;
        font-weight: bold;
        color: #8c001a;
        margin-bottom: 20px;
    }
    .error-message {
        text-align: center;
        background: #dc3545;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    label, input, select, button {
        display: block;
        width: 100%;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
    }
    button {
        background: #8c001a;
        color: white;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }
    button:hover {
        background: #720014;
    }
    .error-text {
        color: red;
        font-size: 14px;
        display: none;
    }
</style>

<div class="container">
    <h2 class="page-title">Add Guest</h2>
    
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="" onsubmit="return validateGuestName()">
        <label for="guest_name">Guest Name:</label>
        <input type="text" id="guest_name" name="guest_name" required>
        <small id="nameError" class="error-text">Only letters and spaces are allowed.</small>

        <label for="rsvp_status">RSVP Status:</label>
        <select id="rsvp_status" name="rsvp_status">
            <option value="Pending">Pending</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Declined">Declined</option>
        </select>

        <button type="submit">Add Guest</button>
    </form>
</div>

<script>
    function validateGuestName() {
        let nameField = document.getElementById("guest_name");
        let nameError = document.getElementById("nameError");
        let nameRegex = /^[a-zA-Z\s]+$/;

        if (!nameRegex.test(nameField.value)) {
            nameError.style.display = "block";
            return false; // Prevent form submission
        } else {
            nameError.style.display = "none";
            return true; // Allow form submission
        }
    }

    document.getElementById("guest_name").addEventListener("input", function () {
        validateGuestName();
    });
</script>

<?php include_once("footer.php"); ?>
