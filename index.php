<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocean Pearls</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">  
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script defer src="script/script.js"></script>
   </head>
<body>
<div class="loader-wrapper">
        <div class="loader"></div>
    </div>
<?php
session_start(); 
include 'header.php';
// Start the session
?>  
    <section class="hero" style="background: url('assets/hero-background.jpg') center/cover no-repeat;">
    <div class="hero-content">
        <h1>Welcome to Ocean Pearls</h1>
        <p>Find your perfect stay by the sea.</p>
        <button class="book-now" onclick="location.href='book_room.php'">Book Now</button>
    </div>
    </section>


    
<section class="featured-amenities">
    <h2>Featured Amenities</h2>
    <p>Experience the best services and comfort.</p>
    <div class="amenities-list">
        <div class="amenity">
            <i class="fas fa-wifi"></i>
            <span>Free Wi-Fi</span>
        </div>
        <div class="amenity">
            <i class="fas fa-swimming-pool"></i>
            <span>Swimming Pool</span>
        </div>
        <div class="amenity">
            <i class="fas fa-spa"></i>
            <span>Spa & Wellness</span>
        </div>
        <div class="amenity">
            <i class="fas fa-utensils"></i>
            <span>Restaurant</span>
        </div>
        <div class="amenity">
            <i class="fas fa-car"></i>
            <span>Free Parking</span>
        </div>
    </div>
</section>

<!-- Rooms Section -->
<section class="rooms">
        <h2>Our Rooms</h2>
        <p>Comfortable and luxurious stays at our prime locations.</p>
        <div class="rooms-container">
            <div class="room">
                <div class="slideshow-container">
                    <img class="slide koteshwara-slide active-slide" src="assets/koteshwara-room1.jpg" alt="Koteshwara Room">
                    <img class="slide koteshwara-slide" src="assets/koteshwara-room2.jpg" alt="Koteshwara Room">
                    <img class="slide koteshwara-slide" src="assets/koteshwara-room3.jpg" alt="Koteshwara Room">
                </div>
            <h3>Koteshwara</h3>
            <p>Elegant rooms with stunning sea views.</p>
            <button onclick="location.href='koteshwara_rooms.php'">Book Now</button>
        </div>

        <div class="room">
                <div class="slideshow-container">
                    <img class="slide maravanthe-slide active-slide" src="assets/maravanthe-room1.jpg" alt="Maravanthe Room">
                    <img class="slide maravanthe-slide" src="assets/maravanthe-room2.jpg" alt="Maravanthe Room">
                    <img class="slide maravanthe-slide" src="assets/maravanthe-room3.jpg" alt="Maravanthe Room">
                </div>
            <h3>Maravanthe</h3>
            <p>Relax in a beachfront paradise.</p>
            <button onclick="location.href='maravanthe_rooms.php'">Book Now</button>
        </div>

        <div class="room">
                <div class="slideshow-container">
                    <img class="slide uppinakudru-slide active-slide" src="assets/uppinakudru-room1.jpg" alt="Uppinakudru Room">
                    <img class="slide uppinakudru-slide" src="assets/uppinakudru-room2.jpg" alt="Uppinakudru Room">
                    <img class="slide uppinakudru-slide" src="assets/uppinakudru-room3.jpg" alt="Uppinakudru Room">
                </div>
            <h3>Uppinakudru</h3>
            <p>A perfect getaway surrounded by nature.</p>
            <button onclick="location.href='uppinakudru_rooms.php'">Book Now</button>
        </div>
    </div>
</section>


    
<section class="gallery">
        <h2>Gallery</h2>
        <p>Explore our beautiful hotel and surroundings.</p>
        <div class="image-grid">
            <div class="image-loader">
                <div class="spinner"></div>
                <img src="assets/maravanthe-room1.jpg" alt="Maravanthe Room 1">
            </div>
            <div class="image-loader">
                <div class="spinner"></div>
                <img src="assets/uppinakudru-room4.jpg" alt="Uppinakudru Room 4">
            </div>
            <div class="image-loader">
                <div class="spinner"></div>
                <img src="assets/maravanthe-room4.jpg" alt="Maravanthe Room 4">
            </div>
            <div class="image-loader">
                <div class="spinner"></div>
                <img src="assets/dining.jpg" alt="Dining Area">
            </div>
            <div class="image-loader">
                <div class="spinner"></div>
                <img src="assets/maravanthe-room2.jpg" alt="Maravanthe Room 2">
            </div>
            <div class="image-loader">
                <div class="spinner"></div>
                <img src="assets/koteshwara-room1.jpg" alt="Koteshwara Room 1">
            </div>
        </div>
    </section>


    
<section class="testimonials">
    <h2>What Our Guests Say</h2>
    <div class="testimonial-wrapper">
        <div class="testimonial-container">
            <div class="testimonial">
                <p>"A wonderful stay with breathtaking views!"</p>
                <span>- Emily R.</span>
            </div>
            <div class="testimonial">
                <p>"The best vacation spot we've ever visited!"</p>
                <span>- John & Sarah</span>
            </div>
            <div class="testimonial">
                <p>"Excellent hospitality and great food!"</p>
                <span>- David P.</span>
            </div>
            <div class="testimonial">
                <p>"Absolutely loved the beachfront experience!"</p>
                <span>- Priya K.</span>
            </div>
            <div class="testimonial">
                <p>"Absolutely loved the beachfront experience!"</p>
                <span>- Priya K.</span>
            </div>
            <div class="testimonial">
                <p>"Absolutely loved the beachfront experience!"</p>
                <span>- Priya K.</span>
            </div>
        </div>
    </div>
</section>
<footer>
    <div class="footer-content">
        <!-- Footer Logo -->
        <div class="footer-logo">
            <h2>Ocean Pearls</h2>
            <p><strong>Experience comfort & luxury by the sea.</strong><br> With locations in Uppinakudru, Koteshwara, and Maravanthe, enjoy seamless bookings, elegant stays, and top-tier hospitality.</p>
        </div>

        <!-- Social Media Links -->
        <div class="footer-social">
            <h2>Follow Us</h2>
            <ul>
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="footer-links">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="history.php">History</a></li>
                <li><a href="terms.php">Terms</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-contact">
        <p>Email: support@oceanpearls.com | Phone: +91 98765 4xxxx</p>
    </div>

    <p class="footer-bottom">&copy; 2025 Ocean Pearls. All rights reserved.</p>
</footer>

</body>
</html>
