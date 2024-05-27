<?php
// Include file koneksi
include 'koneksi.php';

// Query untuk mengambil semua data penjualan
$query = "SELECT penjualan.kode_penjualan, data_barang.nama_barang, penjualan.jumlah, penjualan.harga_jual, penjualan.total, penjualan.tanggal FROM penjualan INNER JOIN data_barang ON penjualan.id_barang = data_barang.id_barang";
$result = mysqli_query($koneksi, $query);

// Inisialisasi array untuk menyimpan data penjualan
$penjualan_data = [];

// Periksa apakah ada data penjualan
if(mysqli_num_rows($result) > 0) {
    // Jika ada, tambahkan data penjualan ke dalam array
    while($row = mysqli_fetch_assoc($result)) {
        $penjualan_data[] = $row;
    }
} else {
    // Jika tidak ada data penjualan, tampilkan pesan
    echo "Tidak ada data penjualan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Penjualan</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Laporan Penjualan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Penjualan</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Jual</th>
                    <th>Total</th>
                    <th>Tanggal Penjualan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($penjualan_data as $penjualan) { ?>
                    <tr>
                        <td><?php echo $penjualan['kode_penjualan']; ?></td>
                        <td><?php echo $penjualan['nama_barang']; ?></td>
                        <td><?php echo $penjualan['jumlah']; ?></td>
                        <td><?php echo $penjualan['harga_jual']; ?></td>
                        <td><?php echo $penjualan['total']; ?></td>
                        <td><?php echo $penjualan['tanggal']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>