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

$selectedItemsData = []; // Initialize an empty array to store selected item data
$totalPrice = 0;

if (isset($_POST['lanjutkan'])) {
    $selectedItems = $_POST['selectedItems'];
    $selectedQuantities = $_POST['selectedQuantities'];
    $selectedName = $_POST['selectedName'];
    $selectedPrice = $_POST['selectedPrice'];
    $selectedId = $_POST['selectedId'];
    $totalPrice = $_POST['totalPrice'];

    if (!empty($selectedItems)) {
        // Loop through the selected items and use the data from the cart.
        foreach ($selectedItems as $key => $selectedItemId) {
            $itemDetails = [
                'produk_id' => $selectedItemId,
                'quantity' => $selectedQuantities[$key],
                'nama_brg' => $selectedName[$key],  // Use the correct key here
                'harga_brg' => $selectedPrice[$key],  // Use the correct key here
            ];
            $selectedItemsData[] = $itemDetails;
        }
    }
}


$user_id = $_SESSION['user_id'];

if (isset($_POST['beli'])) {
    $selectedProductIds = isset($_POST['selectedProductId']) ? $_POST['selectedProductId'] : [];
    $totalPrice = isset($_POST['total']) ? $_POST['total'] : 0; // Ambil total harga


    $success = true; 
    foreach ($selectedProductIds as $productId) {
        $updateQuery = "UPDATE keranjang SET status = 1 WHERE produk_id = ?";
        $stmt = $conn->prepare($updateQuery);

        if ($stmt) {
            $stmt->bind_param("i", $productId); 
            if (!$stmt->execute()) {
                $success = false; 
            }
        } else {
            // Handle kesalahan persiapan statement jika diperlukan
            echo "Error in preparing the statement: " . $conn->error;
        }
    }

    // Insert data into the "invoice" table for the purchased items.
    $insertQuery = "INSERT INTO invoice (id_user, total_harga) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);

    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $totalPrice); // "ii" menunjukkan bahwa parameter adalah integer
        if (!$stmt->execute()) {
            $success = false; // Jika ada kesalahan, atur keberhasilan ke false
        }
    } else {
        // Handle kesalahan persiapan statement jika diperlukan
        echo "Error in preparing the statement: " . $conn->error;
    }

    $conn->close();

    if ($success) {
        // Jika tidak ada kesalahan, tampilkan pesan sukses dan lakukan redirect
        echo "<script>
        alert('Pembelian berhasil');
        document.location.href='produk.php';
        </script>";
        exit();
    } else {
        // Jika ada kesalahan, tampilkan pesan kesalahan atau tangani kesalahan tersebut secara sesuai
        echo '<script>alert("Pembelian gagal. Terjadi kesalahan.");</script>';
        // Anda juga bisa mencatat kesalahan tersebut untuk tujuan debugging
    }
}


?>

<!-- Tampilan halaman checkout -->
<div class="container mt-5">
    <form action="" method="post">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Detail Pembayaran</h2>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($selectedItemsData)) : ?>
                            <ol>
                                <?php foreach ($selectedItemsData as $item) : ?>
                                    <li>
                                        <strong>Nama Barang:</strong> <?= isset($item['nama_brg']) ? $item['nama_brg'] : 'N/A' ?><br>
                                        <strong>Jumlah Barang:</strong> <?= isset($item['quantity']) ? $item['quantity'] : 'N/A' ?><br>
                                        <strong>Harga Barang:</strong> <?= isset($item['harga_brg']) ? formatRupiah($item['harga_brg']) : 'N/A' ?><br>
                                        <input type="hidden" name="selectedProductId[]" value=<?= $item['produk_id']?>>
                                    </li>
                                    <?php
                                        // Mengurangi stok barang sesuai dengan jumlah yang dibeli
                                        $productId = $item['produk_id'];
                                        $quantityToBuy = $item['quantity'];

                                        // Query untuk mengambil stok saat ini
                                        $stockQuery = "SELECT jml_brg FROM produk WHERE id_produk = ?";
                                        $stmt = $conn->prepare($stockQuery);

                                        if ($stmt) {
                                            $stmt->bind_param("i", $productId);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $product = $result->fetch_assoc();
                                            $currentStock = $product['jml_brg'];

                                            // Perbarui stok produk
                                            $newStock = $currentStock - $quantityToBuy;
                                            $updateStockQuery = "UPDATE produk SET jml_brg = ? WHERE id_produk = ?";
                                            $stmt = $conn->prepare($updateStockQuery);

                                            if ($stmt) {
                                                $stmt->bind_param("ii", $newStock, $productId);
                                                $stmt->execute();
                                            }
                                        }
                                    ?>
                                <?php endforeach; ?>
                            </ol>
                            <input type="hidden" name="id_user" value="<?= $_SESSION['user_id'] ?>">
                            <input type="hidden" name="total" value="<?= $totalPrice ?>">
                            

                            <p><strong class="text-center">Total Price:</strong> <?= formatRupiah($totalPrice) ?></p>
                            <div class="text-center">
                            <button type="submit" name="beli" class="btn btn-primary">Konfirmasi Pembayaran</button>
                        </div>
                        <?php else : ?>
                            <p>No items selected for checkout.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
include '../layout/footer.php';
?>
