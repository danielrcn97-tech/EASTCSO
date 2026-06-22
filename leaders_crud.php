<?php
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Huna ruhusa. Tafadhali ingia kwanza.']);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {

    case 'create':
        $name     = trim($_POST['full_name'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $ministry = trim($_POST['ministry'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $order    = (int)($_POST['display_order'] ?? 0);

        $stmt = $conn->prepare("INSERT INTO leaders (full_name, position, ministry, phone, display_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $name, $position, $ministry, $phone, $order);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Kiongozi ameongezwa.']);
        break;

    case 'update':
        $id       = (int)($_POST['id'] ?? 0);
        $name     = trim($_POST['full_name'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $ministry = trim($_POST['ministry'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');

        $stmt = $conn->prepare("UPDATE leaders SET full_name=?, position=?, ministry=?, phone=? WHERE id=?");
        $stmt->bind_param('ssssi', $name, $position, $ministry, $phone, $id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Taarifa za kiongozi zimesasishwa.']);
        break;

    case 'delete':
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM leaders WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Kiongozi amefutwa.']);
        break;

    case 'list':
        $result = $conn->query("SELECT * FROM leaders ORDER BY display_order ASC, id ASC");
        $rows = [];
        while ($r = $result->fetch_assoc()) $rows[] = $r;
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Hatua isiyojulikana.']);
}
