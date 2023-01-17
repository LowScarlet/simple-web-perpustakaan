<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<script language="javascript">';
    echo 'alert("POST ONLY!")';
    echo '</script>';
    exit();
}
if (!isset($_POST['id'])) {
    echo '<script language="javascript">';
    echo 'alert("WHERE THE ID!")';
    if (!isset($_POST['back_url'])) {
        echo "window.location= $_POST[back_url]";
    }
    echo '</script>';
    exit();
}

require("../../component/db.php");

$target_table = "book";

$query = "DELETE FROM $target_table WHERE id=$_POST[id]";
$data = mysqli_query($koneksi, $query);

if (isset($_POST['back_url'])) {
    echo '<script language="javascript">';
    echo 'window.location="'.$_POST['back_url'].'"';
    echo '</script>';
}