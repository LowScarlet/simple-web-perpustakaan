<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<script language="javascript">';
    echo 'alert("POST ONLY!")';
    echo '</script>';
    exit();
}
if (
    !isset($_POST['judul']) or
    !isset($_POST['abstrak']) or
    !isset($_POST['penulis']) or
    !isset($_POST['penerbit']) or
    !isset($_POST['tahun']) or
    !isset($_POST['stok'])
) {
    echo '<script language="javascript">';
    echo 'alert("INVALID DATA!")';
    if (!isset($_POST['back_url'])) {
        echo "window.location= $_POST[back_url]";
    }
    echo '</script>';
    exit();
}

require("../../component/db.php");

$target_table = "book";

$query = "INSERT INTO $target_table (`id`, `judul`, `abstrak`, `penulis`, `penerbit`, `tahun`, `stok`, `popularitas`, `total_jual`, `total_pinjam`) VALUES (NULL, '$_POST[judul]', '$_POST[abstrak]', '$_POST[penulis]', '$_POST[penerbit]', '$_POST[tahun]', '$_POST[stok]', '0', '0', '0')";
$data = mysqli_query($koneksi, $query);
if (!$data) {
    echo '<script language="javascript">';
    echo 'alert("THERE ANY ERROR AFTER EXECUTE THIS QUERY!")';
    echo '</script>';
}

if (isset($_POST['back_url'])) {
    echo '<script language="javascript">';
    echo 'window.location="' . $_POST['back_url'] . '"';
    echo '</script>';
}
