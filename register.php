<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $wedding_date = $_POST["wedding_date"];

    $query = $conn->prepare("INSERT INTO users (name, email, password, wedding_date) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssss", $name, $email, $password, $wedding_date);

    if ($query->execute()) {
        header("Location: login.php?success=registered");
    } else {
        echo "Error: " . $query->error;
    }
}
?>
<html>
<head>
    <title>Register | Wedding Planner</title>
    <link rel="stylesheet" href="/WeddingPlanner/assets/css/style.css">
	<style>
	h1{
		font-family:Blackadder ITC;
		color:#660000;
	}
	h2{
		color:#660000;
	}
	</style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <h2>Join Us Now</h2>
			<h1>KalyanamKart</h1>
            <p class="subtitle">Create a free account to unlock your personalized event planning dashboard.!</p>
            <form action="" method="POST">
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="input-group">
                    <label for="wedding_date">Wedding Date</label>
                    <input type="date" id="wedding_date" name="wedding_date" required>
                </div>

                <button type="submit" class="register-btn">Create Account</button>

                <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
            </form>
        </div>
    </div>
    <script>
document.querySelector("form").addEventListener("submit", function(event) {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let weddingDate = document.getElementById("wedding_date").value;

    let namePattern = /^[A-Za-z\s]+$/;  // Only allows letters and spaces
    let emailPattern = /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/;  // Basic email validation
    let today = new Date().toISOString().split("T")[0]; // Get today's date

    if (name === "" || email === "" || password === "" || weddingDate === "") {
        alert("All fields are required.");
        event.preventDefault();
        return;
    }

    if (!name.match(namePattern)) {
        alert("Full Name should only contain letters and spaces.");
        event.preventDefault();
        return;
    }

    if (!email.match(emailPattern)) {
        alert("Please enter a valid email address.");
        event.preventDefault();
        return;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        event.preventDefault();
        return;
    }

    if (weddingDate < today) {
        alert("Wedding date cannot be in the past.");
        event.preventDefault();
    }
});
</script>

</body>
</html>
