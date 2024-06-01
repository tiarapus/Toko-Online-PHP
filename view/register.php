<?php
include '../layout/header.php';


if (isset($_POST['tambah'])) {
    // Validate and sanitize user input
    $nama = strip_tags($_POST['nama']);
    $username = strip_tags($_POST['username']);

     if (isUsernameExists($username)) {
        // Username already exists, display an error message
        $error = 'Username tidak tersedia';
    } else {
        if (register($_POST) > 0) {
            echo "<script>
                alert('Akun berhasil dibuat!');
                document.location.href = 'login.php';
                </script>";
        } else {
            echo "<script>
                alert('Akun gagal dibuat.');
                document.location.href = 'register.php';
                </script>";
        }
    }
}
?>
<div class="container mt-3 pt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Daftar</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Nama Lengkap...">
                            </div>
                            
                            <div class="col">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" required name="username" placeholder="Username...">
                                <?php if (!empty($error)): ?>
                                    <small class="text-danger">
                                        <?php echo $error; ?>
                                    </small>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="no_tlp" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_tlp" required name="no_tlp" placeholder="No. Telepon...">
                            </div>
                            <div class="col">
                                <label for "email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" required name="email" placeholder="Email...">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" required name="password" placeholder="Password...">
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select required name="level" id="level" class="form-control">
                                <option value="">-- pilih --</option>
                                <option value="1.">Admin</option>
                                <option value="2.">Customer</option>
                                <option value="3.">Penyalur</option>
                            </select>
                        </div>
                        <button type="submit" name="tambah" class="btn btn-primary w-100">Daftar</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Sudah punya akun? <a href="../view/login.php">Masuk</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include '../layout/footer.php'
?>
