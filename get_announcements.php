<?php
header('Content-Type: application/json');
require_once 'config.php';

$result = $conn->query("SELECT id, title, body, created_at FROM announcements ORDER BY created_at DESC LIMIT 10");
$rows = [];
while ($row = $result->fetch_assoc()) {
    $row['title'] = htmlspecialchars($row['title']);
    $row['body']  = htmlspecialchars($row['body']);
    $rows[] = $row;
}
echo json_encode($rows);
