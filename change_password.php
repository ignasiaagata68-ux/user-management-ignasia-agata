<?php
require 'connect.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];  // Menyimpan username atau ID pengguna

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Cek password lama
    $result = $conn->query("SELECT * FROM user WHERE username='$user'");
    $user_data = $result->fetch_assoc();

    // Debugging: Cek apakah password lama sesuai
    if (password_verify($old_password, $user_data['password'])) {
        // Enkripsi password baru
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password
        $update_query = "UPDATE user SET password='$new_password_hashed' WHERE id=" . $user_data['id'];
        if ($conn->query($update_query) === TRUE) {
            echo "<p>Password berhasil diperbarui!</p>";
            // Redirect ke dashboard setelah berhasil
            header("Location: dashboard.php");
        } else {
            echo "<p>Terjadi kesalahan saat memperbarui password: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Password lama tidak sesuai.</p>";
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Ubah Password</h2>
<form method="POST">
    Password Lama: <input type="password" name="old_password" required><br><br>
    Password Baru: <input type="password" name="new_password" required><br><br>
    <button type="submit">Ubah Password</button>
</form>
