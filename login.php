<?php
session_start(); // Selalu mulai sesi di awal file PHP

$message = ""; // Variabel untuk menyimpan pesan error atau sukses
$message_type = ""; // 'error' atau 'info'

// --- Data Pengguna Dummy ---
// Dalam aplikasi nyata, data ini akan diambil dari database.
// Untuk tujuan demonstrasi dan mempertahankan desain, kita gunakan array ini.
// Key adalah email (sebagai username), value adalah array data pengguna.
$users = [
    'user@example.com' => [
        'password' => 'password123', // Password yang benar
        'user_id' => 'user123',      // ID unik pengguna
        'user_name' => 'Nura Aulia Fitri', // Nama lengkap pengguna
        'avatar' => 'img/default-profile.png', // Path avatar
    ],
    'admin@perpus.com' => [
        'password' => 'admin123',
        'user_id' => 'admin456',
        'user_name' => 'Admin Perpustakaan',
        'avatar' => 'img/admin-profile.png',
    ],
];

// Periksa apakah form telah disubmit (tombol login ditekan)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email_login'] ?? '';
    $password = $_POST['password_login'] ?? '';

    // Validasi sederhana: pastikan email dan password tidak kosong
    if (empty($email) || empty($password)) {
        $message = "Email dan password wajib diisi.";
        $message_type = "error";
    } elseif (isset($users[$email]) && $users[$email]['password'] === $password) {
        // --- LOGIN BERHASIL ---
        $_SESSION['user_id'] = $users[$email]['user_id'];
        $_SESSION['user_name'] = $users[$email]['user_name'];
        // Anda juga bisa menyimpan avatar atau data lain yang sering diakses di sesi
        $_SESSION['user_avatar'] = $users[$email]['avatar']; 

        // Cek apakah ada URL yang tersimpan untuk redirect setelah login
        if (isset($_SESSION['redirect_message_after_login'])) {
            $redirect_url = $_SESSION['redirect_message_after_login'];
            unset($_SESSION['redirect_message_after_login']); // Hapus URL redirect dari sesi
            header("Location: " . $redirect_url); // Redirect ke halaman yang diminta sebelumnya
            exit;
        } else {
            // Jika tidak ada URL redirect khusus, arahkan ke dashboard
            header("Location: dashboard.php");
            exit;
        }
    } else {
        // --- LOGIN GAGAL ---
        $message = "Email atau password salah.";
        $message_type = "error";
    }
}

// Cek apakah ada pesan informasi yang dikirim dari halaman lain (misalnya dari peminjaman.php)
$redirect_info_message = '';
if (isset($_SESSION['redirect_message'])) {
    $redirect_info_message = $_SESSION['redirect_message'];
    unset($_SESSION['redirect_message']); // Hapus pesan setelah ditampilkan
    $message_type = "info"; // Set tipe pesan menjadi info
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login">
        <div class="overlap-group-wrapper">
            <div class="overlap-group">
                <div class="rectangle"> 
                    
                    <div class="login-left-panel">
                        <img class="logo" src="img/Logo.png" alt="Logo Perpustakaan Nura" />
                        <div class="group">
                            <p class="selamat-datang-login">Selamat Datang <br />Login Untuk Peminjaman Di Perpustakaan Nura</p>
                        </div>
                    </div>

                    <div class="login-right-panel">
                        <form class="form-register" method="POST" action="login.php"> 
                            <?php if (!empty($message)): ?>
                                <div class="message <?php echo $message_type; ?>">
                                    <?php echo htmlspecialchars($message); ?>
                                </div>
                            <?php endif; ?>

                            <div class="input-field">
                                <label for="email_login" class="label">Email</label>
                                <input id="email_login" name="email_login" class="input" placeholder="library@gmail.com" type="email" required value="<?php echo htmlspecialchars($_POST['email_login'] ?? ''); ?>" />
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
