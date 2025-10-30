<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah ada ID produk di URL
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

// Hapus produk dari database
$delete_query = "DELETE FROM products WHERE id=$id";
if ($conn->query($delete_query) === TRUE) {
    echo "<p>Produk berhasil dihapus!</p>";
    // Redirect ke dashboard setelah berhasil
    header("Location: dashboard.php");
    exit;
} else {
    echo "<p>Terjadi kesalahan saat menghapus produk: " . $conn->error . "</p>";
}
?>
