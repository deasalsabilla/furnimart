<?php
session_start();
include 'admin/koneksi.php'; // Pastikan file koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pesanan = $_POST['id_pesanan'];

    // Hapus produk dari keranjang (pastikan tabel keranjang sesuai)
    $query = "DELETE FROM tb_pesanan WHERE id_pesanan = '$id_pesanan'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: cart.php"); // Redirect kembali ke halaman cart
        exit();
    } else {
        echo "Gagal menghapus produk.";
    }
}
?>
