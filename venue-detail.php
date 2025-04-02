<html>
<head>
    <title>Venues-detail | KalyanamKart</title>
    <!--<link rel="stylesheet" href="venue-detail.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabLinks = document.querySelectorAll(".tab-link");
        
            tabLinks.forEach(tab => {
                tab.addEventListener("click", function () {
                    const targetId = this.getAttribute("data-target");
                    const targetSection = document.getElementById(targetId);
        
                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - 80, // Adjust for header height if needed
                            behavior: "smooth"
                        });
                    }
                });
            });
        });

         function scrollToSection(id) {
           document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
         }

         function toggleShortlist(icon) {
            icon.classList.toggle('fa-heart-o');
            icon.classList.toggle('fa-heart');
            icon.classList.toggle('shortlisted');
        }


        </script>
        
    
    <style>
    .venue-details {
    max-width: 1300px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

   .venue-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    }

    .venue-image img {
    width: 700px;
    border-radius: 10px;
    }

    .venue-info {
    text-align: left;
    margin-top: 20px;
    max-width: 800px;
    margin: 12px ;
    padding: 8px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  
    }

    .venue-info h2 {
    font-size: 22px;
    display: flex;
    align-items: center;
    gap: 8px; /* Adjusts spacing */
    }

    .verified {
    color: #007bff;
    font-size: 16px;
    display: flex;
    align-items: center;
    }

    .venue-form {
    background: #fff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-top: 15px;
    }

    .venue-form input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 6px;
    }

    .venue-form .check-btn {
    width: 100%;
    background: #8c001a;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 30px;
    }
    
        .gallery-section {
            margin-top: 20px;
        }
        .gallery-tabs {
            display: flex;
            gap: 10px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .gallery-tabs button {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            padding: 10px;
        }
        .gallery-tabs .active {
            color: #8c001a;
            border-bottom: 3px solid #8c001a;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .gallery-grid img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .view-more {
            display: block;
            margin: 20px auto;
            background: #8c001a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .view-more a{
            text-decoration: none;
            color:white;
            font-size: 16px;
        }

        .about-section {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .about-section h2{
           color:#8c001a;
        }
        
        .about-section h3 {
            color: #333;
        }
        .about-section p ul{
            font-size: 14px;
            color: #666;
        }
        .venue-details-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .shortlist-btn {
            cursor: pointer;
            font-size: 20px;
            color: #999;
            margin-left: 10px;
        }
        .shortlisted {
            color: #e91e63;
        }
        .venue-details-item {
            display: flex;
            flex-direction: column;
        }
        .venue-details-item h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .venue-details-item p {
            font-size: 14px;
            color: #666;
        }
        .review {
            background: #f9f9f9;
            border-bottom: 1px solid #ddd;
            padding: 12px;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .review-section h2{
            color:#8c001a;
        }
        .review h4 {
            font-size: 16px;
            font-weight: bold;
        }
        .review p {
            font-size: 14px;
            color: #666;
        }
        
        /* Venue Sidebar */
    .venue-sidebar {
    width: 400px;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 20px;
    }

    .venue-sidebar h3 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
    }

    .venue-sidebar ul {
    list-style: none;
    padding: 0;
    }

    .venue-sidebar ul li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
    color: #666;
    }

    .venue-sidebar ul li:last-child {
    border-bottom: none;
    }

    .pricing {
    background: #fff3f3;
    padding: 15px;
    border-radius: 10px;
    text-align: left;
    font-size: 18px;
    font-weight: bold;
}

.contact-options {
    margin-top: 15px;
}

.contact-btn {
    width: 100%;
    padding: 5px;
    margin-top: 10px;
    background: #8c001a;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.contact-btn:nth-child(2) {
    background: #387244;
}

    /* Venue Tabs */
    .venue-tabs {
    display: flex;
    border-bottom: 2px solid #ddd;
    margin-bottom: 20px;
    }

    .venue-tabs button {
    background: none;
    border: none;
    font-size: 16px;
    padding: 10px 15px;
    cursor: pointer;
    color: #666;
    }

    .venue-tabs button.active {
    color: #8c001a;
    border-bottom: 3px solid #8c001a;
    font-weight: bold;
    }

    </style>
</head>
<body>
<!-- Venue Details Page -->
<section class="venue-details">
    <div class="venue-header">
        <div class="venue-image">
            <img src="img/venue-detail1.jpg" alt="Oruba - A Luxe Banquet">
            <div class="venue-info">  <!-- Spanning full width -->
                <div class="venue-text">
                    <h2>Oruba - A luxe Banquet <span class="verified"><i class="fa fa-check-circle"></i></span></h2>
                    <span class="shortlist-btn fa fa-heart-o" onclick="toggleShortlist(this)"></span>
                    <p class="location"><i class="fa fa-map-marker"></i> Begumpet, Hyderabad</p>
                </div>
                <p class="reviews"><i class="fa fa-star"></i> 5.0 (12 reviews)</p>
            </div>
        </div>
        <div class="venue-sidebar">
            <div class="pricing">
                <p>Starting Price</p>
                <p><i class="fa fa-cutlery"></i> From ₹1200 per plate</p>
            </div>
            <div class="contact-options">
                <button class="contact-btn">Send Message</button>
                <button class="contact-btn">Add Vendor</button>
            </div>
            <div class="venue-form">
                <h3>Hi Oruba Garden,</h3>
                <form>
                    <div class="form-row">
                        <input type="text" placeholder="Your Name">
                        <input type="tel" placeholder="+91 ">
                    </div>
                    <div class="form-row">
                        <input type="email" placeholder="Email address">
                        <input type="date" value="2025-09-25">
                    </div>
                    <div class="form-row">
                        <input type="text" placeholder="No. of Guests (min. 50)">
                        <input type="text" placeholder="No of rooms">
                    </div>
                    
                    <div class="function-group">
                        <label>Function Type</label>
                        <label><input type="radio" name="function_type" value="pre-wedding"> Pre-Wedding</label>
                        <label><input type="radio" name="function_type" value="wedding"> Wedding</label>
                    </div>
                    
                    <div class="function-group">
                        <label>Function Time</label>
                        <label><input type="radio" name="function_time" value="evening"> Evening</label>
                        <label><input type="radio" name="function_time" value="day"> Day</label>
                    </div>
                    

                    <button class="check-btn">Check Availability & Prices</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="venue-content">
        <div class="venue-main">
            <div class="venue-tabs">
                <button class="tab-link" data-target="gallery-section">Portfolio (14)</button>
                <button class="tab-link" data-target="about-section">About</button>
                <button class="tab-link" data-target="review-section">Reviews</button>
            </div>            
            <div class="venue-description">
                <p>Oruba - A Luxe Banquet offers a stunning location for weddings with banquet halls and outdoor venues.</p>
            </div>
            
            <!-- Photo Gallery Section -->
            <div id="gallery-section" class="gallery-section">                <div class="gallery-tabs">
                    <button class="active">Photos</button>
                    <button>Albums (1)</button>
                    <button>Videos (0)</button>
                </div>
                <div class="gallery-grid">
                    <img src="img/venue-detail1.jpg" alt="Gallery Image">
                    <img src="img/venue-detail2.jpg" alt="Gallery Image">
                    <img src="img/venue-detail3.jpg" alt="Gallery Image">
                    <img src="img/venue-detail4.jpg" alt="Gallery Image">
                    <img src="img/venue-detail5.jpg" alt="Gallery Image">
                    <img src="img/venue-detail6.jpg" alt="Gallery Image">
                    <img src="img/venue-detail7.jpg" alt="Gallery Image">
                    <img src="img/venue-detail8.jpg" alt="Gallery Image">
                </div>
                <button class="view-more"><a href="oruba-photo.html">View More</a></button>
            </div>

            <!-- About Section -->
            <div id="about-section" class="about-section">                <h2>About Oruba - A Luxe Banquet- Wedding Venues, Begumpet, Hyderabad</h2>
                <p>Oruba - a Luxe Banquet is a reputed and renowned wedding venue located in Begumpet, Hyderabad. It is a magnificent banquet hall, and lawn/ farmhouse that can host large gatherings. Both indoor and outdoor spacing is a available for the guest at the venue. The staff at the venue are also hardworking and dedicated to provide the best servces for all guests. They will make sure you have a memorable event and everything goes smoothly.</p>
                <h3>Space Availability</h3>
                <p>The venue offers indoor and outdoor spacing facilities that can accommodate large gatherings. 2 rooms are also available at the venue for the outstation guests and families to get ready.</p>
                  <ul>
                    <li>The banquet hall and lawn can hold 550 people in seating and 700 in floating.</li>
                    <li>the banquet hall 2 can accomodate 250 people in the seating and 400 in floating. Sufficient parking space is also available at the venue.</li>
                  </ul>
                <h3>Facilities Provided</h3>
                <p>The staff at the venue provides a wide range of facilities for all the guests to make their stay memorable.</p>
                <p>the facilities are:</p>
                  <ul>
                    <li>Decorators from panel only</li>
                    <li>In-house catering only</li>
                    <li>Inhouse DJ is available</li>
                    <li>Outside DJ is not permitted</li>
                    <li>Inhouse alcohol is available</li>
                    <li>Outside alcohol is not permitted</li>
                  </ul> 
                <h3>Catering and Cuisines</h3>
                <p>Oruba - A Luxe Banquet offers in-house catering services for their guests. The venue offers a wide range of delicacies for their guests to match their tastes and allows flexibility. Both vegetarian and non-vegetarian cuisines are available at the venue.</p>
                <h3>Location</h3>
                <p>Located in Begumpet, Hyderabad, easily accessible from all parts of the city.</p>
                <h3>Booking and Queries</h3>
                <p>For availability and pricing, reach out via the contact form or call us.</p>
            </div>
            <!-- Venue Details Section -->
        <div class="venue-details-section">
            <div class="venue-details-item">
                <h3>Space</h3>
                <p>Indoor, Outdoor</p>
            </div>
            <div class="venue-details-item">
                <h3>Room Count</h3>
                <p>2 Rooms</p>
            </div>
            <div class="venue-details-item">
                <h3>Catering Policy</h3>
                <p>In-house catering only</p>
            </div>
            <div class="venue-details-item">
                <h3>Features</h3>
                <p>Parking available, Outside Alcohol Allowed</p>
            </div>
            <div class="venue-details-item">
                <h3>Parking</h3>
                <p>Sufficient parking available</p>
            </div>
            <div class="venue-details-item">
                <h3>Decor Policy</h3>
                <p>Decorators from panel only</p>
            </div>
            <div class="venue-details-item">
                <h3>DJ Policy</h3>
                <p>In-house DJ available, Outside DJ not permitted</p>
            </div>
            <div class="venue-details-item">
                <h3>Outside Alcohol</h3>
                <p>In-house alcohol available, Outside alcohol permitted</p>
            </div>
        </div>
        
        <!-- Review Section -->
        <div id="review-section" class="review-section">            <h2>Customer Reviews</h2>
            <div class="review">
                <h4>Ashish <span class="fa fa-star checked"></span> 5.0</h4>
                <p>We had organised a roka ceremony of my cousin sister at the hotel there the service was excellent and food was amazing. We are thinking to organize wedding function in there new upcoming banquet. THANKS TO THE TEAM FOR MAKING OUR FUNCTION MEMEOABLE.</p>
            </div>
            <div class="review">
                <h4>Manav Pramsatya <span class="fa fa-star checked"></span> 4.5</h4>
                <p>I've booked Oruba banquet for my function<br>This is very well maintained plae. The arrangements for my function were done superbly. Superb decoration, very good outdoor sitting arangement, super tasty food, staff service and behaviour-very nice and friendly, very nice flower decorations, as well indoor sitting and food arrangements were also very nice.</p>
            </div>
            <div class="review">
                <h4>Jai Rajput <span class="fa fa-star checked"></span> 4.5</h4>
                <p>I've booked Oruba banquet for my function<br>Did my sister's ring ceremony at 'Oruba' last week and found it to be the bes place in this area. Decinding on the perfect weding venue can be a little bit tricky, what with so many options out there. But, if you want your function to be absolutely dreamy, then this is the place.<br> Their beautiful banquet area is perfect for hosting a large number of guests, who will most certainly be impressed with their world class services and gorgeous decorations.<br>They keep in mind your vision, your requirements , your budget and most important of all, your happiness, on this very auspicious and memorable day.</p>
            </div>
        </div>

        </div>
    </div>
</section>
</body>
</html>
