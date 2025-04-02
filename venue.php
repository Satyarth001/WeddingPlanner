<?php
include_once("header.php");
include 'config.php'; // Database connection
?>

<head>
    <title>Venues | KalyanamKart</title>
    <link rel="stylesheet" href="assets/css/venue.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <!-- Hero Section -->
    <header class="hero">
        <h1>Find Your Dream Wedding Venue</h1>
        <p>Discover the perfect place for your big day.</p>
        <input type="text" id="search" placeholder="Search by location, type..." onkeyup="filterVenues()">

        <!-- Filters -->
        <select id="type" onchange="filterVenues()">
            <option value="">All Types</option>
            <option value="Banquet Hall">Banquet Hall</option>
            <option value="Resort">Resort</option>
            <option value="Garden">Garden</option>
        </select>

        <select id="capacity" onchange="filterVenues()">
            <option value="">All Capacities</option>
            <option value="100">Up to 100</option>
            <option value="300">101 - 300</option>
            <option value="500">301 - 500</option>
            <option value="1000">501+</option>
        </select>
    </header>

    <!-- Venue Listings -->
    <section class="venue-list">
        <?php
        $query = "SELECT * FROM venues ORDER BY rating DESC";
        $result = mysqli_query($conn, $query);

        while ($venue = mysqli_fetch_assoc($result)) {
            $venueName = htmlspecialchars($venue['name']);
            $venueLocation = htmlspecialchars($venue['location']);
            $venueType = htmlspecialchars($venue['type']);
            $venueCapacity = htmlspecialchars($venue['capacity']);
            $venuePrice = htmlspecialchars($venue['price_per_person']);
            $venueRating = htmlspecialchars($venue['rating']);
            $venueReviews = htmlspecialchars($venue['reviews']);
            $venueImage = htmlspecialchars($venue['image']);

            echo '<div class="venue" data-type="' . $venueType . '" data-capacity="' . $venueCapacity . '">';
            echo '<img src="img/' . $venueImage . '" onerror="this.src=\'assets/images/default-venue.jpg\';" alt="' . $venueName . '">';
            echo '<h2>' . $venueName . '</h2>';
            echo '<p><i class="fa fa-map-marker"></i> ' . $venueLocation . '</p>';
            echo '<p><i class="fa fa-users"></i> Capacity: ' . $venueCapacity . '</p>';
            echo '<p><i class="fa fa-cutlery"></i> ₹' . $venuePrice . ' per person</p>';
            echo '<p><span class="rating"><i class="fa fa-star"></i> ' . $venueRating . ' (' . $venueReviews . ' reviews)</span></p>';
            echo '<a href="message_form.php?venue=' . urlencode($venueName) . '" class="send-message-btn">Send Message</a>';
            echo '</div>';
        }
        ?>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            filterVenues();
        });

        function filterVenues() {
            let search = document.getElementById("search").value.toLowerCase();
            let selectedCapacity = document.getElementById("capacity").value;
            let selectedType = document.getElementById("type").value.toLowerCase();

            document.querySelectorAll(".venue").forEach(venue => {
                let name = venue.querySelector("h2").innerText.toLowerCase();
                let location = venue.querySelector("p").innerText.toLowerCase();
                let type = venue.getAttribute("data-type").toLowerCase();
                let capacity = parseInt(venue.getAttribute("data-capacity"));

                let matchesSearch = name.includes(search) || location.includes(search);
                let matchesType = !selectedType || type.includes(selectedType);
                let matchesCapacity = !selectedCapacity ||
                    (selectedCapacity == "100" && capacity <= 100) ||
                    (selectedCapacity == "300" && capacity > 100 && capacity <= 300) ||
                    (selectedCapacity == "500" && capacity > 300 && capacity <= 500) ||
                    (selectedCapacity == "1000" && capacity > 500);

                venue.style.display = (matchesSearch && matchesType && matchesCapacity) ? "block" : "none";
            });
        }
    </script>

    <script src="assets/js/script.js"></script>

</body>
</html>
