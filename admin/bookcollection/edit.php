<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<script language="javascript">';
    echo 'alert("POST ONLY!")';
    echo '</script>';
    exit();
}
if (
    !isset($_POST['id']) or
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

$query = "UPDATE $target_table SET `judul`='$_POST[judul]',`abstrak`='$_POST[abstrak]',`penulis`='$_POST[penulis]',`penerbit`='$_POST[penerbit]',`tahun`='$_POST[tahun]',`stok`='$_POST[stok]' WHERE id=$_POST[id]";
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
