<?php
// Include file koneksi
include 'koneksi.php';

// Periksa apakah parameter id_barang telah diterima
if(isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];

    // Query untuk menghapus data barang berdasarkan id_barang
    $query = "DELETE FROM data_barang WHERE id_barang = '" . mysqli_real_escape_string($koneksi, $id_barang) . "'";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Jika berhasil, kembalikan ke halaman data_barang.php
        header("Location: data_barang.php");
        exit();
    } else {
        echo "Gagal menghapus data barang: " . mysqli_error($koneksi);
    }
} else {
    echo "Parameter id_barang tidak diterima.";
    exit();
}
?>