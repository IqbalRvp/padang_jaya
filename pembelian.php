<?php
// Include file koneksi
include 'koneksi.php';

// Inisialisasi variabel untuk pesan kesalahan
$error_message = '';
$success_message = '';

// Ambil data barang dari database
$query_barang = "SELECT id_barang, nama_barang, harga_beli FROM data_barang";
$result_barang = mysqli_query($koneksi, $query_barang);

function generateIDpembelian($koneksi) {
    $query = "SELECT max(kode_pembelian) as maxKode FROM pembelian";
    $hasil = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($hasil);

    $maxkode = $data['maxKode'];

    // Jika maxkode adalah NULL, ini berarti belum ada data, mulai dari BR001
    if ($maxkode == NULL) {
        $nourut = 1;
    } else {
        // Ekstraksi bagian numerik dari ID
        $nourut = (int) substr($maxkode, 4) + 1;
    }

    $char = 'BL';
    $kodejadi = $char . sprintf("%04s", $nourut);
    return $kodejadi;
}

// Ambil ID barang baru
$id_pembelian_baru = generateIDpembelian($koneksi);

// Periksa apakah form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $kode_pembelian = $_POST['kode_pembelian'];
    $id_barang = mysqli_real_escape_string($koneksi, $_POST['id_barang']);
    $jumlah = intval($_POST['jumlah']);

    // Ambil harga beli dari database berdasarkan ID barang
    $query_harga = "SELECT harga_beli FROM data_barang WHERE id_barang='$id_barang'";
    $result_harga = mysqli_query($koneksi, $query_harga);

    if (mysqli_num_rows($result_harga) > 0) {
        $row_harga = mysqli_fetch_assoc($result_harga);
        $harga_beli = $row_harga['harga_beli'];
        $total = $harga_beli * $jumlah;

        // Mulai transaksi
        mysqli_begin_transaction($koneksi);

        // Query untuk menambahkan data pembelian ke dalam tabel
        $query_pembelian = "INSERT INTO pembelian (kode_pembelian, id_barang, jumlah, harga_beli, total, tanggal) VALUES ('$kode_pembelian', '$id_barang', '$jumlah', '$harga_beli', '$total', CURRENT_TIMESTAMP)";

        // Eksekusi query pembelian
        $result_pembelian = mysqli_query($koneksi, $query_pembelian);

        // Query untuk mengupdate stok barang
        $query_update_stok = "UPDATE data_barang SET stok = stok + '$jumlah' WHERE id_barang = '$id_barang'";

        // Eksekusi query update stok barang
        $result_update_stok = mysqli_query($koneksi, $query_update_stok);

        // Periksa apakah query pembelian dan update stok berhasil dieksekusi
        if ($result_pembelian && $result_update_stok) {
            // Commit transaksi jika semua query berhasil dieksekusi
            mysqli_commit($koneksi);
            $success_message = "Transaksi pembelian berhasil. Stok barang berhasil diperbarui.";
            header("Location: data_barang.php");
        } else {
            // Rollback transaksi jika terjadi kesalahan pada salah satu query
            mysqli_rollback($koneksi);
            $error_message = "Gagal melakukan transaksi pembelian: " . mysqli_error($koneksi);
        }
    } else {
        // Jika ID barang tidak ditemukan dalam database
        $error_message = "Nama barang tidak terdaftar dalam database. Pembelian gagal.";
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pembelian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
</head>

<body>
    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.php">
                        <h2 class="page-title pull-left">Padang Jaya</h2>
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="index.php" aria-expanded="true"><i class="ti-dashboard"></i><span>Dashboard</span></a>
                            </li>
                            <li>
                                <a href="data_barang.php" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>Data Barang</span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-pie-chart"></i><span>Transaksi</span></a>
                                <ul class="collapse">
                                    <li><a href="pembelian.php">Pembelian</a></li>
                                    <li><a href="penjualan.php">Penjualan</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-pie-chart"></i><span>Laporan</span></a>
                                <ul class="collapse">
                                    <li><a href="lap_pembelian.php">Pembelian</a></li>
                                    <li><a href="lap_penjualan.php">Penjualan</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="logout.php" aria-expanded="true"><i class="fa fa-lock"></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Pembelian</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>Pembelian Barang</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <h2>Pembelian Barang</h2>
                <?php if ($error_message) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>
                <?php if ($success_message) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php } ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="pembelianForm">
                    <div class="form-group">
                        <label>Kode pembelian</label>
                        <input type="text" name="kode_pembelian" class="form-control" value="<?php echo $id_pembelian_baru; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <select name="id_barang" id="id_barang" class="form-control" required>
                            <option value="">Pilih Nama Barang</option>
                            <?php while ($row_barang = mysqli_fetch_assoc($result_barang)) { ?>
                                <option value="<?php echo $row_barang['id_barang']; ?>" data-harga="<?php echo $row_barang['harga_beli']; ?>">
                                    <?php echo $row_barang['nama_barang']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Beli</label>
                        <input type="text" name="harga_beli" id="harga_beli" class="form-control" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Total</label>
                        <input type="number" name="total" id="total" class="form-control" readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Pembelian</button>
                    <!-- <a href="data_barang.php" class="btn btn-secondary">Kembali</a> -->
                </form>
            </div>
            <footer>
                <div class="footer-area">
                    <p>© Copyright 2024. All right reserved. Template by <a href="https://colorlib.com/wp/">Polije</a>.</p>
                </div>
            </footer>
        </div>
        <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        <script src="assets/js/jquery.slicknav.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
        <script>
            zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
        <script src="assets/js/line-chart.js"></script>
        <script src="assets/js/pie-chart.js"></script>
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/scripts.js"></script>
        <script>
            $(document).ready(function () {
                $('#id_barang').change(function () {
                    var harga_beli = $(this).find(':selected').data('harga');
                    $('#harga_beli').val(harga_beli);
                    var jumlah = $('#jumlah').val();
                    var total = harga_beli * jumlah;
                    $('#total').val(total);
                });

                $('#jumlah').on('input', function () {
                    var harga_beli = $('#harga_beli').val();
                    var jumlah = $(this).val();
                    var total = harga_beli * jumlah;
                    $('#total').val(total);
                });
            });
        </script>
    </body>
</html>