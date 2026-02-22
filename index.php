<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay - Hotel & Resort Booking</title>

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
    // Show user info if logged in
    if (isset($_SESSION['user_id'])) {
        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("userInfo").style.display = "flex";
                document.getElementById("loginBtn").style.display = "none";
                document.getElementById("signupBtn").style.display = "none";
                document.getElementById("userName").textContent = "' . $_SESSION['user_name'] . '";
                document.getElementById("userAvatar").textContent = "' . substr($_SESSION['user_name'], 0, 1) . '";
            });
        </script>';
    }
    ?>

    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo" data-page="home">
                    <i class="fas fa-hotel"></i>
                    <span>LuxStay</span>
                </a>
                <ul class="nav-links">
                    <li><a href="#" data-page="home" class="active">Home</a></li>
                    <li><a href="#" data-page="features">Features</a></li>
                    <li><a href="#" data-page="rooms">Rooms</a></li>
                    <li><a href="#" data-page="booking" id="bookingNav">Booking</a></li>
                </ul>
                <div class="auth-buttons">
                    <div class="user-info" id="userInfo">
                        <div class="user-avatar" id="userAvatar">JD</div>
                        <span id="userName">John Doe</span>
                        <a href="logout.php" class="btn btn-login">Logout</a>
                    </div>
                    <button class="btn btn-login" id="loginBtn">Login</button>
                    <button class="btn btn-signup" id="signupBtn">Sign Up</button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Home Page -->
    <section id="home" class="page-section active">
        <!-- Hero Section -->
        <div class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Experience Luxury & Comfort</h1>
                    <p>Discover our premium hotels and resorts with world-class amenities and exceptional service</p>
                    <button class="btn btn-booking" id="heroBookingBtn">Book Your Stay Now</button>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section class="features" id="features">
            <div class="container">
                <div class="section-title">
                    <h2>Why Choose LuxStay?</h2>
                    <p>We offer the best experience for both guests and hotel managers</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>Easy Booking</h3>
                        <p>Simple and intuitive booking process with instant confirmation</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h3>Premium Service</h3>
                        <p>24/7 customer support and personalized service for all guests</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Secure Payment</h3>
                        <p>Your payments are protected with our secure payment system</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rooms Preview -->
        <section class="rooms-preview" id="rooms">
            <div class="container">
                <div class="section-title">
                    <h2>Our Room Selection</h2>
                    <p>Explore our variety of luxurious accommodations</p>
                </div>
                <div class="rooms-grid">
                    <div class="room-card">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Deluxe Room" class="room-image">
                        <div class="room-info">
                            <h3 class="room-title">Deluxe Room</h3>
                            <div class="room-features">
                                <span><i class="fas fa-user-friends"></i> 2 Guests</span>
                                <span><i class="fas fa-bed"></i> 1 King Bed</span>
                                <span><i class="fas fa-ruler-combined"></i> 350 sq.ft.</span>
                            </div>
                            <p class="room-price">$199 <span>/ night</span></p>
                            <button class="btn btn-primary select-room" data-room="deluxe">Select Room</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <img src="https://images.unsplash.com/photo-1586105251261-72a756497a11?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Executive Suite" class="room-image">
                        <div class="room-info">
                            <h3 class="room-title">Executive Suite</h3>
                            <div class="room-features">
                                <span><i class="fas fa-user-friends"></i> 4 Guests</span>
                                <span><i class="fas fa-bed"></i> 2 Queen Beds</span>
                                <span><i class="fas fa-ruler-combined"></i> 550 sq.ft.</span>
                            </div>
                            <p class="room-price">$299 <span>/ night</span></p>
                            <button class="btn btn-primary select-room" data-room="executive">Select Room</button>
                        </div>
                    </div>

                    <div class="room-card">
                        <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Presidential Suite" class="room-image">
                        <div class="room-info">
                            <h3 class="room-title">Presidential Suite</h3>
                            <div class="room-features">
                                <span><i class="fas fa-user-friends"></i> 6 Guests</span>
                                <span><i class="fas fa-bed"></i> 3 King Beds</span>
                                <span><i class="fas fa-ruler-combined"></i> 1200 sq.ft.</span>
                            </div>
                            <p class="room-price">$599 <span>/ night</span></p>
                            <button class="btn btn-primary select-room" data-room="presidential">Select Room</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Booking Section -->
        <section class="booking-section">
            <div class="container">
                <div class="booking-container-simple">
                    <h2>Ready to Book Your Stay?</h2>
                    <p>Sign in to access our exclusive deals and make your reservation</p>
                    <button class="btn btn-booking" id="bookingSectionBtn">Book Now</button>
                </div>
            </div>
        </section>
    </section>

    <!-- Booking Page -->
    <section id="booking" class="page-section">
        <div class="container">
            <div class="booking-page">
                <div class="section-title">
                    <h2>Complete Your Booking</h2>
                    <p>Please fill in your details to confirm your reservation</p>
                </div>
                
                <div class="success-message" id="successMessage">
                    <i class="fas fa-check-circle"></i>
                    <h3>Booking Confirmed!</h3>
                    <p>Your reservation has been successfully submitted. A confirmation email has been sent to your inbox.</p>
                    <button class="btn btn-primary mt-20" id="newBookingBtn">Make Another Booking</button>
                </div>
                
                <div class="booking-container" id="bookingFormContainer">
                    <div class="booking-form-container">
                        <form id="bookingForm" action="process_booking.php" method="POST">
                            <div class="form-section">
                                <h3><i class="fas fa-calendar-alt"></i> Booking Details</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="checkIn">Check-in Date</label>
                                        <input type="date" id="checkIn" name="checkIn" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="checkOut">Check-out Date</label>
                                        <input type="date" id="checkOut" name="checkOut" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="guests">Number of Guests</label>
                                        <select id="guests" name="guests" class="form-control" required>
                                            <option value="1">1 Guest</option>
                                            <option value="2" selected>2 Guests</option>
                                            <option value="3">3 Guests</option>
                                            <option value="4">4 Guests</option>
                                            <option value="5">5+ Guests</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="roomType">Room Type</label>
                                        <select id="roomType" name="roomType" class="form-control" required>
                                            <option value="1">Deluxe Room</option>
                                            <option value="2">Executive Suite</option>
                                            <option value="3">Presidential Suite</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3><i class="fas fa-user"></i> Personal Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="firstName">First Name</label>
                                        <input type="text" id="firstName" name="firstName" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" id="lastName" name="lastName" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3><i class="fas fa-credit-card"></i> Payment Information</h3>
                                <div class="form-group">
                                    <label for="cardName">Name on Card</label>
                                    <input type="text" id="cardName" name="cardName" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="cardNumber">Card Number</label>
                                    <input type="text" id="cardNumber" name="cardNumber" class="form-control" placeholder="1234 5678 9012 3456" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="expiryDate">Expiry Date</label>
                                        <input type="text" id="expiryDate" name="expiryDate" class="form-control" placeholder="MM/YY" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123" required>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 18px;">Complete Booking</button>
                        </form>
                    </div>
                    
                    <div class="booking-summary">
                        <h3>Booking Summary</h3>
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Room" class="room-image-large" id="summaryImage">
                        <h4 id="summaryRoom">Deluxe Room</h4>
                        <div class="summary-item">
                            <span>Check-in</span>
                            <span id="summaryCheckIn">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Check-out</span>
                            <span id="summaryCheckOut">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Guests</span>
                            <span id="summaryGuests">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Nights</span>
                            <span id="summaryNights">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Room rate</span>
                            <span id="summaryRate">$0</span>
                        </div>
                        <div class="summary-item">
                            <span>Taxes & fees</span>
                            <span id="summaryTaxes">$0</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span id="summaryTotal">$0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>LuxStay</h3>
                    <p>Premium hotel and resort management system providing exceptional experiences for guests and efficient tools for hotel managers.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#" data-page="home">Home</a></li>
                        <li><a href="#" data-page="features">Features</a></li>
                        <li><a href="#" data-page="rooms">Rooms</a></li>
                        <li><a href="#" data-page="booking">Booking</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Luxury Avenue, Resort City</li>
                        <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-envelope"></i> info@luxstay.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date("Y"); ?> LuxStay. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Authentication Modal -->
    <div class="modal" id="authModal">
        <div class="modal-content">
            <span class="close-modal" id="closeModal">&times;</span>
            <div class="modal-tabs">
                <div class="modal-tab active" data-tab="login">Login</div>
                <div class="modal-tab" data-tab="signup">Sign Up</div>
            </div>
            
            <form class="modal-form active" id="loginForm">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input type="email" id="loginEmail" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                        <label for="rememberMe">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                <button type="submit" class="modal-submit">Login</button>
            </form>
            
            <form class="modal-form" id="signupForm">
                <div class="form-group">
                    <label for="signupName">Full Name</label>
                    <input type="text" id="signupName" name="name" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="signupEmail">Email</label>
                    <input type="email" id="signupEmail" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="signupPassword">Password</label>
                    <input type="password" id="signupPassword" name="password" class="form-control" placeholder="Create a password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirm_password" class="form-control" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="modal-submit">Create Account</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="auth.js"></script>
    <script src="script.js"></script>

</body>
</html>