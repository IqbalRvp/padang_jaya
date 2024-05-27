<?php
// Fungsi untuk menghasilkan ID otomatis
function generateIDBarang($koneksi) {

$query_run = "SELECT max(id_barang) as maxKode FROM data_barang";
$hasil = mysqli_query($koneksi, $query_run);
$data = mysqli_fetch_array($hasil);

$maxkode = $data['maxKode'];

$nourut = (int) substr($maxkode, 2, 3);

$nourut++;
$char = 'BR';
$kodejadi = $char . sprintf("%03s", $nourut);
echo $kodejadi;
}
?>