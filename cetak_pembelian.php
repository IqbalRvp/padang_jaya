<?php
// Include file koneksi
include 'koneksi.php';

// Load TCPDF library
require_once('tcpdf/tcpdf.php');

// Periksa apakah ID pembelian telah dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kode_pembelian'])) {
    // Ambil ID pembelian dari data yang dikirimkan
    $kode_pembelian = $_POST['kode_pembelian'];

    // Query untuk mengambil detail pembelian berdasarkan ID pembelian
    $query = "SELECT pembelian.kode_pembelian, data_barang.nama_barang, pembelian.jumlah, pembelian.harga_beli, pembelian.total, pembelian.tanggal FROM pembelian INNER JOIN data_barang ON pembelian.id_barang = data_barang.id_barang WHERE pembelian.kode_pembelian = '$kode_pembelian'";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah pembelian ditemukan berdasarkan ID yang diberikan
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
        $pdf->SetTitle('Detail Pembelian');
        $pdf->SetSubject('Detail Pembelian');

        // Add a page
        $pdf->AddPage();

        // Loop through each row of data
        while($pembelian = mysqli_fetch_assoc($result)) {
            // Output detail pembelian dalam format yang sesuai untuk pencetakan
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, 'ID Pembelian: ' . $pembelian['kode_pembelian'], 0, 1);
            $pdf->Cell(0, 10, 'Nama Barang: ' . $pembelian['nama_barang'], 0, 1);
            $pdf->Cell(0, 10, 'Jumlah: ' . $pembelian['jumlah'], 0, 1);
            $pdf->Cell(0, 10, 'Harga Beli: ' . $pembelian['harga_beli'], 0, 1);
            $pdf->Cell(0, 10, 'Total: ' . $pembelian['total'], 0, 1);
            $pdf->Cell(0, 10, 'Tanggal Pembelian: ' . $pembelian['tanggal'], 0, 1);
            $pdf->Ln(); // Add a line break after each record
        }

        // Output PDF to browser
        $pdf->Output('Detail_Pembelian.pdf', 'D');
    } else {
        // Jika ID pembelian tidak ditemukan
        echo "Pembelian dengan kode $kode_pembelian tidak ditemukan.";
    }
} else {
    // Jika tidak ada data yang dikirimkan melalui metode POST
    echo "Metode tidak valid atau data tidak lengkap.";
}
?>