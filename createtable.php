<?php
// Koneksi ke MySQL (tanpa memilih database dulu)
$koneksi = mysqli_connect("localhost", "root", "");
if (!$koneksi) {
    die("Koneksi ke MySQL gagal: " . mysqli_connect_error());
}

// Buat database usermngnt jika belum ada
$sql_create_db = "CREATE DATABASE IF NOT EXISTS usermngnt";
if (mysqli_query($koneksi, $sql_create_db)) {
    echo "Database 'usermngnt' berhasil dibuat atau sudah ada.<br>";
} else {
    die("Gagal membuat database: " . mysqli_error($koneksi));
}

// Pilih database
mysqli_select_db($koneksi, "usermngnt");

// Buat tabel users
$sql_create_table = "
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  activation_code VARCHAR(100),
  reset_code VARCHAR(100),
  is_active TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

if (mysqli_query($koneksi, $sql_create_table)) {
    echo "Tabel 'users' berhasil dibuat atau sudah ada.<br>";
} else {
    die("Gagal membuat tabel: " . mysqli_error($koneksi));
}

// Tambahkan 1 user contoh
$hashed_pass = password_hash("admin123", PASSWORD_DEFAULT);
$sql_insert = "INSERT IGNORE INTO users (name, email, password, is_active)
               VALUES ('Administrator', 'admin@example.com', '$hashed_pass', 1)";
if (mysqli_query($koneksi, $sql_insert)) {
    echo "User contoh berhasil ditambahkan (email: admin@example.com | password: admin123).";
} else {
    echo "Gagal menambahkan user contoh: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
