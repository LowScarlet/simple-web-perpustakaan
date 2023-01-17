<?php
require("db.php");
require("utils.php");

$appid = "perpustakaan2";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo "Perpustakaan - $title"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php 
        if (isset($admin_page)) {
        echo "../";
        }
    ?>../asset/main.css">
</head>

<body>
    <div class="px-lg-4" style="
        background-position: top;
        background-repeat: no-repeat;
        background-size: cover;
        background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), url('<?php 
            if (isset($admin_page)) {
            echo "../";
            }
        ?>../asset/doodle-science.png');
    ">
        <nav class="navbar navbar-expand-lg rounded" aria-label="Thirteenth navbar example">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
                    <a class="navbar-brand col-lg-3 me-0" href="<?php echo parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?>">📚 Perpustakaan</a>
                    <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == "bookcollection" and !isset($admin_page)) { ?>active<?php } ?>" aria-current="page" href="<?php echo "/" . $appid . "/bookcollection" ?>">Koleksi Buku</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == "racks" and !isset($admin_page)) { ?>active<?php } ?>" href="<?php echo "/" . $appid . "/racks" ?>">Daftar Rak</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == "users" and !isset($admin_page)) { ?>active<?php } ?>" href="<?php echo "/" . $appid . "/users" ?>">Para Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == "about" and !isset($admin_page)) { ?>active<?php } ?>" href="<?php echo "/" . $appid . "/about" ?>">Tentang</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Kontrol Admin</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo '/'.$appid.'/admin/bookcollection' ?>">Koleksi Buku</a></li>
                                <li><a class="dropdown-item disabled" href="<?php echo '/'.$appid.'/admin/racks' ?>">Daftar Rak</a></li>
                                <li><a class="dropdown-item" href="<?php echo '/'.$appid.'/admin/users' ?>">Pengguna</a></li>
                                <li><a class="dropdown-item disabled" href="<?php echo '/'.$appid.'/admin/selling' ?>">Penjualan</a></li>
                                <li><a class="dropdown-item disabled" href="<?php echo '/'.$appid.'/admin/lending' ?>">Peminjaman</a></li>
                                <li><a class="dropdown-item disabled" href="<?php echo '/'.$appid.'/admin/return' ?>">Pengembalian</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-lg-flex col-lg-3 justify-content-lg-end">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success m-1 dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                🖐️ Hello, LowScarlet!
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                <li><button class="dropdown-item" type="button">Logout</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <main class="pt-4 px-sm-5 bg-light">
        <?php include($childView); ?>
        <?php if (isset($no_page)) { ?>
            <div class="text-center">
                <a href="<?php echo parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?>" class="btn btn-outline-secondary m-2">🔃 Reload</a>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($no_page <= 1) { ?>disabled<?php } ?>">
                        <a class="page-link" href="<?php echo paging(1, $search, $key) ?>">First</a>
                    </li>
                    <?php if ($pre_page > 0) { ?>
                        <li class="page-item"><a class="page-link" href="<?php echo paging($pre_page, $search, $key) ?>"><?php echo $pre_page ?></a></li>
                    <?php } ?>
                    <li class="page-item active"><span class="page-link"><?php echo $no_page ?></span></li>
                    <li class="page-item"><a class="page-link" href="<?php echo paging($next_page, $search, $key) ?>"><?php echo $next_page ?></a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Last</a>
                    </li>
                </ul>
            </nav>
        <?php } ?>
    </main>
    <div class="px-5 py-4 default-bg">
        <div class="text-center">
            <span>Made with 💕 from <a href="http://lowscarlet.my.id/" target="_blank">Tegar Maulana Fahreza
                    (LowScarlet)</a></span>
        </div>
        <footer class="d-flex flex-wrap justify-content-between align-items-center pt-3">
            <p class="col-md-4 mb-0 text-muted">&copy; 2022 📚 Aplikasi Manajemen Perpustakaan</p>

            <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap" />
                </svg>
            </a>

            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item nav-link px-2">⚒️ Tools</li>
                <li class="nav-item"><a href="https://www.php.net/" target="_blank" class="nav-link px-2 text-muted">Php</a></li>
                <li class="nav-item"><a href="https://www.mysql.com/" target="_blank" class="nav-link px-2 text-muted">MySql</a></li>
                <li class="nav-item"><a href="https://getbootstrap.com/" target="_blank" class="nav-link px-2 text-muted">Bootstrap</a></li>
            </ul>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</html>