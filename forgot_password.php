<?php
require 'connect.php';

// Jika sudah POST, proses lalu redirect (POST->Redirect->GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Prepared statement untuk mencari user
    $stmt = $conn->prepare("SELECT id, fullname FROM user WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $user_id = $row['id'];

        // simpan sementara di session untuk ditampilkan di halaman sukses
        $_SESSION['reset_link'] = "http://localhost/user_management_agata/reset_password.php?id=" . $user_id;

        // redirect ke halaman sukses (menghindari resubmission)
        header("Location: forgot_success.php");
        exit;
    } else {
        $_SESSION['forgot_error'] = "Email tidak ditemukan.";
        header("Location: forgot_password.php");
        exit;
    }
}

// GET -> tampilkan form (jika ada pesan di session, tampilkan)
$error = $_SESSION['forgot_error'] ?? '';
unset($_SESSION['forgot_error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"><title>Lupa Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Lupa Password</h2>
  <?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="POST" action="forgot_password.php">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit">Kirim Link Reset</button>
  </form>
  <p><a href="login.php">Kembali ke Login</a></p>
</body>
</html>
