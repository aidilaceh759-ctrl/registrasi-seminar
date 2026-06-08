<?php
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nama_lengkap = sanitize($_POST['nama_lengkap'] ?? '');
$nim_nip = sanitize($_POST['nim_nip'] ?? '');
$instansi = sanitize($_POST['instansi'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$whatsapp = sanitize($_POST['whatsapp'] ?? '');
$jenis_kelamin = sanitize($_POST['jenis_kelamin'] ?? '');
$alamat = sanitize($_POST['alamat'] ?? '');
$seminar_id = intval($_POST['seminar_id'] ?? 0);

if (!$nama_lengkap || !$instansi || !$email || !$whatsapp || !$jenis_kelamin || !$alamat || !$seminar_id) {
    flash('error', 'Semua field wajib diisi kecuali NIM/NIP.');
    header('Location: index.php#register');
    exit;
}

if (!validate_phone($whatsapp)) {
    flash('error', 'Nomor WhatsApp tidak valid. Gunakan format 62xxxx atau +62xxxx.');
    header('Location: index.php#register');
    exit;
}

$db = db_connect();
// Cek email unik di participants
$stmt = $db->prepare('SELECT id FROM participants WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
$existing = $stmt->num_rows > 0;
$stmt->close();
if ($existing) {
    flash('error', 'Email sudah terdaftar. Silakan gunakan email lain atau cek status Anda.');
    header('Location: index.php#register');
    exit;
}

if (empty($_FILES['payment_proof']['name'])) {
    flash('error', 'Bukti pembayaran wajib diunggah.');
    header('Location: index.php#register');
    exit;
}

$file = $_FILES['payment_proof'];
$allowed = ['image/jpeg', 'image/png', 'application/pdf'];
if ($file['error'] !== UPLOAD_ERR_OK || !in_array($file['type'], $allowed) || $file['size'] > 2 * 1024 * 1024) {
    flash('error', 'Bukti pembayaran harus JPG, PNG, atau PDF maksimal 2MB.');
    header('Location: index.php#register');
    exit;
}

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'proof_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . '/' . $filename)) {
    flash('error', 'Gagal mengunggah bukti pembayaran. Coba lagi.');
    header('Location: index.php#register');
    exit;
}

$db->begin_transaction();
try {
    $stmt = $db->prepare('INSERT INTO participants (nama_lengkap, nim_nip, instansi, email, whatsapp, jenis_kelamin, alamat, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
    $stmt->bind_param('sssssss', $nama_lengkap, $nim_nip, $instansi, $email, $whatsapp, $jenis_kelamin, $alamat);
    $stmt->execute();
    $participant_id = $stmt->insert_id;
    $stmt->close();

    $registration_code = generate_registration_code();
    $status = 'pending';
    $stmt = $db->prepare('INSERT INTO registrations (participant_id, seminar_id, registration_code, payment_proof, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
    $stmt->bind_param('iisss', $participant_id, $seminar_id, $registration_code, $filename, $status);
    $stmt->execute();
    $stmt->close();

    $db->commit();
    header('Location: success.php?code=' . urlencode($registration_code));
    exit;
} catch (Exception $e) {
    $db->rollback();
    if (file_exists(UPLOAD_DIR . '/' . $filename)) {
        unlink(UPLOAD_DIR . '/' . $filename);
    }
    flash('error', 'Terjadi kesalahan saat memproses pendaftaran. Coba lagi.');
    header('Location: index.php#register');
    exit;
}
