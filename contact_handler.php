<?php
header('Content-Type: application/json');
require_once 'config.php';

$name    = trim($_POST['full_name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    echo json_encode(['success' => false, 'message' => 'Tafadhali jaza sehemu zote.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Barua pepe si sahihi.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO contact_messages (full_name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Asante! Ujumbe wako umetumwa.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Hitilafu imetokea. Jaribu tena.']);
}
