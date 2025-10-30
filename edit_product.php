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

// Ambil data produk berdasarkan ID
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

// Proses jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];  // Menambahkan harga

    // Update data produk di database
    $update_query = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id=$id";
    if ($conn->query($update_query) === TRUE) {
        echo "<p>Produk berhasil diperbarui!</p>";
        // Redirect ke dashboard setelah berhasil
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p>Terjadi kesalahan saat memperbarui produk: " . $conn->error . "</p>";
    }
}
?>

<h2>Edit Produk</h2>
<form method="POST">
    Nama Produk: <input type="text" name="name" value="<?= $product['name']; ?>" required><br><br>
    Deskripsi: <textarea name="description" required><?= $product['description']; ?></textarea><br><br>
    Harga: <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>" required><br><br>  <!-- Menambahkan input harga -->
    <button type="submit">Update Produk</button>
</form>
