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

if(delete_cart($id_produk)>0){
    echo "<script>
        alert('Data Barang Berhasil Dihapus');
        </script>";
} else {
    echo "<script>
        alert('Data Barang Gagal Dihapus');
        </script>";
}
header("Location: cart.php");
exit;
