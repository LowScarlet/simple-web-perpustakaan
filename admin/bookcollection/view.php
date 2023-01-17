<?php
if (!isset($page)) {
    die();
}
$target_table = "book";

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
    $whitelist_search = array("judul", "penulis", "penerbit");
    if (in_array($search, $whitelist_search)) {
        $query = "SELECT * FROM $target_table WHERE $search LIKE '%$key%' LIMIT $paging,$maxdata";
        $data = mysqli_query($koneksi, $query);
    }
} else {
    $query = "SELECT * FROM $target_table LIMIT $paging,$maxdata";
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
                            <option value="judul" selected>Judul</option>
                            <option value="penulis">Penulis</option>
                            <option value="penerbit">Penerbit</option>
                        </select>
                        <input required name="key" type="text" class="form-control" aria-label="Text input with 2 dropdown buttons">
                        <button class="btn btn-success">🔎 Temukan!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="main" class="card mt-4">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">🙍 Judul</th>
                    <th scope="col">📝 Abstrak</th>
                    <th scope="col">📧 Penulis</th>
                    <th scope="col">⭐ Penerbit</th>
                    <th scope="col">🔐 Tahun</th>
                    <th scope="col">⚒️ Stok</th>
                    <th scope="col">⚒️ Pupularitas</th>
                    <th scope="col">⚒️ Mengelola</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data_number = 0;
                while ($r = mysqli_fetch_array($data)) {
                    $data_number++;
                    $buku_id = $r['id'];
                    $buku_judul = $r['judul'];
                    $buku_abstrak = $r['abstrak'];
                    $buku_penulis = $r['penulis'];
                    $buku_penerbit = $r['penerbit'];
                    $buku_tahun = $r['tahun'];
                    $buku_stok = $r['stok'];
                    $buku_popularitas = $r['popularitas'];
                ?>
                    <tr>
                        <th scope="row"><?php echo $data_number ?></th>
                        <td><?php echo serial_book_title($buku_judul) ?></td>
                        <td><?php echo $buku_abstrak ?></td>
                        <td><?php echo $buku_penulis ?></td>
                        <td><?php echo $buku_penerbit ?></td>
                        <td><?php echo $buku_tahun ?></td>
                        <td><?php echo $buku_stok ?></td>
                        <td><?php echo $buku_popularitas ?></td>
                        <td>
                            <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#modal_edit_<?php echo $buku_id ?>">⚙️ Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal_edit_<?php echo $buku_id ?>" tabindex="-1" aria-labelledby="modal_edit_<?php echo $buku_id ?>_label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modal_edit_<?php echo $buku_id ?>_label">
                                        <?php echo "Edit - $buku_judul" ?>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="<?php echo "delete_form_$buku_id" ?>" action="delete.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $buku_id ?>" />
                                        <input type="hidden" name="back_url" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
                                    </form>
                                    <form id="<?php echo "edit_form_$buku_id" ?>" action="edit.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $buku_id ?>" />
                                        <input type="hidden" name="back_url" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
                                        <div class="mb-3 row">
                                            <label for="input_edit_judul" class="col-sm-2 col-form-label">Judul</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" id="input_edit_judul" name="judul" value="<?php echo $buku_judul ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_abstrak" class="col-sm-2 col-form-label">Abstrak</label>
                                            <div class="col-sm-10">
                                                <textarea required class="form-control" id="input_edit_abstrak" rows="4" name="abstrak"><?php echo $buku_abstrak ?></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_penulis" class="col-sm-2 col-form-label">Penulis</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" id="input_edit_penulis" name="penulis" value="<?php echo $buku_penulis ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" id="input_edit_penerbit" name="penerbit" value="<?php echo $buku_penerbit ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_tahun" class="col-sm-2 col-form-label">Tahun</label>
                                            <div class="col-sm-10">
                                                <input type="number" required class="form-control" id="input_edit_tahun" name="tahun" value="<?php echo $buku_tahun ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_stok" class="col-sm-2 col-form-label">Stok</label>
                                            <div class="col-sm-10">
                                                <input type="number" required class="form-control" id="input_edit_stok" name="stok" value="<?php echo $buku_stok ?>">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" form="<?php echo "delete_form_$buku_id" ?>" class="btn btn-danger">Delete</button>
                                    <button type="submit" form="<?php echo "edit_form_$buku_id" ?>" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
        <button class="btn btn-success w-25" data-bs-toggle="modal" data-bs-target="#modal_create">⚒️ Add</button>
        <div class="modal fade" id="modal_create" tabindex="-1" aria-labelledby="modal_create_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal_create_label">
                            Create
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="create_form" action="create.php" method="post">
                            <input type="hidden" name="back_url" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
                            <div class="mb-3 row">
                                <label for="input_edit_judul" class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="input_edit_judul" name="judul">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_abstrak" class="col-sm-2 col-form-label">Abstrak</label>
                                <div class="col-sm-10">
                                    <textarea required class="form-control" id="input_edit_abstrak" name="abstrak" rows="4">
                                    </textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_penulis" class="col-sm-2 col-form-label">Penulis</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="input_edit_penulis" name="penulis">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="input_edit_penerbit" name="penerbit">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_tahun" class="col-sm-2 col-form-label">Tahun</label>
                                <div class="col-sm-10">
                                    <input type="number" required class="form-control" id="input_edit_tahun" name="tahun">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_stok" class="col-sm-2 col-form-label">Stok</label>
                                <div class="col-sm-10">
                                    <input type="number" required class="form-control" id="input_edit_stok" name="stok">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="create_form" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <?php if (mysqli_num_rows($data) == 0) { ?>
            <p class="text-center py-5">😖 Tidak ada data yang dapat ditampilkan! 😖</p>
        <?php } ?>
    </div>
</div>