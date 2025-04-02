<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent</title>
    <style>
	@import url('https://fonts.googleapis.com/css2?family=Blackadder+ITC&display=swap');

body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.success-message {
    text-align: center;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.success-message h2 {
    font-family: 'Blackadder ITC', cursive;
    color: #660000;
    font-size: 32px;
    margin-bottom: 10px;
}

.success-message p {
    font-size: 18px;
    color: #333;
    margin-bottom: 20px;
}

.success-message a {
    display: inline-block;
    padding: 10px 20px;
    background: #660000;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: 0.3s;
}

.success-message a:hover {
    background: #990000;
}
</style>
</head>
<body>
    <div class="success-message">
        <h2>🎉 Your Message Has Been Sent Successfully!</h2>
        <p>We will get back to you shortly.</p>
        <a href="index.php">Go to Home</a>
    </div>
</body>
</html>
