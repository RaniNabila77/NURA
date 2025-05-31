<?php
// Blok PHP untuk menangani pengiriman formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulir telah dikirim.
    // Mengarahkan pengguna kembali ke halaman yang sama untuk "menghilangkan" data.
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Registrasi</title>
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="css/registrasi.css" />
</head>
<body>
    <div class="registrasi">
        <div class="overlap-wrapper">
            <div class="overlap">
                <img class="logo" src="img/logo.png" alt="Logo Perpustakaan Nura" />
                <div class="overlap-group">
                    <div class="rectangle"></div>
                    <div class="selamat-datang-wrapper">
                        <p class="selamat-datang">Selamat Datang <br />Daftar Untuk Peminjaman Di Perpustakaan Nura</p>
                    </div>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="group">
                            <label for="nama_lengkap" class="text-wrapper">Nama</label>
                            <div class="div">
                                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" />
                            </div>
                        </div>

                        <div class="group-2">
                            <label for="email" class="text-wrapper-3">Email</label>
                            <div class="div">
                                <input type="email" id="email" name="email" placeholder="Email Aktif" />
                            </div>
                        </div>

                        <div class="group-3">
                            <label for="password" class="text-wrapper-3">Password</label>
                            <div class="div">
                                <input type="password" id="password" name="password" placeholder="Masukkan Password Minimal 6 Karakter" />
                            </div>
                        </div>

                        <div class="group-4">
                            <label for="konfirmasi_password" class="text-wrapper-6">Konfirmasi Password</label>
                            <div class="div-wrapper">
                                <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi Password yang Sama" />
                            </div>
                        </div>

                        <div class="group-5">
                            <div class="text-wrapper-7">Jenis Kelamin</div>
                            
                            <input type="radio" id="laki_laki" name="jenis_kelamin" value="laki-laki" class="custom-radio-input">
                            <label for="laki_laki" class="custom-radio-label-wrapper">
                                <span class="rectangle-2"></span>
                                <span class="text-wrapper-8">Laki-Laki</span>
                            </label>

                            <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" class="custom-radio-input">
                            <label for="perempuan" class="custom-radio-label-wrapper">
                                <span class="rectangle-3"></span>
                                <span class="text-wrapper-9">Perempuan</span>
                            </label>
                        </div>

                        <div class="group-6">
                            <label for="no_handphone" class="text-wrapper-7">No Handphone</label>
                            <div class="div">
                                <input type="tel" id="no_handphone" name="no_handphone" placeholder="No Handphone" />
                            </div>
                        </div>

                        <div class="group-7">
                            <label for="tanggal_lahir" class="text-wrapper-7">Tanggal Lahir</label>
                            <div class="overlap-2">
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" />
                                <img class="fontisto-date" src="img/fontisto-date.svg" alt="Kalender Ikon" />
                            </div>

                            <div class="overlap-3">
                                <button type="submit" class="submit-button">
                                    <span class="text-wrapper-12">Daftar</span>
                                </button>
                            </div>
                            
                            <p class="sudah-punya-akun-log">
                                <span class="span">Sudah Punya akun? </span>
                                <a href="login.php" class="text-wrapper-13">Log in</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>