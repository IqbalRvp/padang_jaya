<?php
// Include file koneksi
include 'koneksi.php';

// Query untuk mengambil data penjualan
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
    $empty_message = "Tidak ada data penjualan.";
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
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
                                <a href="logout.php" aria-expanded="true"><i class="fa fa-lock"></i><span>Logout
                                    </span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Laporan Penjualan</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>Laporan Penjualan</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header area end -->

    <div class="container mt-5">
        <h2>Laporan Penjualan</h2>
        <?php if(isset($empty_message)) { ?>
            <div class="alert alert-info" role="alert">
                <?php echo $empty_message; ?>
            </div>
        <?php } else { ?>
            <a href="cetak_semua_penjualan.php" target="_blank" class="btn btn-success mb-3">Cetak Semua</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Penjualan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga_Jual</th>
                        <th>Total</th>
                        <th>Tanggal Penjualan</th>
                        <!-- <th>Aksi</th> Tambahkan kolom untuk tombol cetak -->
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
                            <!-- <td>
                                <form action="cetak_penjualan.php" method="post" target="_blank">
                                    <input type="hidden" name="kode_penjualan" value="<?php echo $penjualan['kode_penjualan']; ?>">
                                    <button type="submit" class="btn btn-primary">Cetak</button>
                                </form>
                            </td> -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
        </div>
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2024. All right reserved. Template by <a href="https://colorlib.com/wp/">Polije</a>.
                </p>
            </div>
        </footer>
        <!-- footer area end-->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>