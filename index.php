<?php include "header.php"?>
<style>
.wedding-categories-header {
    text-align: center;
    margin-top: 20px; 
}

.wedding-categories-header a {
    display: inline-block;
    text-decoration: none;
    font-size: 16px; 
    color:#1a0000; 
    padding: 10px 20px;
}


.wedding-categories h2 {
  font-size: 36px;
  font-weight:bold;
  color: #660000;
  align-items: center;
  margin-bottom: 20px;
}
/* Reviews Section */
.reviews-section {
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(to bottom, #fff3f3, #ffebeb);
}

.reviews-section h2 {
    color: #660000;
    font-weight: bold;
    font-size: 36px;
    margin-bottom: 25px;
   
}

/* Reviews Slider */
.reviews-container {
    max-width: 100%;
    overflow: hidden;
    position: relative;
    padding: 10px 0;
}

.reviews-slider {
    display: flex;
    gap: 15px;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    overflow-x: auto;
    scrollbar-width: none;
    animation: scroll 18s linear infinite;
}

/* Individual Review Box */
.review-box {
    flex: 0 0 320px;
    background: #660000;
    color: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    scroll-snap-align: center;
}

.review-box:hover {
    transform: translateY(-5px);
    box-shadow: 6px 6px 18px rgba(0, 0, 0, 0.2);
}

/* Reviewer Info */
.reviewer {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
}

.reviewer img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid white;
}

.reviewer-name {
    font-size: 14px;
    font-weight: bold;
}

/* Review Text */
.review-text {
    font-size: 16px;
    line-height: 1.6;
    font-style: italic;
}

/* Write Review Button */
.write-review-btn {
    display: inline-block;
    padding: 12px 20px;
    background: #660000;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    margin-top: 20px;
    transition: background 0.3s ease-in-out, transform 0.2s;
}

.write-review-btn:hover {
    background: #990000;
    transform: scale(1.05);
}

/* Smooth Auto Scroll */
@keyframes scroll {
    from { transform: translateX(100%); }
    to { transform: translateX(-100%); }
}

/* Pause Animation on Hover */
.reviews-slider:hover {
    animation-play-state: paused;
}

/* Responsive Design */
@media (max-width: 768px) {
    .reviews-slider {
        flex-wrap: nowrap;
        overflow-x: scroll;
        animation: none;
        scroll-snap-type: x mandatory;
        padding-bottom: 10px;
    }

    .review-box {
        min-width: 85%;
        margin: auto;
    }
}


