<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Ambil data produk
$result = $conn->query("SELECT * FROM products");
?>
<link rel="stylesheet" href="style.css">
<h2>Daftar Produk</h2>
<p>Selamat datang, <b><?= $_SESSION['fullname']; ?></b> (<?= $_SESSION['role']; ?>)</p>

<h3>Data Produk</h3>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>  <!-- Menambahkan kolom harga -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($product = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $product['id']; ?></td>
                <td><?= $product['name']; ?></td>
                <td><?= $product['description']; ?></td>
                <td><?= number_format($product['price'], 2, ',', '.'); ?></td>  <!-- Menampilkan harga dengan format -->
                <td>
                    <a href="edit_product.php?id=<?= $product['id']; ?>">Edit</a> | 
                    <a href="delete_product.php?id=<?= $product['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Tombol untuk tambah produk -->
<p><a href="add_product.php">Tambah Produk</a></p>
<p><a href="logout.php">Logout</a></p>
