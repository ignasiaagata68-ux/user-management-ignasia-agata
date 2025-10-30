<?php
require 'connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $fullname = trim($_POST['fullname']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah email sudah digunakan
    $check = $conn->query("SELECT * FROM user WHERE username='$email'");
    if ($check->num_rows > 0) {
        $message = "<p style='color:red'>Email sudah digunakan!</p>";
    } else {
        $token = md5(uniqid(rand(), true));
        $sql = "INSERT INTO user (username, password, fullname, role, status, reg_date, modified, activation_token)
                VALUES ('$email', '$password', '$fullname', 'AdminGudang', 'inactive', NOW(), NOW(), '$token')";
        if ($conn->query($sql)) {
            // Simpan token di session dan redirect ke halaman sukses
            $_SESSION['activation_token'] = $token;
            header("Location: register_success.php");
            exit;
        } else {
            $message = "<p style='color:red'>Terjadi kesalahan saat registrasi.</p>";
        }
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Registrasi Admin Gudang</h2>
<form method="POST">
    Nama Lengkap: <input type="text" name="fullname" required><br><br>
    Email (Username): <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Daftar</button>
</form>

<p><?= $message ?></p>
<p><a href="login.php">Sudah punya akun? Login</a></p>
