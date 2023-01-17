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
    $query = "SELECT * FROM $target_table ORDER BY izin DESC LIMIT $paging,$maxdata";
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
                    <th scope="col">🙍 Username</th>
                    <th scope="col">📝 Displayname</th>
                    <th scope="col">📧 Email</th>
                    <th scope="col">⭐ Poin</th>
                    <th scope="col">🔐 Perms</th>
                    <th scope="col">⚒️ Mengelola</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data_number = 0;
                while ($r = mysqli_fetch_array($data)) {
                    $data_number++;
                    $user_id = $r['id'];
                    $user_username = $r['username'];
                    $user_email = $r['email'];
                    $user_first_name = $r['first_name'];
                    $user_last_name = $r['last_name'];
                    $user_poin = $r['poin'];
                    $user_perms = $r['izin'];
                ?>
                    <tr>
                        <th scope="row"><?php echo $data_number ?></th>
                        <td><?php echo $user_username ?></td>
                        <td><?php echo user_displayname($user_first_name, $user_last_name) ?></td>
                        <td><?php echo $user_email ?></td>
                        <td><?php echo $user_poin ?></td>
                        <td><?php echo $user_perms ?></td>
                        <td>
                            <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#modal_edit_<?php echo $user_id ?>">⚙️ Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal_edit_<?php echo $user_id ?>" tabindex="-1" aria-labelledby="modal_edit_<?php echo $user_id ?>_label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modal_edit_<?php echo $user_id ?>_label">
                                        <?php echo "Edit - $user_username" ?>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="<?php echo "delete_form_$user_id" ?>" action="delete.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $user_id ?>" />
                                        <input type="hidden" name="back_url" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
                                    </form>
                                    <form id="<?php echo "edit_form_$user_id" ?>" action="edit.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $user_id ?>" />
                                        <input type="hidden" name="back_url" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
                                        <div class="mb-3 row">
                                            <label for="input_edit_username" class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-10">
                                                <input readonly type="text" required class="form-control" id="input_edit_username" name="username" value="<?php echo $user_username ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_firstname" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" id="input_edit_firstname" name="first_name" value="<?php echo $user_first_name ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_lastname" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" id="input_edit_lastname" name="last_name" value="<?php echo $user_last_name ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input readonly type="email" required class="form-control" id="input_edit_email" name="email" value="<?php echo $user_email ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_point" class="col-sm-2 col-form-label">Point</label>
                                            <div class="col-sm-10">
                                                <input type="number" required class="form-control" id="input_edit_point" name="poin" value="<?php echo $user_poin ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="input_edit_perms" class="col-sm-2 col-form-label">Perms</label>
                                            <div class="col-sm-10">
                                                <input type="number" required class="form-control" id="input_edit_perms" name="perms" value="<?php echo $user_perms ?>">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" form="<?php echo "delete_form_$user_id" ?>" class="btn btn-danger">Delete</button>
                                    <button type="submit" form="<?php echo "edit_form_$user_id" ?>" class="btn btn-primary">Save changes</button>
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
                                <label for="input_edit_username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="input_edit_username" name="username">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_firstname" class="col-sm-2 col-form-label">First Name</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="input_edit_firstname" name="first_name">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_lastname" class="col-sm-2 col-form-label">Last Name</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="input_edit_lastname" name="last_name">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" required class="form-control" id="input_edit_email" name="email">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" required class="form-control" id="input_edit_password" name="password">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_point" class="col-sm-2 col-form-label">Point</label>
                                <div class="col-sm-10">
                                    <input type="number" required class="form-control" id="input_edit_point" name="poin">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_edit_perms" class="col-sm-2 col-form-label">Perms</label>
                                <div class="col-sm-10">
                                    <input type="number" required class="form-control" id="input_edit_perms" name="perms">
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