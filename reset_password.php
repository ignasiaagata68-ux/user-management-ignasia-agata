<?php
require 'connect.php';

// pastikan ada id di URL
if (!isset($_GET['id'])) {
    die("Parameter id tidak ditemukan.");
}

$id = intval($_GET['id']);

// Ambil user berdasarkan id untuk memastikan ada
$stmt = $conn->prepare("SELECT id, username, fullname FROM user WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows !== 1) {
    die("User tidak ditemukan.");
}

$user = $res->fetch_assoc();

// Jika form disubmit, proses update password (POST -> Redirect -> GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    if ($new === '' || $confirm === '') {
        $_SESSION['reset_error'] = "Password tidak boleh kosong.";
        header("Location: reset_password.php?id=" . $id);
        exit;
    }

    if ($new !== $confirm) {
        $_SESSION['reset_error'] = "Password baru dan konfirmasi tidak sama.";
        header("Location: reset_password.php?id=" . $id);
        exit;
    }

    // Hash dan update
    $new_hashed = password_hash($new, PASSWORD_DEFAULT);
    $up = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
    $up->bind_param("si", $new_hashed, $id);

    if ($up->execute()) {
        // Success -> redirect ke login dengan pesan
        header("Location: login.php?reset=success");
        exit;
    } else {
        $_SESSION['reset_error'] = "Gagal memperbarui password. Silakan coba lagi.";
        header("Location: reset_password.php?id=" . $id);
        exit;
    }
}

// GET -> tampilkan form (tampilkan error jika ada)
$error = $_SESSION['reset_error'] ?? '';
unset($_SESSION['reset_error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><title>Reset Password</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
  <h2>Reset Password untuk <?= htmlspecialchars($user['username']) ?></h2>
  <?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="POST" action="reset_password.php?id=<?= $id ?>">
    <label>Password baru:</label><br>
    <input type="password" name="new_password" required><br><br>

    <label>Konfirmasi password baru:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Ubah Password</button>
  </form>
  <p><a href="login.php">Kembali ke Login</a></p>
</body>
</html>
