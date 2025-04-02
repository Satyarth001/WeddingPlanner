<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['id'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid credentials!";
    }
}
?>
<html>
<head>
    <title>Register | Wedding Planner</title>
    <link rel="stylesheet" href="/WeddingPlanner/assets/css/style.css">
	<style>
 body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      background-color: #eaeaea;
      text-align: center;
      margin: 0;
      padding-top: 80px; /* Adjusted to prevent header overlap */
    }
    .login-page {
      display: flex;
      background-color: white;
      border-radius: 8px;
      margin-top: 20px; /* Added margin to prevent header overlap */
    }
    h1 {
      font-family: Bell MT;
    }
    .image-section {
      background: url(img/login.jpg);
      width: 50%;
      color: white;
      text-align: center;
      padding: 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
	  background-size: cover;
    }
    .image-section h1 {
      font-size: 24px;
      
    }
	.image-section h4 {
      font-size: 24px;
     font-family:Bell TM;
    }
	.image-section p {
      font-size: 24px;
      margin-bottom: 10px;
	  font-family:Blackadder ITC;
    }
    .login-section {
      width: 50%;
      padding: 40px;
    }
    form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
.form-container {
    width: 50%;
    padding: 20px;
    text-align: center;
}

.input-group {
    margin-bottom: 15px;
    text-align: left;
}

.input-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    background-color: #660000;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
}

button:hover {
   background: #ffccd5;
    color: black;
}

.register-link {
    display: block;
    margin-top: 10px;
    color: #007bff;
    text-decoration: none;
	color:black;
}

.register-link:hover {
    text-decoration: underline;
}

	</style>
</head>
<body>
<div class="login-page">
    <div class="image-section">
      <h1>Bring Your Wedding Dreams to Life.</h1>
	  <h4>with</h4>
      <p>KalyanamKart</p>
    </div>
    <div class="login-section">
        <h1>Welcome Back!</h1>
		<p>Sign in to access our services.</p>
            <form action="" method="POST">
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <a href="register.php" class="register-link">Don't have an account? Register here</a>
        </div>
    </div>
<script>
document.querySelector("form").addEventListener("submit", function(event) {
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    let emailPattern = /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/; // Email validation

    if (email === "" || password === "") {
        alert("All fields are required.");
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
    }
});
</script>

</body>
</html>

