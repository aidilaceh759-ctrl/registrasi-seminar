-- Database: seminar_registration

CREATE DATABASE IF NOT EXISTS seminar_registration CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE seminar_registration;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  name VARCHAR(120) NOT NULL,
  role VARCHAR(40) NOT NULL DEFAULT 'admin',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS seminars (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_seminar VARCHAR(255) NOT NULL,
  tema VARCHAR(255) NOT NULL,
  deskripsi TEXT NOT NULL,
  tanggal DATE NOT NULL,
  jam VARCHAR(60) NOT NULL,
  lokasi VARCHAR(255) NOT NULL,
  kuota INT NOT NULL DEFAULT 100,
  harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  poster VARCHAR(255) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS participants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_lengkap VARCHAR(255) NOT NULL,
  nim_nip VARCHAR(100) DEFAULT NULL,
  instansi VARCHAR(255) NOT NULL,
  email VARCHAR(180) NOT NULL UNIQUE,
  whatsapp VARCHAR(40) NOT NULL,
  jenis_kelamin VARCHAR(40) NOT NULL,
  alamat TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  participant_id INT NOT NULL,
  seminar_id INT NOT NULL,
  registration_code VARCHAR(80) NOT NULL UNIQUE,
  payment_proof VARCHAR(255) NOT NULL,
  status ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (participant_id) REFERENCES participants(id) ON DELETE CASCADE,
  FOREIGN KEY (seminar_id) REFERENCES seminars(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT IGNORE INTO admins (username, password_hash, name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'superadmin');

INSERT IGNORE INTO seminars (nama_seminar, tema, deskripsi, tanggal, jam, lokasi, kuota, harga) VALUES
('Seminar Digital Marketing 2026', 'Strategi Pemasaran Digital', 'Pelajari strategi digital marketing, brand building, dan lead generation dengan studi kasus nyata.', DATE_ADD(CURDATE(), INTERVAL 10 DAY), '09:00 - 12:00', 'Online Zoom', 150, 149000),
('Seminar Leadership Modern', 'Kepemimpinan untuk Era Hybrid', 'Kembangkan kemampuan kepemimpinan dan manajemen tim jarak jauh dengan pendekatan modern.', DATE_ADD(CURDATE(), INTERVAL 18 DAY), '13:00 - 16:00', 'Online Webinar', 120, 179000);
