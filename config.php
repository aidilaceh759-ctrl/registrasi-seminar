<?php
session_start();

// Ubah sesuai environment MySQL Anda
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'seminar_registration');
define('DB_USER', 'root');
define('DB_PASS', '');

define('UPLOAD_DIR', __DIR__ . '/uploads');
define('UPLOAD_URL', '/seminar-registration/uploads');

function db_connect() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        die('Database connection failed: ' . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}

function flash($key, $message = null) {
    if ($message === null) {
        if (!empty($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        return null;
    }
    $_SESSION['flash'][$key] = $message;
}

function generate_registration_code() {
    return strtoupper('REG-' . bin2hex(random_bytes(3)) . '-' . random_int(100, 999));
}

function validate_phone($phone) {
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    return preg_match('/^\+?\d{8,15}$/', $phone);
}

function admin_logged_in() {
    return !empty($_SESSION['admin_id']);
}

function require_admin() {
    if (!admin_logged_in()) {
        header('Location: /seminar-registration/admin/login.php');
        exit;
    }
}

function get_status_label($status) {
    return match ($status) {
        'accepted' => 'Diterima',
        'rejected' => 'Ditolak',
        default => 'Menunggu Verifikasi',
    };
}
