<?php
    session_start();
    include '../layout/header.php';

    if (isset($_POST['login'])){
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            
            $res = mysqli_query($conn, "SELECT * FROM user_table WHERE username = '$username'");

            if (mysqli_num_rows($res) == 1) {
                $result = mysqli_fetch_assoc($res);
                if (password_verify($password, $result['password'])) {
                    $_SESSION['login'] = true;
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['nama'] = $result['nama'];
                    $_SESSION['username'] = $result['username'];
                    $_SESSION['no_telepon'] = $result['no_telepon'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['level'] = $result['level'];

                    if ($_SESSION["level"] == 1) {
                        header("Location: produk.php");
                        exit;
                    } elseif ($_SESSION["level"] == 2) {
                        header("Location: home.php");
                        exit;
                    } else {
                        header("Location: penjadwalan.php");
                        exit;
                    }
                }   
             
            }
            $error = true;
    }
?>
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Masuk</h4>
                </div>
                <?php if (isset($error)) : ?>
                    <div class="text-danger text-center pt-3 ">
                        <b>
                            Username/Password SALAH
                        </b>
                    </div>
                <?php endif;?>
                
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username...">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
                        </div>

                        <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Belum punya akun? <a href="../view/register.php">Daftar disini</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include '../layout/footer.php'
?>