</style>
    <div class="banner">
        <video autoplay muted loop>
            <source src="img/bg.mp4" type="video/mp4">
        </video>
        <div class="banner-content">
            <h1>KalayanamKart</h1>
            <h2>One Stop Destination For All Your Wedding Needs</h2>
            <p></p>
            <div class="start-planning-btn">
            <a href="register.php" class="start-btn">Start Planning Now</a>
            </div>
        </div>
    </div>

        <!-- end of header --->
        <section class="about-section">
			<div class="container">
				<h2>About Kalyanam Kart</h2>
					<p class="about-intro">
					Welcome to <strong>KalyanamKart</strong>, your one-stop destination for all wedding planning needs.
					From stunning venues to the best vendors, we help make your special day memorable and stress-free.
					"Planning a wedding should be joyful, not stressful! KalyanamKart is your one-stop platform to effortlessly
					manage every wedding detail. From budgeting and checklists to guest lists and event timelines, 
					we bring all your wedding essentials under one roof. Start your dream wedding journey with us today!
					</p>
				<a href="about.php" class="more-about-btn">More About Us</a>
			</div>
		</section>
		
        <section class="wedding-categories">
		<center><h2>Wedding Categories</h2></center>
		<div class="wedding-categories-header">
			<a href="vendor.php">View all Categories -></a>
		</div>
            <div class="category-container">
                <div class="category" onclick="toggleDropdown('venues-dropdown')">
                    <div class="category-header">
                        <div class="category-info">
                            <a href="venue.php"><h3>Venues</h3></a>
                            <p>Banquet Halls, Marriage Garden / Lawn...</p>
                        </div>
                        <img src="img/venues.jpeg">
                    </div>
                </div>
                <div class="category" onclick="toggleDropdown('photographers-dropdown')">
                    <div class="category-header">
                        <div class="category-info">
                            <a href="venue.php"><h3>Venues</h3></a>
                            <p>Wedding Photographers</p>
                        </div>
                        <img src="img/photographers.jpeg">
                    </div>
                </div>

                <div class="category" onclick="toggleDropdown('makeup-dropdown')">
                    <div class="category-header">
                        <div class="category-info">
                            <a href="venue.php"><h3>Venues</h3></a>
                            <p>Bridal Makeup, Family Makeup</p>
                        </div>
                        <img src="img/makeup.jpeg">
                    </div>
                </div>
                <div class="category" onclick="toggleDropdown('prewedding-dropdown')">
                    <div class="category-header">
                        <div class="category-info">
                            <a href="venue.php"><h3>Venues</h3></a>
                            <p>Locations, Ideas, Packages...</p>
                        </div>
                        <img src="img/prewedding.jpeg">
                    </div>
                </div>
                <div class="category" onclick="toggleDropdown('bridal_wear-dropdown')">
                    <div class="category-header">
                        <div class="category-info">
                            <a href="venue.php"><h3>Venues</h3></a>
                            <p>Bridal Lehengas, Kanjeevaram / Silk...</p>
                        </div>
                        <img src="img/bridal_wear.jpg">
                    </div>
                </div>
                <div class="category" onclick="toggleDropdown('planning_decor-dropdown')">
                    <div class="category-header">
                        <div class="category-info">
                            <a href="venue.php"><h3>Venues</h3></a>
                            <p>Wedding Planners, Decorators</p>
                        </div>
                        <img src="img/planning_decor.jpg">
                    </div>
                </div>
            </div>
        </section>
        <section class="plan-your-wedding">
    <h2>Plan Your Wedding Effortlessly</h2>
    <p class="subtitle">All the tools you need for a stress-free wedding planning experience</p>
    <div class="planning-steps">
        <!-- Step 1: account -->
        <div class="plan-step">
            <a href="login.php"><div class="icon purple">
                <i class="fas fa-wallet"></i>
            </div>
            <h3>Create an Account</h3>
            <p>Register/Login to access our services</p>
        </div></a>
        <!-- Step 2:set preferences -->
        <div class="plan-step">
            <a href="budget.php"><div class="icon orange">
                <i class="fas fa-users"></i>
            </div>
            <h3>Set Your Preferences</h3>
            <p> Set your wedding date & track your wedding budget.</p>
        </div></a>
        <!-- Step 3:shortlist -->
        <div class="plan-step">
            <a href="inspiration.php"><div class="icon blue">
                <i class="fas fa-tasks"></i>
            </div>
            <h3> Browse & Shortlist</h3>
            <p> Explore venues, inspirations & more.</p>
        </div></a>

        <!-- Step 4: track -->
        <div class="plan-step">
           <a href="checklist.php"><div class="icon green">
                <i class="fas fa-comments"></i>
            </div>
            <h3>Plan and Track</h3>
            <p>Use Task checklist features to stay on track.</p>
        </div></a>

        <!-- Step 5: Enjoy Your Big Day -->
        <div class="plan-step">
            <a href="add_review.php"><div class="icon gold">
                <i class="fas fa-heart"></i>
            </div>
            <h3>Enjoy Your Big Day</h3>
            <p>Cherish every moment of your perfect wedding & give review.</p>
        </div></a>
    </div>
</section>



        <section class="gallery-section">
            <h2>Picture Gallery</h2>
            <div class="gallery-container">
                <div class="gallery-item">
                    <img src="img/gallery1.jpeg" alt="Wedding Venue">
                    <div class="overlay">
                        <p>Wedding Venues</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="img/gallery2.jpeg" alt="Bridal Makeup">
                    <div class="overlay">
                        <p>Bridal Makeup</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="img/gallery3.jpeg" alt="Photography">
                    <div class="overlay">
                        <p>Photography</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="img/gallery4.jpeg" alt="Wedding Decor">
                    <div class="overlay">
                        <p>Wedding Decor</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="img/gallery5.jpeg" alt="Traditional Attire">
                    <div class="overlay">
                        <p>Traditional Attire</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="img/gallery6.jpeg" alt="Destination Weddings">
                    <div class="overlay">
                        <p>Destination Weddings</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="img/gallery7.jpg" alt="Invitation Design">
                    <div class="overlay">
                        <p>Invitation Design</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="img/gallery8.jpg" alt="Catering Services">
                    <div class="overlay">
                        <p>Catering Services</p>
                    </div>
                </div>
            </div>
        </section>
<?php
require_once "config.php";

// Fetch latest reviews (Limit to 5 for a carousel or grid display)
$sql = "SELECT users.name, reviews.rating, reviews.review_text 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id 
        ORDER BY reviews.created_at DESC LIMIT 5";

$result = $conn->query($sql);
?>

<section class="reviews-section">
    <h2>What Our Users Say</h2>
	<p>Read real experiences from couples who planned their weddings with KalyanamKart. Honest feedback & ratings.</p>
    <?php
    require_once "config.php";
    $sql = "SELECT users.name, reviews.rating, reviews.review_text FROM reviews JOIN users ON reviews.user_id = users.id ORDER BY reviews.created_at DESC";
    $result = $conn->query($sql);
    ?>
    <div class="reviews-slider">
        <?php while ($review = $result->fetch_assoc()): ?>
            <div class="review-box">
                <h4><?php echo htmlspecialchars($review['name']); ?></h4>
                <p>⭐ <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                <p><?php echo htmlspecialchars($review['review_text']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    <button class="write-review-btn" onclick="window.location.href='add_review.php'">Write a Review</button>
</section>

<?php include"footer.php"?>