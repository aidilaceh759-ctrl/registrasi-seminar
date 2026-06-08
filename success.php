<?php
require_once __DIR__ . '/helpers.php';
$code = sanitize($_GET['code'] ?? '');
$registration = $code ? get_registration_by_code($code) : null;
if (!$registration) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Berhasil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gradient">
  <main class="py-5">
    <div class="container">
      <div class="glass p-5 shadow-soft mx-auto" style="max-width: 800px;">
        <div class="text-center mb-4">
          <span class="badge bg-success bg-opacity-15 text-success mb-3">Pendaftaran Berhasil</span>
          <h1 class="h3 text-white">Terima kasih, <?= sanitize($registration['nama_lengkap']) ?>!</h1>
          <p class="text-muted">Nomor registrasi Anda berhasil dibuat. Silakan simpan informasi berikut.</p>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <div class="info-box p-3 bg-dark-secondary rounded">
              <strong>Nomor Registrasi</strong>
              <p class="mb-0 text-white"><?= sanitize($registration['registration_code']) ?></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box p-3 bg-dark-secondary rounded">
              <strong>Status</strong>
              <p class="mb-0 text-white"><?= get_status_label($registration['status']) ?></p>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <div class="detail-card p-3 bg-dark-secondary rounded">
              <h5>Seminar</h5>
              <p class="mb-1"><?= sanitize($registration['nama_seminar']) ?></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-card p-3 bg-dark-secondary rounded">
              <h5>Email</h5>
              <p class="mb-1"><?= sanitize($registration['email']) ?></p>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <div class="detail-card p-3 bg-dark-secondary rounded">
              <h5>Nomor WA</h5>
              <p class="mb-1"><?= sanitize($registration['whatsapp']) ?></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-card p-3 bg-dark-secondary rounded">
              <h5>Instansi</h5>
              <p class="mb-1"><?= sanitize($registration['instansi']) ?></p>
            </div>
          </div>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
          <button onclick="window.print()" class="btn btn-outline-light btn-lg">Download Bukti Registrasi PDF</button>
          <a href="status.php" class="btn btn-primary btn-lg">Cek Status Lainnya</a>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
