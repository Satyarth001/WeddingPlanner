
<head>
	<title>footer</title>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<style>
	/* Footer Styles */
footer {
  background-color: #660000;
  color: white;
  width: 100%;
  padding: 40px 20px;
  margin-top: 40px;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  width: 90%;
  max-width: 1200px;
  margin: 0 auto;
}


.footer-links,
.footer-contact,
.footer-social {
  flex: 1;
  min-width: 200px;
  margin-bottom: 20px;
}

.footer-links h3,
.footer-contact h3,
.footer-social h3 {
  font-size: 16px;
  margin-bottom: 10px;
}

.footer-links ul {
  list-style: none;
  padding: 0;
}

.footer-links ul li {
  margin-bottom: 5px;
}

.footer-links ul li a {
  color: #ccc;
  text-decoration: none;
}

.footer-links ul li a:hover {
  color: white;
}

.footer-contact p,
.footer-social a {
  font-size: 14px;
  margin-bottom: 10px;
}

.footer-social a {
  color: #ccc;
  margin-right: 10px;
  text-decoration: none;
  font-size: 18px;
}

.footer-social a:hover {
  color: white;
}
.footer-logo{
	font-family:Blackadder ITC;
	font-weight:bold;
}
.footer-bottom {
  text-align: center;
  border-top: 1px solid #444;
  padding-top: 20px;
  margin-top: 20px;
  font-size: 14px;
}
	</style>
</head>
<body>
	<footer>
		<div class="footer-container">
			<div class="footer-links">
				<h3>Quick Links</h3>
				<ul>
					<li><a href="#" class="active">Home</a></li>
					<li><a href="abt.php">About</a></li>
					<li><a href="venue.php">Venues</a></li>
					<li><a href="vendor.php">Vendors</a></li>
					 <li><a href="pricing.php">Pricing</a></li>
					<li><a href="contact.php">Contact Us</a></li>
				</ul>
			</div>
			<div class="footer-contact">
				<h3>Contact Us</h3>
				<p><i class="fa fa-map-marker"></i> 123 Wedding Street, City, Country</p>
				<p><i class="fa fa-phone"></i> +1 234 567 890</p>
				<p><i class="fa fa-envelope"></i> info@kalyanamkart.com</p>
			</div>
			 <div class="footer-social">
                <h3>Follow Us</h3>
                <a href="https://www.facebook.com" target="_blank"><i class="fa-facebook"></i></a>
                <a href="https://www.instagram.com" target="_blank"><i class="fa-instagram"></i></a>
                <a href="https://www.twitter.com" target="_blank"><i class="fa-twitter"></i></a>
                <a href="https://www.youtube.com" target="_blank"><i class="fa-youtube"></i></a>
            </div>
		</div>
		<div class="footer-bottom">
			<h4><div class="footer-logo">Kalyanamkart</div></h4>
			<p>&copy; 2025 Kalyanam Kart. All Rights Reserved.</p>
		</div>
	</footer>
</body>
</html>
<?php
?>