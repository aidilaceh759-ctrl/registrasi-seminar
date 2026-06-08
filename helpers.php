<?php
require_once __DIR__ . '/config.php';

function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function get_active_seminars() {
    $db = db_connect();
    $stmt = $db->prepare('SELECT * FROM seminars WHERE DATE(tanggal) >= CURDATE() ORDER BY tanggal ASC');
    $stmt->execute();
    $result = $stmt->get_result();
    $seminars = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $seminars;
}

function find_seminar($id) {
    $db = db_connect();
    $stmt = $db->prepare('SELECT * FROM seminars WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $seminar = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $seminar;
}

function get_registration_by_code($code) {
    $db = db_connect();
    $stmt = $db->prepare('SELECT r.*, p.nama_lengkap, p.email, p.whatsapp, p.instansi, p.nim_nip, p.jenis_kelamin, p.alamat, s.nama_seminar FROM registrations r INNER JOIN participants p ON r.participant_id = p.id INNER JOIN seminars s ON r.seminar_id = s.id WHERE r.registration_code = ?');
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $result = $stmt->get_result();
    $registration = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $registration;
}

function get_registration_by_email($email) {
    $db = db_connect();
    $stmt = $db->prepare('SELECT r.*, p.nama_lengkap, p.email, p.whatsapp, p.instansi, p.nim_nip, p.jenis_kelamin, p.alamat, s.nama_seminar FROM registrations r INNER JOIN participants p ON r.participant_id = p.id INNER JOIN seminars s ON r.seminar_id = s.id WHERE p.email = ? ORDER BY r.created_at DESC');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $registrations = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $registrations;
}

function admin_user() {
    if (!admin_logged_in()) {
        return null;
    }
    $db = db_connect();
    $stmt = $db->prepare('SELECT id, username, name FROM admins WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $admin;
}

function ensure_default_admin_account(): void {
    $remoteAddr = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!in_array($remoteAddr, ['127.0.0.1', '::1'], true)) {
        return;
    }
    $db = db_connect();
    $username = 'admin';
    $stmt = $db->prepare('SELECT id FROM admins WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$result) {
        $passwordHash = password_hash('password', PASSWORD_DEFAULT);
        $name = 'Administrator';
        $role = 'superadmin';
        $insert = $db->prepare('INSERT INTO admins (username, password_hash, name, role, created_at) VALUES (?, ?, ?, ?, NOW())');
        $insert->bind_param('ssss', $username, $passwordHash, $name, $role);
        $insert->execute();
        $insert->close();
    }
    $db->close();
}
