<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'hotel_booking';
$username = 'root';
$password = '';

// Create connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Set content type
header('Content-Type: application/json');

// Function to get room details
function getRoomDetails($room_id, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->execute([$room_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return null;
    }
}

// Function to calculate total price
function calculateTotalPrice($room_price, $check_in, $check_out) {
    try {
        $date1 = new DateTime($check_in);
        $date2 = new DateTime($check_out);
        $nights = $date2->diff($date1)->days;
        return $nights * $room_price;
    } catch(Exception $e) {
        return 0;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Please login to make a booking.']);
        exit;
    }

    // Validate required fields
    $required_fields = ['roomType', 'checkIn', 'checkOut', 'guests', 'firstName', 'lastName', 'email', 'phone', 'cardName', 'cardNumber', 'expiryDate', 'cvv'];
    
    foreach($required_fields as $field) {
        if(empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
            exit;
        }
    }

    // Get and sanitize form data
    $room_id = filter_var($_POST['roomType'], FILTER_SANITIZE_NUMBER_INT);
    $check_in = $_POST['checkIn'];
    $check_out = $_POST['checkOut'];
    $guests = filter_var($_POST['guests'], FILTER_SANITIZE_NUMBER_INT);
    $first_name = htmlspecialchars($_POST['firstName']);
    $last_name = htmlspecialchars($_POST['lastName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $card_name = htmlspecialchars($_POST['cardName']);
    $card_number = preg_replace('/[^0-9]/', '', $_POST['cardNumber']); // Remove non-numeric characters
    $expiry_date = $_POST['expiryDate'];
    $cvv = filter_var($_POST['cvv'], FILTER_SANITIZE_STRING);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
        exit;
    }
    
    // Validate dates
    if ($check_in >= $check_out) {
        echo json_encode(['success' => false, 'message' => 'Check-out date must be after check-in date.']);
        exit;
    }
    
    // Validate future dates
    $today = date('Y-m-d');
    if ($check_in < $today) {
        echo json_encode(['success' => false, 'message' => 'Check-in date cannot be in the past.']);
        exit;
    }
    
    // Get room details
    $room = getRoomDetails($room_id, $pdo);
    if (!$room) {
        echo json_encode(['success' => false, 'message' => 'Invalid room selected.']);
        exit;
    }
    
    // Check room capacity
    if ($guests > $room['capacity']) {
        echo json_encode(['success' => false, 'message' => 'Number of guests exceeds room capacity.']);
        exit;
    }
    
    // Check if room is available for the selected dates
    try {
        $availability_stmt = $pdo->prepare("
            SELECT id FROM bookings 
            WHERE room_id = ? 
            AND status = 'confirmed'
            AND ((check_in <= ? AND check_out >= ?) OR (check_in <= ? AND check_out >= ?))
        ");
        $availability_stmt->execute([$room_id, $check_out, $check_in, $check_in, $check_out]);
        
        if ($availability_stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Room is not available for the selected dates.']);
            exit;
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Availability check failed.']);
        exit;
    }
    
    // Calculate total price
    $total_price = calculateTotalPrice($room['price'], $check_in, $check_out);
    if ($total_price <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid date range.']);
        exit;
    }
    
    // Get user ID from session
    $user_id = $_SESSION['user_id'];
    
    try {
        // Create booking
        $stmt = $pdo->prepare("
            INSERT INTO bookings 
            (user_id, room_id, check_in, check_out, guests, total_price, 
             first_name, last_name, email, phone, card_name, card_number, 
             expiry_date, cvv, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'confirmed')
        ");
        
        $stmt->execute([
            $user_id, $room_id, $check_in, $check_out, $guests, $total_price,
            $first_name, $last_name, $email, $phone, $card_name, $card_number,
            $expiry_date, $cvv
        ]);
        
        $booking_id = $pdo->lastInsertId();
        
        echo json_encode([
            'success' => true, 
            'message' => 'Booking confirmed! Your booking ID is: ' . $booking_id,
            'booking_id' => $booking_id,
            'total_price' => $total_price
        ]);
        
    } catch(PDOException $e) {
        error_log("Booking error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Booking failed. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>