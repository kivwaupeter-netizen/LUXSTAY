<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'hotel_booking';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to users

// Set content type
header('Content-Type: application/json');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get and sanitize input
    $name = trim($conn->real_escape_string($_POST['name'] ?? ''));
    $email = trim($conn->real_escape_string($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo json_encode(['success' => false, 'message' => 'missing_fields']);
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'invalid_email']);
        exit;
    }
    
    // Validate password length
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'password_short']);
        exit;
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'password_mismatch']);
        exit;
    }
    
    try {
        // Check if email already exists
        $checkQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkQuery->bind_param("s", $email);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();
        
        if ($checkResult->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'email_exists']);
            exit;
        }
        
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $query = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $name, $email, $hash);
        
        if ($query->execute()) {
            // Get the new user ID
            $user_id = $conn->insert_id;
            
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            
            echo json_encode(['success' => true, 'message' => 'Registration successful!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'database_error']);
        }
        
    } catch (Exception $e) {
        // Log the error
        error_log("Signup error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'error']);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'invalid_request']);
}

$conn->close();
?>