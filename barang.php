<?php
// Misalkan ini adalah file data_barang.php

// Lakukan koneksi ke database Anda di sini

// Fungsi untuk mengambil data barang dari database
function getDataBarang() {
    // Lakukan query ke database untuk mengambil data barang
    // Contoh query:
    // $query = "SELECT * FROM nama_tabel";
    // Lakukan eksekusi query
    // Simpan hasil query ke dalam variabel $result

    // Contoh hasil query:
    $result = [
        ["id" => 1, "nama_barang" => "Originote", "stok" => 10, "harga_beli" => 40000, "harga_jual" => 43000],
        // Tambahkan data barang lainnya jika ada
    ];

    return $result;
}

// Fungsi untuk menghapus barang dari database
function hapusBarang($id) {
    // Lakukan query DELETE ke database untuk menghapus barang dengan ID tertentu
    // Contoh query:
    // $query = "DELETE FROM nama_tabel WHERE id = $id";
    // Lakukan eksekusi query DELETE

    // Contoh pesan sukses/hapus barang berhasil:
    echo "Barang berhasil dihapus dari database.";
}

// Fungsi untuk mengedit barang dari database
function editBarang($id, $nama_barang, $stok, $harga_beli, $harga_jual) {
    // Lakukan query UPDATE ke database untuk mengedit barang dengan ID tertentu
    // Contoh query:
    // $query = "UPDATE nama_tabel SET nama_barang='$nama_barang', stok=$stok, harga_beli=$harga_beli, harga_jual=$harga_jual WHERE id = $id";
    // Lakukan eksekusi query UPDATE

    // Contoh pesan sukses/edit barang berhasil:
    echo "Barang berhasil diedit di database.";
}

// Jika tombol Edit diklik
if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    editBarang($id, $nama_barang, $stok, $harga_beli, $harga_jual);
}

// Jika tombol Hapus diklik
if(isset($_POST['hapus'])) {
    $id = $_POST['id'];

    hapusBarang($id);
}

// Ambil data barang dari database
$data_barang = getDataBarang();
?>

<!-- Tampilkan tabel data barang -->
<div class="table-responsive">
    <table id="dataTable2" class="table text-center">
        <thead class="text-capitalize">
            <tr>
                <th>Id</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_barang as $barang): ?>
            <tr>
                <td><?php echo $barang['id']; ?></td>
                <td><?php echo $barang['nama_barang']; ?></td>
                <td><?php echo $barang['stok']; ?></td>
                <td><?php echo $barang['harga_beli']; ?></td>
                <td><?php echo $barang['harga_jual']; ?></td>
                <td>
                    <!-- Tombol edit -->
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $barang['id']; ?>">
                        <input type="hidden" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>">
                        <input type="hidden" name="stok" value="<?php echo $barang['stok']; ?>">
                        <input type="hidden" name="harga_beli" value="<?php echo $barang['harga_beli']; ?>">
                        <input type="hidden" name="harga_jual" value="<?php echo $barang['harga_jual']; ?>">
                        <button type="submit" name="edit" class="btn btn-primary btn-xs">Edit</button>
                    </form>
                    <!-- Tombol hapus -->
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $barang['id']; ?>">
                        <button type="submit" name="hapus" class="btn btn-danger btn-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
