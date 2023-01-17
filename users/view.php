<?php
if (!isset($page)) {
    die();
}
$target_table = "user";

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
    $whitelist_search = array("first_name", "last_name", "username");
    if (in_array($search, $whitelist_search)) {
        $query = "SELECT * FROM $target_table WHERE $search LIKE '%$key%' LIMIT $paging,$maxdata";
        $data = mysqli_query($koneksi, $query);
    }
} else {
    $query = "SELECT * FROM $target_table ORDER BY poin DESC LIMIT $paging,$maxdata";
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
                            <option value="first_name" selected>First Name</option>
                            <option value="last_name" selected>Last Name</option>
                            <option value="username">Username</option>
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
                    <th scope="col">🙍 Displayname</th>
                    <th scope="col">⭐ Poin</th>
                    <th scope="col">⚒️ Mengelola</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data_number = 0;
                while ($r = mysqli_fetch_array($data)) {
                    $data_number++;
                    $user_id = $r['id'];
                    $user_first_name = $r['first_name'];
                    $user_last_name = $r['last_name'];
                    $user_poin = $r['poin'];
                    $user_perms = $r['izin'];
                ?>
                    <tr>
                        <th scope="row"><?php echo $data_number ?></th>
                        <td><?php echo ($data_number < 4 ? "👑 " : "") . user_displayname($user_first_name, $user_last_name) . (user_is_admin($user_perms) ? " (Admin)" : "") ?></td>
                        <td><?php echo $user_poin ?></td>
                        <td>
                            <button class="btn btn-danger w-100" disabled>📢 Laporkan</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (mysqli_num_rows($data) == 0) { ?>
            <p class="text-center py-5">😖 Tidak ada data yang dapat ditampilkan! 😖</p>
        <?php } ?>
    </div>
</div>