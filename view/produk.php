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
    $data_barang = select("SELECT * FROM Produk");
}

if (isset($_POST['keranjang'])) {
    $id_produk = (int)$_POST['id_produk'];
    $id_user = $_POST['id_user'];
    $qty = (int)$_POST['qty'];

    if ($qty <= 0) {
        echo "<script>
            alert('Jumlah harus diisi!!');
            document.location.href = 'produk.php';
            </script>";
    } else {
        // Query untuk mengambil stok saat ini
        $stockQuery = "SELECT jml_brg FROM Produk WHERE id_produk = ?";
        $stmt = $conn->prepare($stockQuery);

        if ($stmt) {
            $stmt->bind_param("i", $id_produk);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $currentStock = $product['jml_brg'];

            if ($qty > $currentStock) {
                echo "<script>
                    alert('Jumlah tidak mencukupi. Stok hanya tersedia ' + $currentStock);
                    document.location.href = 'produk.php';
                </script>";
            } else {
                // Lanjutkan dengan penambahan ke keranjang jika jumlah mencukupi
                if (add_cart($id_user, $id_produk, $qty) > 0) {
                    echo "<script>
                        alert('Data Barang Berhasil Ditambahkan ke Keranjang');
                        document.location.href = 'produk.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Data Barang Gagal Ditambahkan ke Keranjang');
                        console.log('MySQL Error: " . mysqli_error($conn) . "');
                        document.location.href = 'produk.php';
                    </script>";
                }
            }
        }
    }
}


?>


<div class="container mt-5 pt-5">
    <h1>Produk</h1>
    <hr>
    <?php if ($_SESSION["level"] == 1) : ?>
        <a href="../view/tambah_brg.php" class="btn btn-success mt-3">Tambah</a>
        <table class="table table-striped table-bordered table-hover mt-2">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Spesifikasi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_barang as $produk) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $produk['nama_brg'] ?></td>
                        <td><?= $produk['jml_brg'] ?></td>
                        <td>
                        <?php
                            $deskripsi = truncateText($produk['deskripsi_brg'], 100);
                            echo $deskripsi;
                            ?>
                        </td>
                        <td><?php
                            $spesifikasi = truncateText($produk['spesifikasi_brg'], 100);
                            echo $spesifikasi;
                            ?>
                        </td>
                        <td><?= formatRupiah($produk['harga_brg']) ?></td>
                        <td>
                            <a href="../view/ubah_brg.php?id_produk=<?= $produk['id_produk'] ?>" class="btn btn-primary btn-sm">Ubah</a>
                            <a href="../view/hapus_brg.php?id_produk=<?= $produk['id_produk'] ?>" class="btn btn-danger btn-sm mr-2 mt-2">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif?>
    <?php if ($_SESSION["level"] == 2) : ?>
        <div class="d-flex flex-wrap">
            <?php $counter = 0; // Initialize a counter
            foreach ($data_barang as $produk) : ?>
            <form action="" method="post">
                <div class="card" style="width: 16rem; height : 33rem; margin: 10px;">
                    <img src="../assets/img/<?php echo $produk['foto_brg']; ?>" class="card-img-top size" alt="...">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $produk['nama_brg']; ?></h5>
                        <p class="card-text"><?= formatRupiah($produk['harga_brg']) ?></p>
                        <p class="card-text">Stock tersedia : <?=$produk['jml_brg'] ?></p>
                        <p class="card-text flex-grow-1">
                        <?php
                            $deskripsi = truncateText($produk['deskripsi_brg'], 100);
                            echo $deskripsi;
                        ?>
                        </p>
                        <div class="d-flex justify-content-between">
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" style="width: 100px;" name="qty" id="qty">
                                <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
                                <input type="hidden" name="id_user" value="<?php echo $user_id; ?>">
                            </div>
                        </div>
                        
                            <div class="d-flex">
                                <button type="submit" name="keranjang" class="btn btn-primary">
                                Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php endforeach; ?>
        </div>
    <?php endif?>

</div>

<?php
    include '../layout/footer.php';
?>
