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
    if (isset($_POST['tambah'])){
        if(insert($_POST)>0){
            echo "<script>
                alert('Data Barang Berhasil Ditambahkan');
                document.location.href = 'produk.php'
                </script>";
        }  else {
            echo "<script>
                alert('Data Barang Gagal Ditambahkan');
                document.location.href = 'produk.php'
                </script>";
        }
    }
?>
    <div class="container mt-5 pt-5">
        <h1 >
          Tambah Barang
        </h1>
        <hr>
       <!-- <form action="" method="post">
        <div class="mb-3">
                <label for="nama_brg" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_brg" placeholder="Nama barang..">
            </div>
            <div class="mb-3">
                <label for="jenis_brg" class="form-label">Jenis Barang</label>
                <input type="text" class="form-control" id="jenis_brg" placeholder="Jenis barang..">
            </div>
            <div class="mb-3">
                <label for="jml_brg" class="form-label">Jumlah Barang</label>
                <input type="text" class="form-control" id="jml_brg" placeholder="Jumlah..">
            </div>
            <div class="mb-3">
                <label for="ukuran_brg" class="form-label">Ukuran Barang</label>
                <input type="text" class="form-control" id="ukuran_brg" placeholder="Ukuran">
            </div>
            <div class="mb-3">
                <label for="harga_brg" class="form-label">Harga Barang</label>
                <input type="text" class="form-control" id="harga_brg" placeholder="Harga barang..">
            </div>
            <div class="mb-3">
                <label for="deskripsi_brg" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi_brg" rows="3"></textarea>
            </div>
            <button type="button" class="btn btn-primary" style="float: right;">Tambah</button>
       </form> -->
       <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="nama_brg" class="col-sm-3 col-form-label">Nama Barang</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="nama_brg" name="nama_brg" placeholder="Nama barang..">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="jml_brg" class="col-sm-3 col-form-label">Jumlah Barang</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control form-control-sm" id="jml_brg" name="jml_brg" placeholder="Jumlah..">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="harga_brg" class="col-sm-3 col-form-label">Harga Barang</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control form-control-sm" id="harga_brg" name="harga_brg" placeholder="Harga barang..">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="deskripsi_brg" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                    <textarea class="form-control form-control-sm" id="deskripsi_brg" name="deskripsi_brg" rows="3"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="spesifikasi_brg" class="col-sm-3 col-form-label">Spesifikasi</label>
                <div class="col-sm-9">
                    <textarea class="form-control form-control-sm" id="spesifikasi_brg" name="spesifikasi_brg" rows="3"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="foto_brg" class="col-sm-3 col-form-label">Foto Barang</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control form-control-sm" id="foto_brg" name="foto_brg" placeholder="Foto barang..">
                </div>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary float-end">Tambah</button>
        </form>

    </div>
<?php
    include '../layout/footer.php'
?>