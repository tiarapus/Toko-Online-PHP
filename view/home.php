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

<div class="home">
  <div class="container d-flex align-items-center" style="min-height: 100vh;">
    <div class="text-left">
      <p style="max-width: 500px; max-height: 100px; text-align:justify">
      Temukan koleksi terbaik pipa berkualitas tinggi di toko kami! Dengan berbagai jenis pipa pilihan, 
      kami siap membantu Anda memenuhi kebutuhan proyek Anda dengan produk terbaik.
      Jaminan kualitas dan harga yang kompetitif, kunjungi toko kami sekarang dan temukan solusi pipa terbaik untuk Anda!
      </p>
      <a href="#belanja" class="btn btn-primary" style="margin-top: 50px;">Mulai Belanja</a>
    </div>
  </div>
</div>
</div>
<div class="container mt-5 pt-5" id="belanja">
  <div class="d-flex flex-wrap justify-content-center">
    <?php $counter = 0; 
      foreach ($data_barang as $produk) : ?>
      <form action="" method="post">
        <?php if ($counter < 3) : ?>
          <div class="card" style="height : 33rem; width: 18rem; margin: 10px;">
            <img src="../assets/img/<?php echo $produk['foto_brg']; ?>" style="max-height:200px" class="card-img-top size" alt="...">
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
        <?php endif; // End if statement
        $counter++; // Increment the counter
        ?>
      </form>
      <?php endforeach; ?>
    </div>
    <div class="text-center" style="margin-top: 50px;">
      <a href="../view/produk.php" class="btn btn-primary">Selengkapnya</a>
    </div>
</div>

<?php
include '../layout/footer_component.php';
include '../layout/footer.php';
?>
