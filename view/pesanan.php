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


if ($_SESSION["level"] == 2) {
    // Inisialisasi $data_barang dengan data produk sesuai kebutuhan.
    $data_invoice = select("SELECT i.*, u.nama
    FROM Invoice i
    JOIN user_table u ON i.id_user = u.user_id where u.user_id = $user_id");
}


?>


<div class="container mt-5 pt-5">
    <h1>Pemesanan</h1>
    <hr>
        <form action="" method="post">
            <table class="table table-striped table-bordered table-hover mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Invoice Id</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal Invoice</th>
                        <th scope="col">Tanggal Terima</th>
                        <th scope="col">Status Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data_invoice as $inv) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $inv['invoice_id'] ?></td>
                            <td><?=formatRupiah($inv['total_harga']) ?></td>
                            <td><?=$inv['tanggal'] ?></td>
                            <td><?=$inv['tanggal_terima'] ?></td>
                            <td>
                                <?php if ($inv['status_kirim'] == 0): ?>
                                    <p>belum dikirim</p>
                                <?php elseif ($inv['status_terima'] == 1): ?>
                                    <span class="text-success">selesai</span>
                                <?php else: ?>
                                    <p>dalam proses pengiriman</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </form>
</div>

<?php
    include '../layout/footer.php';
?>
