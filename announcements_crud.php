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
        $title = trim($_POST['title'] ?? '');
        $body  = trim($_POST['body'] ?? '');
        if ($title === '' || $body === '') {
            echo json_encode(['success' => false, 'message' => 'Jaza kichwa na maudhui.']);
            exit;
        }
        $stmt = $conn->prepare("INSERT INTO announcements (title, body) VALUES (?, ?)");
        $stmt->bind_param('ss', $title, $body);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Tangazo limeongezwa.', 'id' => $stmt->insert_id]);
        break;

    case 'update':
        $id    = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $body  = trim($_POST['body'] ?? '');
        $stmt = $conn->prepare("UPDATE announcements SET title = ?, body = ? WHERE id = ?");
        $stmt->bind_param('ssi', $title, $body, $id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Tangazo limesasishwa.']);
        break;

    case 'delete':
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Tangazo limefutwa.']);
        break;

    case 'list':
        $result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
        $rows = [];
        while ($r = $result->fetch_assoc()) $rows[] = $r;
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Hatua isiyojulikana.']);
}
