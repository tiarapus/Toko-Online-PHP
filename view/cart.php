<?php
include '../layout/header.php';

session_start();
if (!isset($_SESSION["login"])) {
    echo "<script>
        alert('Login untuk mengakses halaman');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

$data_barang = select("SELECT p.*, k.jumlah AS jumlah_dalam_keranjang 
            FROM produk p
            INNER JOIN keranjang k ON p.id_produk = k.produk_id
            WHERE k.id_user = $user_id
            AND (k.status = 0 OR k.status = false)");




?>

<form id="checkout-form" action="checkout.php" method="post">
    <div class="container mt-3 pt-3 mb-5 pb-3">
        <h1>Keranjang</h1>
        <hr>
        <table class="table table-striped table-bordered table-hover mt-2">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Pilih</th>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_barang as $produk) : ?>
                    <tr>
                        <td>
                        <input type="checkbox" class="product-checkbox" name="selectedItems[]" value="<?= $produk['id_produk'] ?>"
                            data-price="<?= $produk['harga_brg'] ?>"
                            <?= $produk['jml_brg'] < $produk['jumlah_dalam_keranjang'] ? 'disabled' : '' ?>>
                            <input type="hidden" name="selectedQuantities[]" value="<?= $produk['jumlah_dalam_keranjang'] ?>">
                            <input type="hidden" name="selectedName[]" value="<?= $produk['nama_brg'] ?>">
                            <input type="hidden" name="selectedPrice[]" value="<?= $produk['harga_brg'] ?>">
                            <input type="hidden" name="selectedId[]" value="<?= $produk['id_produk'] ?>">
                        </td>
                        <td><?= $no++ ?></td>
                        <td><?= $produk['nama_brg'] ?></td>
                        <td><?= $produk['jumlah_dalam_keranjang'] ?></td>
                        <td class="price-cell"><?= formatRupiah($produk['harga_brg']) ?></td>
                        <td>
                            <img src="../assets/img/<?php echo $produk['foto_brg']; ?>" class="img-thumbnail" style="max-width: 180px; max-height: 120px;" alt="...">
                        </td>
                        <td>
                        <a href="../view/hapus_keranjang.php?id_produk=<?= $produk['id_produk'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="footer">
            <div class="row">
                <div class="col-6">
                    <div class="d-flex">
                        <h5 class="mr-5">Total Harga : </h5>
                        <h5 class="ml-2" id="total"> 0 </h5>
                    </div>
                </div>
                <div class="col-6 text-end">
                <button type="submit" name="lanjutkan" id="lanjutkan-button" class="btn btn-success">Lanjutkan</button>
                </div>
            </div>
        </div>
        <!-- Hidden input field to store the total price -->
        <input type="hidden" name="totalPrice" value="0">
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function formatRupiah(amount) {
        return 'Rp ' + amount.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }

    $(document).ready(function () {
        let totalPrice = 0;

        function updateTotalPrice() {
            $("#total").text(formatRupiah(totalPrice));
            // Update the hidden input field with the total price
            $("input[name='totalPrice']").val(totalPrice);
        }

        $(".product-checkbox").on("change", function () {
            totalPrice = 0; // Reset the total price
            $(".product-checkbox:checked").each(function () {
                const price = parseFloat($(this).data("price"));
                const quantity = parseFloat($(this).next().val());
                totalPrice += price * quantity;
            });
            updateTotalPrice();
            if ($(".product-checkbox:checked").length > 0) {
                $("#lanjutkan-button").prop("disabled", false);
            } else {
                $("#lanjutkan-button").prop("disabled", true);
            }
        });
    });

    
</script>

<?php
include '../layout/footer.php';
?>
