<?php
    include '../layout/header.php';

    session_start();
    if(!isset($_SESSION["login"])){
        echo "<script>
        alert('Login untuk mengakses halaman');
        document.location.href = 'login.php'
        </script>";
        exit;
    }
  $user_id = $_SESSION['user_id'] ;


if ($_SESSION["level"] == 1) {
    // Inisialisasi $data_barang dengan data produk sesuai kebutuhan.
    $data_penjualan = select("SELECT p.nama_brg, p.harga_brg,k.jumlah
    FROM produk p
    JOIN keranjang k ON k.produk_id = p.id_produk
    WHERE k.status = 1
");
$totalHarga = 0;
        foreach ($data_penjualan as $sale) {
            $totalHarga += $sale['harga_brg'] * $sale['jumlah'];
        }

}


?>


<div class="container mt-5 pt-5">
    <h1>Penjualan</h1>
    <hr>
    <table class="table table-striped table-bordered table-hover mt-2">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Harga</th>
                <th scope="col">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_penjualan as $sale) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $sale['nama_brg'] ?></td>
                    <td><?= $sale['jumlah'] ?></td>
                    <td><?= formatRupiah($sale['harga_brg']) ?></td>
                    <td><?=formatRupiah($sale['harga_brg'] * $sale['jumlah']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="d-flex">
        <h5 class="mr-5">Total Penjualan : </h5>
        <h5 class="ml-2"><?= formatRupiah($totalHarga) ?> </h5>
    </div>
</div>

<?php
    include '../layout/footer.php';
?>
