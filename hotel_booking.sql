-- Create database
CREATE DATABASE IF NOT EXISTS hotel_booking;
USE hotel_booking;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Rooms table
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    capacity INT NOT NULL,
    image VARCHAR(255),
    amenities TEXT,
    status ENUM('available', 'booked') DEFAULT 'available'
);

-- Verify your bookings table structure
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'confirmed',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    card_name VARCHAR(100) NOT NULL,
    card_number VARCHAR(20) NOT NULL,
    expiry_date VARCHAR(10) NOT NULL,
    cvv VARCHAR(4) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
);

-- Insert sample rooms
INSERT INTO rooms (name, description, price, capacity, amenities) VALUES
('Deluxe Room', 'Spacious room with king-size bed and city view', 199.00, 2, 'WiFi, TV, AC, Mini Bar'),
('Executive Suite', 'Luxury suite with separate living area', 299.00, 4, 'WiFi, TV, AC, Mini Bar, Jacuzzi'),
('Presidential Suite', 'Ultimate luxury with premium amenities', 599.00, 6, 'WiFi, TV, AC, Private Pool, Butler Service');