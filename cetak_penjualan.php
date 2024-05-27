<?php
// Include file koneksi
include 'koneksi.php';

// Load TCPDF library
require_once('tcpdf/tcpdf.php');

// Periksa apakah ID penjualan telah dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kode_penjualan'])) {
    // Ambil ID penjualan dari data yang dikirimkan
    $kode_penjualan = $_POST['kode_penjualan'];

    // Query untuk mengambil detail penjualan berdasarkan ID penjualan
    $query = "SELECT penjualan.kode_penjualan, data_barang.nama_barang, penjualan.jumlah, penjualan.harga_jual, penjualan.total, penjualan.tanggal FROM penjualan INNER JOIN data_barang ON penjualan.id_barang = data_barang.id_barang WHERE penjualan.kode_penjualan = '$kode_penjualan'";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah penjualan ditemukan berdasarkan ID yang diberikan
    if(mysqli_num_rows($result) > 0) {
        // Load TCPDF library
        require_once('tcpdf/tcpdf.php');

        // Extend TCPDF class to create custom class for PDF
        class Custom_PDF extends TCPDF {
            // Custom Footer
            public function Footer() {
                // Set footer content
                $this->SetY(-15);
                $this->SetFont('helvetica', 'I', 8);
                $this->Cell(0, 10, 'Halaman ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C');
            }
        }

        // Create new PDF instance
        $pdf = new Custom_PDF();

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Detail Penjualan');
        $pdf->SetSubject('Detail Penjualan');

        // Add a page
        $pdf->AddPage();

        // Loop through each row of data
        while($penjualan = mysqli_fetch_assoc($result)) {
            // Output detail penjualan dalam format yang sesuai untuk pencetakan
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, 'ID Penjualan: ' . $penjualan['kode_penjualan'], 0, 1);
            $pdf->Cell(0, 10, 'Nama Barang: ' . $penjualan['nama_barang'], 0, 1);
            $pdf->Cell(0, 10, 'Jumlah: ' . $penjualan['jumlah'], 0, 1);
            $pdf->Cell(0, 10, 'Harga Jual: ' . $penjualan['harga_jual'], 0, 1);
            $pdf->Cell(0, 10, 'Total: ' . $penjualan['total'], 0, 1);
            $pdf->Cell(0, 10, 'Tanggal Penjualan: ' . $penjualan['tanggal'], 0, 1);
            $pdf->Ln(); // Add a line break after each record
        }

        // Output PDF to browser
        $pdf->Output('Detail_Penjualan.pdf', 'D');
    } else {
        // Jika ID penjualan tidak ditemukan
        echo "Penjualan dengan kode $kode_penjualan tidak ditemukan.";
    }
} else {
    // Jika tidak ada data yang dikirimkan melalui metode POST
    echo "Metode tidak valid atau data tidak lengkap.";
}
?>