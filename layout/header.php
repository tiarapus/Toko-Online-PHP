<?php
    include '../config/app.php';
    $data_barang = select("SELECT * FROM Produk ORDER BY id_produk DESC");
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $logged_in = isset($_SESSION['user_id']);
    $nama = $_SESSION['nama'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../app//assets/css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:wght@200&family=Ysabeau+Infant:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:ital,wght@0,100;1,100&family=Ysabeau+Infant:wght@300&display=swap" rel="stylesheet">
</head>
  <body>
  <div>
        <nav class="navbar color navbar-expand-lg fixed-top bg-primary"  >
            <div class="container">
                <a class="navbar-brand text-white" href="#">Toko Bangunan</a>
                <div class="collapse navbar-collapse mr-4" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 pr-4 mr-4 mb-lg-0">
                        <?php if ($logged_in) { // User is logged in ?>
                            <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == 2) : ?>
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page" href="../view/home.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page" href="../view/produk.php">Produk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page" href="../view/cart.php">Keranjang</a>
                                </li>
                            <?php endif?>
                            <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == 1) : ?>
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page" href="../view/produk.php">Produk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page" href="../view/pengiriman.php">Pengiriman</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page" href="../view/penjualan.php">Penjualan</a>
                                </li>
                            <?php endif?>

                            <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == 3) : ?>
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page" href="../view/penjadwalan.php">Penjadwalan</a>
                                </li>
                            <?php endif?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $nama ?>
                                </a>
                                <ul class="dropdown-menu" style="right: auto; left: -80px;">
                                    <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == 2) : ?>
                                        <li><a class="dropdown-item" href="../view/pesanan.php">Pesanan</a></li>
                                    <?php endif?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../view/logout.php">Logout</a></li>
                                </ul>
                            </li>
                        <?php } else { // User is not logged in ?>
                            <li class="nav-item">
                                <a class="nav-link active text-white" aria-current="page" href="../view/home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active text-white" aria-current="page" href="../view/produk.php">Produk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../view/login.php">Login</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>