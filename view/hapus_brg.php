<?php

include "../config/app.php";
session_start();
if(!isset($_SESSION["login"])){
    echo "<script>
    alert('Login untuk mengakses halaman');
    document.location.href = 'login.php'
    </script>";
    exit;
}

$id_produk = (int)$_GET['id_produk'];

if(delete($id_produk)>0){
    echo "<script>
        alert('Data Barang Berhasil Dihapus');
        document.location.href = 'produk.php'
        </script>";
} else {
    echo "<script>
        alert('Data Barang Gagal Dihapus');
        document.location.href = 'produk.php'
        </script>";
}