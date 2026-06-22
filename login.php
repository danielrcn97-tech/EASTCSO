<?php
header('Content-Type: application/json');
require_once 'config.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Tafadhali jaza username na password.']);
    exit;
}

$stmt = $conn->prepare("SELECT id, full_name, username, password, role FROM admins WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Username haipo kwenye mfumo.']);
    exit;
}

$admin = $result->fetch_assoc();

if (!password_verify($password, $admin['password'])) {
    echo json_encode(['success' => false, 'message' => 'Password si sahihi.']);
    exit;
}

$_SESSION['admin_id']   = $admin['id'];
$_SESSION['admin_name'] = $admin['full_name'];
$_SESSION['admin_role'] = $admin['role'];

echo json_encode(['success' => true, 'message' => 'Umeingia kwa mafanikio. Inakupeleka...']);
