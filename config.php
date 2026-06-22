<?php
/* =========================================================
   DATABASE CONFIGURATION
   Badilisha DB_USER / DB_PASS / DB_NAME kulingana na server yako
   (mfano: XAMPP/WAMP local, au hosting ya mtandao)
   ========================================================= */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'eastcso_portal');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

$conn->set_charset('utf8mb4');

session_start();
