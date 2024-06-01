<?php

function select($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
return $rows;
}

function insert($post){
    global $conn;
    $nama = $post['nama_brg'];
    $desc = $post['deskripsi_brg'];
    $spec = $post['spesifikasi_brg'];
    $harga = $post['harga_brg'];
    $jumlah = $post['jml_brg'];
    $foto = upload_file();

    
    $query = "INSERT INTO Produk 
              VALUES (null, '$nama', $harga, $jumlah, '$desc',  '$spec', CURRENT_TIMESTAMP(),'$foto')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function update($post){
    global $conn;
    $id_produk = $post['id_produk'];

    $nama = $post['nama_brg'];
    $desc = $post['deskripsi_brg'];
    $spec = $post['spesifikasi_brg'];
    $harga = $post['harga_brg'];
    $jumlah = $post['jml_brg'];
    $foto = upload_file();

    
    $query = "UPDATE PRODUK SET nama_brg = '$nama', jml_brg =' $jumlah', harga_brg = '$harga', deskripsi_brg = '$desc', spesifikasi_brg = '$spec', foto_brg = '$foto' WHERE id_produk = $id_produk";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete($id_produk){
    global $conn;

    $query = "DELETE FROM produk WHERE id_produk = '$id_produk'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

function upload_file(){
    $nama_file = $_FILES['foto_brg']['name'];
    $ukuran_file = $_FILES['foto_brg']['size'];
    $error = $_FILES['foto_brg']['error'];
    $tmp_name = $_FILES['foto_brg']['tmp_name'];

    $extensiValid = ['jpg','jpeg','png'];
    $extensiFile = explode('.', $nama_file);
    $extensiFile = strtolower(end($extensiFile));

    if(!in_array($extensiFile, $extensiValid)){
        echo "<script>
            alert('Format file tidak valid!');
            document.location.href = 'tambah_brg.php';
            </script>";
        die();
    }

    if($ukuran_file > 204800){
        echo "<script>
            alert('Ukuran file terlalu besar (Max 2MB)!');
            document.location.href = 'tambah_brg.php';
            </script>";
        die();
    }

    $namaFileBaru = uniqid() . '.' . $extensiFile;
    $uploadDirectory = '../../app/assets/img/' . $namaFileBaru;

    if (move_uploaded_file($tmp_name, $uploadDirectory)) {
        return $namaFileBaru;
    } else {
        echo "<script>
            alert('Upload file gagal. Cek konfigurasi folder dan izin file.');
            document.location.href = 'tambah_brg.php';
            </script>";
        die();
    }
}

function register($post){
    global $conn;

    $nama = strip_tags($post['nama']);
    $username = strip_tags($post['username']);
    $no_tlp = strip_tags($post['no_telpon']);
    $email = strip_tags($post['email']);
    $password = strip_tags($post['password']);
    $password = password_hash($password,PASSWORD_DEFAULT);
    $level = strip_tags($post['level']);
 

    
    $query = "INSERT INTO user_table 
              VALUES (null, '$nama', '$username', '$no_tlp', '$email',  '$password','$level', CURRENT_TIMESTAMP())";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function isUsernameExists($username) {
    global $conn;
    $query = "SELECT COUNT(*) FROM user_table WHERE LOWER(username) = LOWER(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $count > 0;
}


function add_cart($id_user, $id_produk, $qty) {
    global $conn;

    $query = "INSERT INTO keranjang (id_user, produk_id, jumlah) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $id_user, $id_produk, $qty);

    if (mysqli_stmt_execute($stmt)) {
        return mysqli_affected_rows($conn);
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}

function add_invoice($id_user, $totalprice) {
    global $conn;

    $query = "INSERT INTO invoice (id_user, total_harga, tanggal) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $id_user, $totalprice);

    if (mysqli_stmt_execute($stmt)) {
        // The insert was successful.
        return mysqli_affected_rows($conn);
    } else {
        // Handle the error if the insert fails.
        die("Insert failed: " . mysqli_error($conn));
    }
}

function run_query($query) {
    global $conn;
    mysqli_query($conn, $query);
}
function delete_cart($id_produk){
    global $conn;

    $query = "DELETE FROM keranjang WHERE produk_id = '$id_produk'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}





