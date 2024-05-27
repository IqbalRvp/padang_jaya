<?php
// Include file koneksi
include 'koneksi.php';

function generateIDbarang($koneksi) {
    $query = "SELECT max(id_barang) as maxKode FROM data_barang";
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

    $char = 'BR';
    $kodejadi = $char . sprintf("%04s", $nourut);
    return $kodejadi;
}

// Ambil ID barang baru
$id_barang_baru = generateIDbarang($koneksi);

// Inisialisasi variabel untuk menyimpan data dari form
$id_barang = $id_barang_baru;
$nama_barang = "";
$harga_beli = "";
$harga_jual = "";

// Periksa apakah form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form tambah, dengan pengecekan isset untuk menghindari notice
    $id_barang = isset($_POST['id_barang']) ? $_POST['id_barang'] : $id_barang_baru;
    $nama_barang = isset($_POST['nama_barang']) ? $_POST['nama_barang'] : "";
    $stok = isset($_POST['stok']) ? $_POST['stok'] : "";
    $harga_beli = isset($_POST['harga_beli']) ? $_POST['harga_beli'] : "";
    $harga_jual = isset($_POST['harga_jual']) ? $_POST['harga_jual'] : "";

    // Query untuk menambahkan data baru ke dalam tabel
    $query = "INSERT INTO data_barang (id_barang, nama_barang, stok, harga_beli, harga_jual) VALUES ('$id_barang', '$nama_barang', '$stok', '$harga_beli', '$harga_jual')";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Jika berhasil, kembalikan ke halaman data_barang.php
        header("Location: data_barang.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        $error_message = "Gagal menambahkan data barang: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Padang jaya</title>
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
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
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
                        <!-- <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div> -->
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Tambah Barang</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>Tambah Barang</span></li>
                            </ul>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <!-- <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <li class="settings-btn">
                                <i class="ti-settings"></i>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <!-- header area end -->

            <!-- page title area start -->
            <!-- <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>Data Barang</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">Upik <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Message</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- page title area end -->

            <div class="main-content-inner">
                <div class="row">
            <!-- Primary table start -->
    <div class="container mt-5">
        <h2>Tambah Barang</h2>
        <?php if(isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Id Barang</label>
                <input type="text" name="id_barang" class="form-control" value="<?php echo htmlspecialchars($id_barang); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Beli</label>
                <input type="text" name="harga_beli" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Barang</button>
            <a href="data_barang.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
                </div>
                <!-- row area start -->
                <div class="row">
            </div>
            <!-- row area end -->
            <!-- row area start-->
        </div>
        <!-- main content area end -->
            <!-- footer area start-->
            <footer>
            <div class="footer-area">
                <p>© Copyright 2024. All right reserved. Template by <a href="https://colorlib.com/wp/">Polije</a>.</p>
            </div>
        </footer>
        <!-- footer area end-->
    <!-- page container area end -->
    <!-- offset area start -->
    <!-- <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
        <ul class="nav offset-menu-tab">
            <li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>
            <li><a data-toggle="tab" href="#settings">Settings</a></li>
        </ul>
    </div> -->
    <!-- offset area end -->
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