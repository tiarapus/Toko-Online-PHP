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
    
    $id_produk = (int)$_GET['id_produk'];
    $barang = select("SELECT * FROM produk WHERE id_produk = $id_produk")[0];
    
    if (isset($_POST['ubah'])){
        if(update($_POST)>0){
            echo "<script>
                alert('Data Barang Berhasil Diubah');
                document.location.href = 'produk.php'
                </script>";
        }  else {
            echo "<script>
                alert('Data Barang Gagal Diubah');
                document.location.href = 'produk.php'
                </script>";
        }
    }

?>
    <div class="container mt-5 pt-5">
        <h1 >
          Ubah Barang
        </h1>
        <hr>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_produk" value="<?=$barang['id_produk'];?>">
        <div class="mb-3 row">
            <label for="nama_brg" class="col-sm-3 col-form-label">Nama Barang</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="nama_brg" value="<?=$barang['nama_brg'];?>" name="nama_brg" placeholder="Nama barang..">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="jml_brg" class="col-sm-3 col-form-label">Jumlah Barang</label>
            <div class="col-sm-9">
                <input type="number" class="form-control form-control-sm" id="jml_brg" value="<?=$barang['jml_brg'];?>" name="jml_brg" placeholder="Jumlah..">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="harga_brg" class="col-sm-3 col-form-label">Harga Barang</label>
            <div class="col-sm-9">
                <input type="number" class="form-control form-control-sm" id="harga_brg" value="<?=$barang['harga_brg'];?>" name="harga_brg" placeholder="Harga barang..">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="deskripsi_brg" class="col-sm-3 col-form-label">Deskripsi</label>
            <div class="col-sm-9">
                <textarea class="form-control form-control-sm" id="deskripsi_brg" name="deskripsi_brg" rows="3"><?=$barang['deskripsi_brg'];?></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="spesifikasi_brg" class="col-sm-3 col-form-label">Spesifikasi</label>
            <div class="col-sm-9">
                <textarea class="form-control form-control-sm" id="spesifikasi_brg" name="spesifikasi_brg" rows="3"><?=$barang['spesifikasi_brg'];?></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="foto_brg" class="col-sm-3 col-form-label">Foto Barang</label>
            <div class="col-sm-9">
                <input type="file" class="form-control form-control-sm" id="foto_brg" name="foto_brg" placeholder="Nama barang..">
            </div>
        </div>
    <button type="submit" name="ubah" class="btn btn-primary float-end">Ubah</button>
</form>

    </div>
<?php
    include '../layout/footer.php'
?>