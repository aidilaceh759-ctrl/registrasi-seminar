<?php
require_once __DIR__ . '/helpers.php';
$seminars = get_active_seminars();
$flash_success = flash('success');
$flash_error = flash('error');
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Seminar Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gradient">
  <header class="navbar navbar-expand-lg navbar-dark sticky-top glass p-3">
    <div class="container">
      <a class="navbar-brand text-white fw-bold" href="#home">Seminar Pro</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#details">Detail</a></li>
          <li class="nav-item"><a class="nav-link" href="#speakers">Pembicara</a></li>
          <li class="nav-item"><a class="nav-link" href="#schedule">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin</a></li>
          <li class="nav-item"><a class="nav-link btn btn-outline-light btn-sm ms-2" href="#register">Daftar Sekarang</a></li>
        </ul>
      </div>
    </div>
  </header>

  <main>
    <section id="home" class="hero-section py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <p class="text-info mb-2">Seminar Premium Online</p>
            <h1 class="display-5 fw-bold text-white">Tingkatkan Keterampilan Anda dengan Seminar Profesional</h1>
            <p class="lead text-light opacity-85">Ikuti seminar intensif dengan narasumber ahli, materi terkini, dan bukti registrasi resmi.</p>
            <div class="d-flex flex-column flex-sm-row gap-2">
              <a class="btn btn-primary btn-lg" href="#register">Daftar Sekarang</a>
              <a class="btn btn-outline-light btn-lg" href="status.php">Cek Status</a>
            </div>
          </div>
          <div class="col-lg-6 mt-4 mt-lg-0 text-center">
            <div class="hero-card glass p-5 shadow-soft text-start">
              <div class="hero-badge">Seminar Utama</div>
              <?php if (!empty($seminars)): ?>
                <h3 class="mt-3"><?= sanitize($seminars[0]['nama_seminar']) ?></h3>
                <p class="text-muted">Pelajari strategi terbaru dari pembicara profesional dalam sesi interaktif.</p>
                <ul class="detail-list list-unstyled">
                  <li><strong>Tanggal:</strong> <?= date('d M Y', strtotime($seminars[0]['tanggal'])) ?> · <?= sanitize($seminars[0]['jam']) ?></li>
                  <li><strong>Lokasi:</strong> <?= sanitize($seminars[0]['lokasi']) ?></li>
                  <li><strong>Kuota:</strong> <?= sanitize($seminars[0]['kuota']) ?> peserta</li>
                </ul>
                <div class="stats-grid">
                  <div class="stat-box">
                    <span>Peserta Terdaftar</span>
                    <strong>120+</strong>
                  </div>
                  <div class="stat-box">
                    <span>Durasi</span>
                    <strong>3 Jam</strong>
                  </div>
                  <div class="stat-box">
                    <span>Kapasitas</span>
                    <strong><?= sanitize($seminars[0]['kuota']) ?></strong>
                  </div>
                </div>
              <?php else: ?>
                <p class="text-light">Tidak ada seminar terjadwal saat ini. Silakan cek kembali nanti.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="details" class="py-5">
      <div class="container">
        <div class="section-heading text-center mb-5">
          <span class="badge rounded-pill bg-info bg-opacity-15 text-info mb-2">Detail Seminar</span>
          <h2 class="fw-bold text-white">Mengapa Anda harus ikut?</h2>
          <p class="text-muted text-center mx-auto" style="max-width: 720px;">Seminar ini disusun untuk meningkatkan kompetensi profesional, memperluas jaringan, dan memberikan sertifikat kehadiran.</p>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="info-card glass p-4 h-100 shadow-soft">
              <h5 class="mb-3">Tema Mendalam</h5>
              <p>Materi dibahas secara praktis dengan studi kasus, strategi, dan tips yang mudah dipraktikkan.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-card glass p-4 h-100 shadow-soft">
              <h5 class="mb-3">Pembicara Terpercaya</h5>
              <p>Narasumber profesional dan praktisi berpengalaman di bidang industri.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-card glass p-4 h-100 shadow-soft">
              <h5 class="mb-3">Sertifikat & Bukti</h5>
              <p>Peserta mendapatkan bukti registrasi serta akses cetak PDF resmi setelah terdaftar.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="speakers" class="py-5 bg-dark-secondary">
      <div class="container">
        <div class="section-heading text-center mb-5">
          <span class="badge rounded-pill bg-light text-dark mb-2">Pembicara</span>
          <h2 class="fw-bold text-white">Narasumber Utama</h2>
        </div>
        <div class="row g-4">
          <div class="col-sm-6 col-lg-4">
            <div class="speaker-card glass p-4 shadow-soft h-100">
              <div class="speaker-avatar mb-3">AH</div>
              <h5>Andi Haryanto</h5>
              <p>Praktisi Digital Marketing dan Trainer Profesional.</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="speaker-card glass p-4 shadow-soft h-100">
              <div class="speaker-avatar mb-3">RN</div>
              <h5>Rina Nurhasan</h5>
              <p>Ahli Manajemen Proyek dan Pengembangan Karir.</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="speaker-card glass p-4 shadow-soft h-100">
              <div class="speaker-avatar mb-3">SB</div>
              <h5>Samuel Basuki</h5>
              <p>Spesialis Teknologi Informasi dan Analisis Data.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="schedule" class="py-5">
      <div class="container">
        <div class="section-heading text-center mb-5">
          <span class="badge rounded-pill bg-info bg-opacity-15 text-info mb-2">Jadwal Acara</span>
          <h2 class="fw-bold text-white">Agenda Seminar</h2>
        </div>
        <div class="timeline">
          <div class="timeline-item glass p-4 shadow-soft mb-4">
            <h5>09:00 - 09:30</h5>
            <p>Registrasi peserta dan pembukaan.</p>
          </div>
          <div class="timeline-item glass p-4 shadow-soft mb-4">
            <h5>09:30 - 11:00</h5>
            <p>Presentasi materi utama dan diskusi.</p>
          </div>
          <div class="timeline-item glass p-4 shadow-soft mb-4">
            <h5>11:00 - 12:00</h5>
            <p>Studi kasus dan sesi tanya jawab.</p>
          </div>
          <div class="timeline-item glass p-4 shadow-soft">
            <h5>12:00 - 12:30</h5>
            <p>Penutup, pengumuman peserta terverifikasi, dan dokumentasi.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="faq" class="py-5 bg-dark-secondary">
      <div class="container">
        <div class="section-heading text-center mb-5">
          <span class="badge rounded-pill bg-light text-dark mb-2">FAQ</span>
          <h2 class="fw-bold text-white">Pertanyaan Umum</h2>
        </div>
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item glass border-0 shadow-soft mb-3">
            <h2 class="accordion-header" id="faqOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">Bagaimana cara mendaftar?</button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">Isi form pendaftaran pada bagian "Daftar Sekarang" dan upload bukti pembayaran Anda.</div>
            </div>
          </div>
          <div class="accordion-item glass border-0 shadow-soft mb-3">
            <h2 class="accordion-header" id="faqTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">Apa saja dokumen yang diperlukan?</button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">Hanya bukti pembayaran dalam format JPG, PNG, atau PDF maksimal 2MB.</div>
            </div>
          </div>
          <div class="accordion-item glass border-0 shadow-soft">
            <h2 class="accordion-header" id="faqThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">Bagaimana mengecek status?</button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">Gunakan menu "Cek Status" untuk mencari berdasarkan email atau nomor registrasi.</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="register" class="py-5">
      <div class="container">
        <div class="section-heading text-center mb-5">
          <span class="badge rounded-pill bg-info bg-opacity-15 text-info mb-2">Form Registrasi</span>
          <h2 class="fw-bold text-white">Daftar Sekarang</h2>
          <p class="text-muted">Lengkapi data Anda untuk menerima bukti registrasi resmi.</p>
        </div>
        <?php if ($flash_success): ?>
          <div class="alert alert-success"><?= sanitize($flash_success) ?></div>
        <?php endif; ?>
        <?php if ($flash_error): ?>
          <div class="alert alert-danger"><?= sanitize($flash_error) ?></div>
        <?php endif; ?>
        <div class="glass p-4 shadow-soft">
          <form id="registrationForm" action="process_registration.php" method="post" enctype="multipart/form-data" novalidate>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">NIM/NIP (opsional)</label>
                <input type="text" name="nim_nip" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Instansi</label>
                <input type="text" name="instansi" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" id="emailInput" name="email" class="form-control" required>
                <div id="emailFeedback" class="form-text text-warning"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nomor WhatsApp</label>
                <input type="text" id="whatsappInput" name="whatsapp" class="form-control" placeholder="62xxxxxxxxxx" required>
                <div id="whatsappFeedback" class="form-text text-warning"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                  <option value="">Pilih</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" name="payment_proof" class="form-control" accept="image/*,application/pdf" required>
                <div class="form-text">Maksimum 2MB. JPG, PNG, atau PDF.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Pilihan Seminar</label>
                <select name="seminar_id" class="form-select" required>
                  <option value="">Pilih Seminar</option>
                  <?php foreach ($seminars as $seminar): ?>
                    <option value="<?= sanitize($seminar['id']) ?>"><?= sanitize($seminar['nama_seminar']) ?> - <?= date('d M Y', strtotime($seminar['tanggal'])) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-primary btn-lg">Kirim Pendaftaran</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer class="py-4 text-center text-muted small">
    <div class="container">© 2026 Seminar Pro. Sistem registrasi seminar online responsif.</div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script>
</body>
</html>
