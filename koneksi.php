<?php
$koneksi = mysqli_connect("103.210.69.63","root","root","toskin");
if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}