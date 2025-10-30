<?php
require 'connect.php';

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM user WHERE username='$email'");

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($user['status'] != 'active') {
            $message = "Akun belum diaktifkan!";
        } elseif (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Password salah!";
        }
    } else {
        $message = "Email tidak ditemukan!";
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Login Admin Gudang</h2>
<form method="POST">
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>

<p><?= isset($message) ? $message : ''; ?></p>
<p><a href="register.php">Belum punya akun? Daftar</a></p>
<p><a href="forgot_password.php">Lupa Password?</a></p>
