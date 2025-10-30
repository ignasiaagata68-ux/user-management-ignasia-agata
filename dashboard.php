<?php
require 'connect.php';

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari session
$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard Admin Gudang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .navbar { margin-bottom: 20px; }
        .navbar a { margin-right: 15px; text-decoration: none; }
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="products.php">Produk</a>
    <a href="change_password.php">Ubah Password</a>
    <a href="logout.php" onclick="return confirmLogout()">Logout</a>
</div>

<h2>Dashboard Admin Gudang</h2>
<p>Selamat datang, <b><?= htmlspecialchars($fullname) ?></b> (<?= htmlspecialchars($role) ?>)</p>

<h3>Data Produk</h3>
<p><a href="add_product.php">Tambah Produk Baru</a></p>
<?php
// Ambil data produk dari database
$result = $conn->query("SELECT * FROM products");

if ($result->num_rows > 0):
?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($product = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= htmlspecialchars($product['description']) ?></td>
            <td><?= number_format($product['price'], 2, ',', '.') ?></td>
            <td>
                <a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a> |
                <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>Belum ada produk yang ditambahkan.</p>
<?php endif; ?>

<script>
// Konfirmasi sebelum logout
function confirmLogout() {
    return confirm("Apakah Anda yakin ingin logout?");
}
</script>

</body>
</html>
