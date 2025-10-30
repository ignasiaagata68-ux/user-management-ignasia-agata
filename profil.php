<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];  // Menyimpan username atau ID pengguna

// Ambil data profil pengguna
$result = $conn->query("SELECT * FROM user WHERE username='$user'");
$user_data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    // Update profil pengguna
    $update_query = "UPDATE user SET fullname='$fullname', username='$email' WHERE id=" . $user_data['id'];
    if ($conn->query($update_query) === TRUE) {
        echo "<p>Profil berhasil diperbarui!</p>";
    } else {
        echo "<p>Terjadi kesalahan saat memperbarui profil.</p>";
    }
}
?>

<h2>Ubah Profil Pengguna</h2>
<form method="POST">
    Nama Lengkap: <input type="text" name="fullname" value="<?= htmlspecialchars($user_data['fullname']); ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($user_data['username']); ?>" required><br><br>
    <button type="submit">Perbarui Profil</button>
</form>
