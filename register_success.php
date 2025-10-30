<?php
session_start();
if (isset($_SESSION['activation_token'])) {
    $token = $_SESSION['activation_token'];
    unset($_SESSION['activation_token']);
    echo "<p>Registrasi berhasil! Klik tautan berikut untuk aktivasi akun:</p>";
    echo "<a href='activate.php?token=$token'>Aktifkan Akun Sekarang</a>";
} else {
    header("Location: login.php");
    exit;
}
?>
