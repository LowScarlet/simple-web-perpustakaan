<?php
if (!isset($page)) {
    die();
}
$target_table = "rack";

$no_page = 1;

if (isset($_GET['page']) and (int)$_GET['page'] > 0) {
    $no_page = (int) $_GET['page'];
}

$pre_page = $no_page - 1;
$next_page = $no_page + 1;
$maxdata = 12;
$paging = ($no_page - 1) * $maxdata;

$search = null;
$key = null;

if (isset($_GET['search']) and isset($_GET['key'])) {
    $search = $_GET['search'];
    $key = $_GET['key'];
    $whitelist_search = array("nama", "lantai");
    if (in_array($search, $whitelist_search)) {
        $query = "SELECT * FROM $target_table WHERE $search LIKE '%$key%' LIMIT $paging,$maxdata";
        $data = mysqli_query($koneksi, $query);
    }
} else {
    $query = "SELECT * FROM $target_table ORDER BY nama DESC LIMIT $paging,$maxdata";
    $data = mysqli_query($koneksi, $query);
}
?>

<div class="card mt-3">
    <div class="card-body py-3 px-3">
        <div class="row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">🧐 Sedang cari apa?</label>
            <div class="col-sm-10">
                <form action="" method="get">
                    <div class="input-group">
                        <select name="search" class="form-select" aria-label="Default select example">
                            <option value="nama" selected>Nama</option>
                            <option value="lantai" selected>Lantai</option>
                        </select>
                        <input required name="key" type="text" class="form-control" aria-label="Text input with 2 dropdown buttons">
                        <button class="btn btn-success">🔎 Temukan!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">🔢 Nama</th>
                    <th scope="col">🗺️ Lantai</th>
                    <th scope="col">📖 Buku</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data_number = 0;
                while ($r = mysqli_fetch_array($data)) {
                    $data_number++;
                    $rack_id = $r['id'];
                    $rack_nama = $r['nama'];
                    $rack_lantai = $r['lantai'];
                    $rack_buku_id = $r['buku'];
                
                    $query_1 = "SELECT * FROM book WHERE id = $rack_buku_id";
                    $data_1 = mysqli_fetch_array(mysqli_query($koneksi, $query_1));
                ?>
                    <tr>
                        <th scope="row"><?php echo $data_number ?></th>
                        <td><?php echo $rack_nama ?></td>
                        <td><?php echo $rack_lantai ?></td>
                        <td><?php echo $data_1['judul'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (mysqli_num_rows($data) == 0) { ?>
            <p class="text-center py-5">😖 Tidak ada data yang dapat ditampilkan! 😖</p>
        <?php } ?>
    </div>
</div>