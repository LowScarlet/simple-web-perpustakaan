<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<script language="javascript">';
    echo 'alert("POST ONLY!")';
    echo '</script>';
    exit();
}
if (
    !isset($_POST['id']) or
    !isset($_POST['username']) or
    !isset($_POST['first_name']) or
    !isset($_POST['last_name']) or
    !isset($_POST['email']) or
    !isset($_POST['poin']) or
    !isset($_POST['perms'])
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

$target_table = "user";

$query = "UPDATE $target_table SET `username`='$_POST[username]',`first_name`='$_POST[first_name]',`last_name`='$_POST[last_name]',`email`='$_POST[email]',`poin`='$_POST[poin]',`izin`='$_POST[perms]' WHERE id=$_POST[id]";
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
