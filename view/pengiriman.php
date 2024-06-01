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
    $data_invoice = select("SELECT i.*, u.nama
    FROM Invoice i
    JOIN user_table u ON i.id_user = u.user_id");
}

    if (isset($_POST['update_status'])){
        $invoice_id = $_POST['update_status'];

        $updateStatus = $conn->prepare("UPDATE Invoice SET status_kirim = 1 WHERE invoice_id = ?");
        $updateStatus->bind_param('i', $invoice_id); 

        if ($updateStatus->execute()) {
            echo "<script>
            alert('Barang dikirim');
            document.location.href = 'pengiriman.php'
            </script>";
        } else {
            echo "<script>
            alert('Error');
            document.location.href = 'pengiriman.php'
            </script>";
        }
    }


?>


<div class="container mt-5 pt-5">
    <h1>Pengiriman</h1>
    <hr>
        <form action="" method="post">
            <table class="table table-striped table-bordered table-hover mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Invoice Id</th>
                        <th scope="col">Nama Pelanggan</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status Pengiriman</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data_invoice as $inv) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $inv['invoice_id'] ?></td>
                            <td><?= $inv['nama'] ?></td>
                            <td><?=formatRupiah($inv['total_harga']) ?></td>
                            <td><?=$inv['tanggal'] ?></td>
                            <td>
                                <?php if ($inv['status_kirim'] == 0): ?>
                                    <p>belum dikirim</p>
                                <?php elseif ($inv['status_terima'] == 1): ?>
                                    <span class="text-success">selesai</span>
                                <?php else: ?>
                                    <p>dalam proses pengiriman</p>
                                <?php endif; ?>
                            </td>
                            <td>
                            <button type="submit" name="update_status" value="<?= $inv['invoice_id'] ?>" class="btn btn-primary btn-sm" <?= $inv['status_kirim'] == 1 ? 'disabled' : '' ?>>Kirim</button>
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
