-- =========================================================
-- EASTCSO STUDENT PORTAL — DATABASE SCHEMA
-- Ingiza faili hii kwenye phpMyAdmin (au mysql CLI) kabla
-- ya kutumia mfumo wa login na matangazo (CRUD).
-- =========================================================

CREATE DATABASE IF NOT EXISTS eastcso_portal CHARACTER SET utf8mb4;
USE eastcso_portal;

-- Watumiaji wa admin (Login System)
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'Administrator',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Akaunti chaguo-msingi: username = admin , password = eastcso2026
-- (password imehifadhiwa kwa password_hash() ya PHP)
INSERT INTO admins (full_name, username, password, role)
VALUES ('Msimamizi Mkuu', 'admin', '$2y$10$92xKzL3qf1c2Z8mYV1qQ9.YV3rN6N3D4G0xkqnRnZyAe5T0Hh1Hd6', 'Administrator')
ON DUPLICATE KEY UPDATE username = username;
-- Hash hii ni mfano; tumia generate_password.php kuunda hash sahihi (maelezo chini ya faili hii).

-- Matangazo (Announcements) - CRUD
CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Viongozi (Leadership) - CRUD, inaonekana kwenye ukurasa wa "Viongozi"
CREATE TABLE IF NOT EXISTS leaders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    ministry VARCHAR(150) DEFAULT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    photo VARCHAR(255) DEFAULT 'images/avatar-placeholder.png',
    display_order INT DEFAULT 0
);

-- Mawasiliano kutoka kwa wageni (Contact Form)
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data ya mfano ya viongozi (kutoka picha uliyotuma — badilisha kama unataka)
INSERT INTO leaders (full_name, position, ministry, phone, display_order) VALUES
('Mario Macha', 'Rais (President)', NULL, '+255 693 827 599', 1),
('Tumaini Hosea', 'Waziri Mkuu (Prime Minister)', "Ofisi ya Rais", '+255 689 624 944', 2),
('Nesta Msola', 'Makamu wa Rais (Vice President)', 'Katiba, Sheria na Mambo ya Kisheria', '+255 780 480 730', 3),
('Steven Ladislaus', 'Katibu Mkuu (Chief Secretary)', 'Fedha na Mipango', '+255 715 296 092', 4);
