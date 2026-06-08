<?php
require_once __DIR__ . '/helpers.php';
header('Content-Type: application/json');
$email = filter_var($_GET['email'] ?? '', FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo json_encode(['valid' => false, 'message' => 'Email tidak valid.']);
    exit;
}
$db = db_connect();
$stmt = $db->prepare('SELECT COUNT(*) AS total FROM participants WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();
$db->close();
if ($result['total'] > 0) {
    echo json_encode(['valid' => false, 'message' => 'Email sudah terdaftar.']);
} else {
    echo json_encode(['valid' => true, 'message' => 'Email tersedia.']);
}
