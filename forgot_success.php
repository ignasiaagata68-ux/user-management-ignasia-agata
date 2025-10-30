<?php
require 'connect.php';

// Hanya tampilkan jika ada session reset_link
if (!isset($_SESSION['reset_link'])) {
    header("Location: forgot_password.php");
    exit;
}

$link = $_SESSION['reset_link'];
unset($_SESSION['reset_link']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"><title>Permintaan Reset</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Permintaan Reset Password</h2>
  <p>Tautan reset untuk akun Anda :</p>
  <p><a href="<?= htmlspecialchars($link) ?>"><?= htmlspecialchars($link) ?></a></p>
  <p><small>Setelah klik link, kamu akan masuk ke halaman ubah password.</small></p>
  <p><a href="login.php">Kembali ke Login</a></p>
</body>
</html>
