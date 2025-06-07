<?php
session_start();

// --- DATA PENGGUNA DUMMY (LANGSUNG DI SINI) ---
// Di aplikasi nyata, data ini akan diambil dari database setelah pengguna login.
$allUserData = [
    'user123' => [
        'id' => 'user123',
        'nama' => 'Nura', // Nama pendek untuk tampilan header dan kartu profil
        'nama_lengkap' => 'Nura Aulia Fitri',
        'email' => 'nura.fitri@gmail.com',
        'alamat' => 'Binuan Parami Bumi Indah',
        'telepon' => '0838-8764-3200',
        'tanggal_bergabung' => '01/01/2023',
        'avatar' => 'img/profile.png', // Pastikan path ini benar
        'nomor_register' => '12345677', // Tambahan data dari Figma
        'no_handphone' => '083887643200', // Sesuai figma
        'gender' => 'Perempuan', // Sesuai figma
        'tanggal_lahir' => '19/04/2000', // Sesuai figma
        'buku_dipinjam_count' => 5, // Jumlah buku yang sedang dipinjam
    ],
    // Anda bisa menambahkan pengguna lain di sini jika perlu untuk pengujian
];

// Cek apakah pengguna sudah login. Jika belum, redirect ke login.
$is_logged_in = true; // Untuk tujuan demonstrasi, kita anggap sudah login.
$current_user_id = 'user123';

if (!$is_logged_in || !isset($allUserData[$current_user_id])) {
    header("Location: login.php");
    exit;
}

$user = $allUserData[$current_user_id];

// Data dummy untuk buku yang sedang dipinjam (untuk section detail buku dipinjam jika ada)
$borrowedBooks = []; // Kosongkan sesuai Figma

// Mode edit (true/false)
$edit_mode = isset($_GET['edit']) && $_GET['edit'] == 'true';

// Tangani POST request jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update_profile') {
    // Di sini Anda akan memvalidasi dan menyimpan data ke database
    // Untuk contoh ini, kita update array dummy
    $user['nama_lengkap'] = htmlspecialchars($_POST['nama_lengkap']);
    $user['no_handphone'] = htmlspecialchars($_POST['no_handphone']);
    $user['gender'] = htmlspecialchars($_POST['gender']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['tanggal_lahir'] = htmlspecialchars($_POST['tanggal_lahir']);
    $user['alamat'] = htmlspecialchars($_POST['alamat']);

    // Jika ada upload avatar, tangani di sini
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'img/'; // Pastikan folder ini ada dan writable
        $fileName = basename($_FILES['profile_image']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Batasi jenis file (contoh: hanya gambar)
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
                $user['avatar'] = $targetFilePath;
            } else {
                error_log("Failed to move uploaded file: " . $_FILES['profile_image']['tmp_name'] . " to " . $targetFilePath);
            }
        } else {
            // Handle invalid file type
        }
    }
    
    // Setelah update, redirect kembali ke halaman profil (tanpa mode edit)
    header("Location: profile.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Profil <?php echo htmlspecialchars($user['nama']); ?> - Perpustakaan Nura</title>
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/profile.css" /> </head>
<body class="sidebar-open">
    <div class="app-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content-area">
           
               

            <main class="main-content">
                <div class="page-content-area">
                    <section class="profile-header-section">
                        <img class="profile-avatar-large" id="profile-avatar-display" src="<?php echo htmlspecialchars($user['avatar'] ?? 'img/default-profile.png'); ?>" alt="Foto Profil <?php echo htmlspecialchars($user['nama']); ?>" />
                        
                        <div class="profile-summary-text">
                            <h2><?php echo htmlspecialchars($user['nama']); ?></h2>
                            <p>Perpustakaan Nura</p>
                            <?php if (!$edit_mode): ?>
                                <a href="profile.php?edit=true" class="profile-edit-button-header">Edit Profile</a>
                            <?php else: ?>
                                <?php endif; ?>
                        </div>
                        
                        <div class="books-loaned-card">
                            <img src="img/book.png" alt="Icon Buku" />
                            <h3>Buku Terpinjam</h3>
                            <div class="count"><?php echo htmlspecialchars($user['buku_dipinjam_count']); ?></div>
                        </div>
                    </section>

                    <section class="profile-details-section">
                        <h3>Details</h3>
                        <?php if ($edit_mode): ?>
                            <form action="profile.php" method="POST" enctype="multipart/form-data" class="profile-details-grid edit-mode">
                                <input type="hidden" name="action" value="update_profile">
                                
                                <div class="detail-item">
                                    <label>Nomor Register</label>
                                    <input type="text" name="nomor_register" value="<?php echo htmlspecialchars($user['nomor_register']); ?>" readonly>
                                </div>
                                <div class="detail-item">
                                    <label>Profile Image</label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="profile_image" name="profile_image" accept="image/*">
                                        <label for="profile_image" class="custom-file-upload">Choose File</label>
                                        <span id="file-name"><?php echo htmlspecialchars(basename($user['avatar'])); ?></span>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <label>No. Handphone</label>
                                    <input type="text" name="no_handphone" value="<?php echo htmlspecialchars($user['no_handphone']); ?>">
                                </div>
                                <div class="detail-item">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>">
                                </div>
                                <div class="detail-item">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                                <div class="detail-item">
                                    <label>Gender</label>
                                    <select name="gender">
                                        <option value="Laki-laki" <?php echo ($user['gender'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?php echo ($user['gender'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="detail-item">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" value="<?php echo htmlspecialchars($user['alamat']); ?>">
                                </div>
                                <div class="detail-item">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($user['tanggal_lahir']))); ?>">
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="save-button">Simpan</button>
                                    <a href="profile.php" class="cancel-button">Batal</a>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="profile-details-grid">
                                <div class="detail-item">
                                    <label>Nomor Register</label>
                                    <span><?php echo htmlspecialchars($user['nomor_register']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Nama Lengkap</label>
                                    <span><?php echo htmlspecialchars($user['nama_lengkap']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>No. Handphone</label>
                                    <span><?php echo htmlspecialchars($user['no_handphone']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Gender</label>
                                    <span><?php echo htmlspecialchars($user['gender']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Email</label>
                                    <span><?php echo htmlspecialchars($user['email']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Tanggal Lahir</label>
                                    <span><?php echo htmlspecialchars($user['tanggal_lahir']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Alamat</label>
                                    <span><?php echo htmlspecialchars($user['alamat']); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </section>
        </div>
         <?php include 'footer.php'; ?>
    </div>
    <script src="js/sidebar-toggle.js"></script>

    <script>
        // Script untuk menampilkan nama file yang dipilih
        document.getElementById('profile_image').addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>
