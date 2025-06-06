<?php
session_start(); // Selalu mulai sesi

// Hancurkan semua variabel sesi
$_SESSION = array();

// Hapus cookie sesi jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan sesi
session_destroy();

// Arahkan pengguna kembali ke halaman login
// Ganti 'login.php' dengan path halaman login Anda jika berbeda
header('Location: login.php'); 
exit(); // Penting untuk menghentikan eksekusi skrip
?>