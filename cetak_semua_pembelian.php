<?php
// Include file koneksi
include 'koneksi.php';

// Query untuk mengambil semua data pembelian
$query = "SELECT pembelian.kode_pembelian, data_barang.nama_barang, pembelian.jumlah, pembelian.harga_beli, pembelian.total, pembelian.tanggal FROM pembelian INNER JOIN data_barang ON pembelian.id_barang = data_barang.id_barang";
$result = mysqli_query($koneksi, $query);

// Inisialisasi array untuk menyimpan data pembelian
$pembelian_data = [];

// Periksa apakah ada data pembelian
if(mysqli_num_rows($result) > 0) {
    // Jika ada, tambahkan data pembelian ke dalam array
    while($row = mysqli_fetch_assoc($result)) {
        $pembelian_data[] = $row;
    }
} else {
    // Jika tidak ada data pembelian, tampilkan pesan
    echo "Tidak ada data pembelian.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Pembelian</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Laporan Pembelian</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pembelian</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Total</th>
                    <th>Tanggal Pembelian</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pembelian_data as $pembelian) { ?>
                    <tr>
                        <td><?php echo $pembelian['kode_pembelian']; ?></td>
                        <td><?php echo $pembelian['nama_barang']; ?></td>
                        <td><?php echo $pembelian['jumlah']; ?></td>
                        <td><?php echo $pembelian['harga_beli']; ?></td>
                        <td><?php echo $pembelian['total']; ?></td>
                        <td><?php echo $pembelian['tanggal']; ?></td>
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