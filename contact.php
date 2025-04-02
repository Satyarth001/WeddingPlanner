<?php include "header.php"?>
<style>


.contact-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.contact-form input,
.contact-form textarea,
.contact-form button {
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.contact-form button {
    background-color: #8c001a;
    color: white;
    border: none;
    cursor: pointer;
}

.contact-form button:hover {
    background-color: #a4001f;
}
</style>

<?php
include 'config.php';
// Validate form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Your message has been sent successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<main>
        <section class="contact-form">
            <h2>Get in Touch</h2>
            <p>If you have any questions, suggestions, or need assistance, feel free to reach out to us.</p>

            <form action="#" method="POST">
                <label for="name">Your Name:</label>
                <input type="text" name="name" id="name" required>

                <label for="email">Your Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="message">Message:</label>
                <textarea name="message" id="message" rows="6" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </section>
    </main>
    <script>
document.querySelector("form").addEventListener("submit", function(event) {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let message = document.getElementById("message").value.trim();

    let namePattern = /^[a-zA-Z-' ]+$/;
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

    if (name === "" || email === "" || message === "") {
        alert("All fields are required.");
        event.preventDefault();
        return;
    }

    if (!name.match(namePattern)) {
        alert("Only letters, spaces, hyphens, and apostrophes are allowed in the name.");
        event.preventDefault();
        return;
    }

    if (!email.match(emailPattern)) {
        alert("Please enter a valid email address.");
        event.preventDefault();
    }
});
</script>










<?php include "footer.php"?>