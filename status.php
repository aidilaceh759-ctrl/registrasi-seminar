<?php
require_once __DIR__ . '/helpers.php';
$searchEmail = sanitize($_GET['email'] ?? '');
$searchCode = sanitize($_GET['code'] ?? '');
$results = [];
if ($searchCode) {
    $registration = get_registration_by_code($searchCode);
    if ($registration) {
        $results[] = $registration;
    }
} elseif ($searchEmail) {
    $results = get_registration_by_email($searchEmail);
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cek Status Registrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gradient">
  <main class="py-5">
    <div class="container">
      <div class="glass p-5 shadow-soft mx-auto" style="max-width: 900px;">
        <h1 class="h3 text-white mb-3">Cek Status Registrasi</h1>
        <p class="text-muted">Cari menggunakan email atau nomor registrasi untuk melihat status terbaru Anda.</p>
        <form class="row g-3 mb-4" method="get" action="status.php">
          <div class="col-md-5">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= sanitize($searchEmail) ?>">
          </div>
          <div class="col-md-5">
            <label class="form-label">Nomor Registrasi</label>
            <input type="text" name="code" class="form-control" value="<?= sanitize($searchCode) ?>">
          </div>
          <div class="col-md-2 d-grid">
            <button class="btn btn-primary btn-lg" type="submit">Cari</button>
          </div>
        </form>

        <?php if ($searchCode || $searchEmail): ?>
          <?php if (empty($results)): ?>
            <div class="alert alert-warning">Data tidak ditemukan. Pastikan email atau nomor registrasi benar.</div>
          <?php else: ?>
            <?php foreach ($results as $item): ?>
              <div class="result-card glass p-4 mb-4 shadow-soft">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                  <div>
                    <h5 class="text-white mb-2"><?= sanitize($item['registration_code']) ?></h5>
                    <p class="mb-1"><strong>Nama:</strong> <?= sanitize($item['nama_lengkap']) ?></p>
                    <p class="mb-1"><strong>Seminar:</strong> <?= sanitize($item['nama_seminar']) ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?= sanitize($item['email']) ?></p>
                  </div>
                  <div class="text-md-end">
                    <span class="badge bg-info bg-opacity-15 text-info p-2"><?= get_status_label($item['status']) ?></span>
                    <p class="mb-0 text-muted">Tanggal registrasi: <?= date('d M Y', strtotime($item['created_at'])) ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endif; ?>

        <div class="text-center mt-3">
          <a href="index.php" class="btn btn-outline-light">Kembali ke Beranda</a>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
