<?php
require_once 'config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Get user bookings
$stmt = $pdo->prepare("SELECT b.*, r.name as room_name, r.price as room_price FROM bookings b JOIN rooms r ON b.room_id = r.id WHERE b.user_id = ? ORDER BY b.booking_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - LuxStay</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">
                    <i class="fas fa-hotel"></i>
                    <span>LuxStay</span>
                </a>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                </ul>
                <div class="auth-buttons">
                    <div class="user-info">
                        <div class="user-avatar"><?php echo substr($_SESSION['user_name'], 0, 1); ?></div>
                        <span><?php echo $_SESSION['user_name']; ?></span>
                        <a href="logout.php" class="btn btn-login">Logout</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="dashboard">
            <h1>My Bookings</h1>
            
            <?php if(count($bookings) > 0): ?>
                <div class="bookings-list">
                    <?php foreach($bookings as $booking): ?>
                        <div class="booking-card">
                            <div class="booking-header">
                                <h3><?php echo $booking['room_name']; ?></h3>
                                <span class="booking-status <?php echo $booking['status']; ?>">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </div>
                            <div class="booking-details">
                                <div class="detail">
                                    <strong>Check-in:</strong> <?php echo date('M j, Y', strtotime($booking['check_in'])); ?>
                                </div>
                                <div class="detail">
                                    <strong>Check-out:</strong> <?php echo date('M j, Y', strtotime($booking['check_out'])); ?>
                                </div>
                                <div class="detail">
                                    <strong>Guests:</strong> <?php echo $booking['guests']; ?>
                                </div>
                                <div class="detail">
                                    <strong>Total Price:</strong> $<?php echo $booking['total_price']; ?>
                                </div>
                                <div class="detail">
                                    <strong>Booking Date:</strong> <?php echo date('M j, Y g:i A', strtotime($booking['booking_date'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-bookings">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No Bookings Yet</h3>
                    <p>You haven't made any bookings yet. Start by exploring our rooms!</p>
                    <a href="index.php" class="btn btn-primary">Browse Rooms</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>