<?php
require 'connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $conn->query("SELECT * FROM user WHERE activation_token='$token' AND status='inactive'");

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Aktifkan akun
        $conn->query("UPDATE user SET status='active', activation_token=NULL WHERE id=" . $user['id']);
        echo "<p>Akun berhasil diaktivasi! Silakan <a href='login.php'>login</a>.</p>";
    } else {
        echo "<p style='color:red;'>Token tidak valid atau sudah kedaluwarsa.</p>";
    }
} else {
    echo "<p style='color:red;'>Token tidak ditemukan.</p>";
}
?>
