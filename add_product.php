<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Proses jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];  // Menambahkan harga

    // Insert data produk ke database
    $insert_query = "INSERT INTO products (name, description, price, created) VALUES ('$name', '$description', '$price', NOW())";
    if ($conn->query($insert_query) === TRUE) {
        echo "<p>Produk berhasil ditambahkan!</p>";
        // Redirect ke dashboard setelah berhasil
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p>Terjadi kesalahan saat menambahkan produk: " . $conn->error . "</p>";
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Tambah Produk</h2>
<form method="POST">
    Nama Produk: <input type="text" name="name" required><br><br>
    Deskripsi: <textarea name="description" required></textarea><br><br>
    Harga: <input type="number" step="0.01" name="price" required><br><br>  <!-- Menambahkan input harga -->
    <button type="submit">Tambah Produk</button>
</form>
