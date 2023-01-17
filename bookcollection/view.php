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
$maxdata = 6;
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

$query_1 = "SELECT * FROM $target_table ORDER BY popularitas DESC LIMIT 1;";
$data_1 = mysqli_fetch_array(mysqli_query($koneksi, $query_1));

$query_2 = "SELECT first_name, last_name, poin FROM user ORDER BY poin DESC LIMIT 3;";
$data_2 = mysqli_query($koneksi, $query_2);
?>

<div class="row">
    <div class="col-lg-6 mb-1 mb-lg-0">
        <div class="card mb-3 h-100">
            <?php
            $populer_id = $data_1['id'];
            $populer_judul = $data_1['judul'];
            $populer_abstrak = $data_1['abstrak'];
            $populer_stok = $data_1['stok'];
            $populer_popularitas = $data_1['popularitas'];
            ?>
            <div class="row">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-header bg-transparent">😍 Si paling populer!</div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo "📘 $populer_judul" ?></h5>
                        <p class="card-text"><?php echo "Abstrak - " . serial_abstrak($populer_abstrak) ?></p>
                        <p class="card-text"><small class="text-muted"><?php echo "❔ Memiliki ⭐ $populer_popularitas" ?></small></p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <?php
                                if ((int)$populer_stok > 0) {
                                    echo "📚 Tersedia $populer_stok Buku!";
                                } else {
                                    echo "❌ Stok buku habis!";
                                }
                                ?>
                            </li>
                        </ul>
                        <a href="<?php echo $populer_id ?>" class="btn btn-primary stretched-link mx-2 w-100">📖 Lihat
                            buku!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-3 h-100">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">👥 Para Raja Buku!</h5>
                        <p class="card-text">Daftar para peringkat atas berdasarkan poin!.</p>
                        <ul class="list-group list-group-flush">
                            <?php
                            while ($r = mysqli_fetch_array($data_2)) {
                                $raja_first_name = $r['first_name'];
                                $raja_last_name = $r['last_name'];
                                $raja_poin = $r['poin'];
                            ?>
                                <li class="list-group-item"><?php echo "👑 " . user_displayname($raja_first_name, $raja_last_name) . " - $raja_poin" ?></li>
                            <?php } ?>
                        </ul>
                        <p class="card-text"><small class="text-muted">❔ Para peringkat atas diperbaharui secara
                                live!</small></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
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

<div id="main" class="pt-4 pb-2">
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        <?php
        while ($r = mysqli_fetch_array($data)) {
            $id = $r['id'];
            $judul = $r['judul'];
            $abstrak = $r['abstrak'];
            $penulis = $r['penulis'];
            $penerbit = $r['penerbit'];
            $tahun = $r['tahun'];
            $stok = $r['stok'];
            $popularitas = $r['popularitas'];
        ?>
            <div class="col">
                <div class="card h-100">
                    <img src="../asset/default.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo "📘 $judul" ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo "⭐ $popularitas" ?></h6>
                        <p class="card-text"><?php echo serial_abstrak($abstrak) ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <?php
                                if ((int)$stok > 0) {
                                    echo "📚 Tersedia $stok Buku!";
                                } else {
                                    echo "❌ Stok buku habis!";
                                }
                                ?>
                            </li>
                        </ul>
                        <div>
                            <a href="<?php echo "show/?id=".$id ?>" target="_blank" class="btn btn-outline-primary stretched-link mx-2 mb-2 w-100">📖 Lihat
                                buku!</a>
                        </div>
                        <small class="text-muted"><?php echo "📝 Oleh $penulis - $tahun" ?></small>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php if (mysqli_num_rows($data) == 0) { ?>
        <p class="text-center py-5">😖 Tidak ada data yang dapat ditampilkan! 😖</p>
    <?php } ?>
</div>