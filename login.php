<?php
// login.php
// Periksa apakah form telah disubmit (tombol login ditekan)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Di sini seharusnya ada proses validasi email dan password.
    // Karena belum ada implementasi database atau autentikasi,
    // kita akan langsung redirect ke dashboard.php.
    // Contoh data yang bisa diambil (jika diperlukan untuk validasi nanti):
    // $email = $_POST['email_login'] ?? '';
    // $password = $_POST['password_login'] ?? '';

    header("Location: dashboard.php");
    exit; // Pastikan tidak ada output lain setelah header redirect
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Login - Perpustakaan Nura</title>
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
    <div class="login">
        <div class="overlap-group-wrapper">
            <div class="overlap-group">
                <div class="rectangle"> 
                    
                    <div class="login-left-panel">
                        <img class="logo" src="img/logo.png" alt="Logo Perpustakaan Nura" />
                        <div class="group">
                            <p class="selamat-datang-login">Selamat Datang <br />Login Untuk Peminjaman Di Perpustakaan Nura</p>
                        </div>
                    </div>

                    <div class="login-right-panel">
                        <form class="form-register" method="POST" action="login.php"> 
                            <div class="input-field">
                                <label for="email_login" class="label">Email</label>
                                <input id="email_login" name="email_login" class="input" placeholder="library@gmail.com" type="email" required />
                            </div>

                            <div class="input-field">
                                <label for="password_login" class="text-wrapper">Password</label>
                                <div class="value-wrapper">
                                    <input id="password_login" name="password_login" class="value" placeholder="Masukkan Password dengan Benar" type="password" required />
                                </div>
                            </div>

                            <div class="checkbox-field">
                                <div class="div">
                                    <input type="checkbox" id="remember_me" name="remember_me" class="hidden-checkbox">
                                    <label for="remember_me" class="custom-checkbox-container">
                                        <span class="checkbox">
                                            <img class="check" src="img/check.svg" alt="checkbox icon" />
                                        </span>
                                        <span class="label-2">Remember me</span>
                                    </label>
                                </div>
                            </div>

                            <div class="button-group-wrapper">
                                <button type="submit" class="button">
                                    <span class="button-2">Login</span>
                                </button>
                            </div>
                        </form>
                        <p class="belum-punya-akun">
                            <span class="span">Belum Punya akun? </span>
                            <a href="registrasi.php" class="text-wrapper-2">Registrasi</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>