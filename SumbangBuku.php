<?php
session_start();

// --- DATA PENGGUNA DUMMY (Opsional: Bisa dipisah ke data_pengguna.php jika ada) ---
// ... (Bagian ini tidak berubah dari kode sebelumnya) ...
$allUserData = [
    'user123' => [
        'id' => 'user123',
        'nama' => 'Nura', // Nama pendek untuk tampilan header dan kartu profil
        'nama_lengkap' => 'Nura Aulia Fitri',
        'email' => 'nura.fitri@gmail.com',
        'alamat' => 'Binuan Parami Bumi Indah',
        'telepon' => '0838-8764-3200',
        'tanggal_bergabung' => '01/01/2023',
        'avatar' => 'img/default-profile.png', // Pastikan path ini benar
        'nomor_register' => '12345677', // Tambahan data dari Figma
        'no_handphone' => '083887643200', // Sesuai figma
        'gender' => 'Perempuan', // Sesuai figma
        'tanggal_lahir' => '19/04/2000', // Sesuai figma
        'buku_dipinjam_count' => 5, // Jumlah buku yang sedang dipinjam
    ],
    // Anda bisa menambahkan pengguna lain di sini jika perlu untuk pengujian
];

$is_logged_in = true; // Ganti dengan logika status login Anda, e.g., isset($_SESSION['user_id'])
$current_user_id = 'user123'; // Ganti dengan ID pengguna dari sesi yang login

$user_avatar = 'img/profile.png'; // Default avatar
if ($is_logged_in && isset($allUserData[$current_user_id]['avatar'])) {
    $user_avatar = $allUserData[$current_user_id]['avatar'];
}

$message = '';
$message_type = ''; // 'success' atau 'error'

// Default: Tampilkan form. Sembunyikan pesan sukses.
$show_form = true;

// Logika untuk menangani form submission (unggah buku)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_book'])) {
    $nama_buku = trim($_POST['nama_buku'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $penerbit = trim($_POST['penerbit'] ?? '');
    $jenis_buku = trim($_POST['jenis_buku'] ?? '');
    $rating = (int)($_POST['rating_value'] ?? 0); // Ambil rating dari input hidden
    $detail_buku = trim($_POST['detail_buku'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');

    // Validasi input sederhana
    if (empty($nama_buku) || empty($penulis) || empty($penerbit) || empty($jenis_buku) || empty($detail_buku)) {
        $message = "Nama Buku, Penulis, Penerbit, Jenis Buku, dan Detail Buku wajib diisi.";
        $message_type = 'error';
    } elseif ($rating < 1 || $rating > 5) {
        $message = "Harap berikan rating bintang (1-5).";
        $message_type = 'error';
    } else {
        // --- LOGIKA UNGGAH GAMBAR BUKU ---
        $gambar_buku_path = 'img/book-covers/default_book.jpg'; // Path default jika upload gagal
        if (isset($_FILES['gambar_buku']) && $_FILES['gambar_buku']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "img/book-covers/";
            // Pastikan direktori ada dan writable (izin 0755 atau 0777 untuk development)
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $file_extension = strtolower(pathinfo($_FILES["gambar_buku"]["name"], PATHINFO_EXTENSION));
            $new_file_name = uniqid('book_') . '.' . $file_extension; // Nama unik untuk file
            $target_file = $target_dir . $new_file_name;
            $uploadOk = 1;

            // Periksa apakah file adalah gambar asli
            $check = getimagesize($_FILES["gambar_buku"]["tmp_name"]);
            if($check === false) {
                $message .= " File yang diunggah bukan gambar.";
                $message_type = 'error';
                $uploadOk = 0;
            }

            // Periksa ukuran file (max 5MB)
            if ($_FILES["gambar_buku"]["size"] > 5000000) {
                $message .= " Ukuran gambar terlalu besar (maks 5MB).";
                $message_type = 'error';
                $uploadOk = 0;
            }

            // Izinkan format file tertentu
            if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif" ) {
                $message .= " Hanya JPG, JPEG, PNG & GIF yang diizinkan.";
                $message_type = 'error';
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["gambar_buku"]["tmp_name"], $target_file)) {
                    $gambar_buku_path = $target_file;
                } else {
                    $message .= " Gagal mengunggah gambar buku. Pastikan folder 'img/book-covers/' ada dan memiliki izin tulis.";
                    $message_type = 'error';
                }
            }
        } else {
             $message .= " Gambar buku wajib diunggah.";
             $message_type = 'error';
        }

        // Jika tidak ada error upload dan validasi input lain, simpan data
        if (empty($message)) {
            $message = "TERIMA KASIH TELAH MENYUMBANG BUKU '{$nama_buku}'!";
            $message_type = 'success';
            $show_form = false; // Sembunyikan form, tampilkan pesan sukses
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Sumbang Buku - Perpustakaan Nura</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/sumbangbuku.css" />
</head>
<body class="sidebar-open">
    <div class="app-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content-area">
            <header class="main-header">
                <?php
                if ($is_logged_in) {
                    echo '<a href="profile.php" class="profile-button-header-round" title="Lihat Profil">';
                    echo '   <img src="' . htmlspecialchars($user_avatar) . '" alt="Profil">';
                    echo '</a>';
                } else {
                    echo '<div class="header-buttons">';
                    echo '   <a href="login.php" class="header-button login-button">Login</a>';
                    echo '   <a href="register.php" class="header-button register-button">Register</a>';
                    echo '</div>';
                }
                ?>
            </header>

            <main class="main-content">
                <div class="page-content-area">
                    <div class="sumbang-buku-main-container">
                        <section class="sumbang-buku-form-section" style="<?php echo $show_form ? 'display: flex;' : 'display: none;'; ?>">
                            <h1 class="form-title">Sumbang Buku</h1>

                            <?php if (!empty($message) && $message_type === 'error'): ?>
                                <p class="form-feedback <?php echo $message_type; ?>">
                                    <?php echo $message; ?>
                                </p>
                            <?php endif; ?>

                            <form id="sumbangForm" action="sumbangbuku.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nama_buku">Nama Buku</label>
                                    <input type="text" id="nama_buku" name="nama_buku" placeholder="Masukkan nama buku" required value="<?php echo htmlspecialchars($_POST['nama_buku'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="penulis">Penulis Buku</label>
                                    <input type="text" id="penulis" name="penulis" placeholder="Masukkan nama penulis" required value="<?php echo htmlspecialchars($_POST['penulis'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="penerbit">Penerbit</label>
                                    <input type="text" id="penerbit" name="penerbit" placeholder="Masukkan nama penerbit" required value="<?php echo htmlspecialchars($_POST['penerbit'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_buku">Jenis Buku</label>
                                    <input type="text" id="jenis_buku" name="jenis_buku" placeholder="Contoh: Fiksi, Non-fiksi" required value="<?php echo htmlspecialchars($_POST['jenis_buku'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="rating-input">Rating</label>
                                    <div class="rating-input-group" id="rating-input">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <img class="star-input" src="img/image.svg" alt="Beri <?php echo $i; ?> bintang" data-value="<?php echo $i; ?>" />
                                        <?php endfor; ?>
                                        <input type="hidden" name="rating_value" id="rating_value" value="<?php echo htmlspecialchars($_POST['rating_value'] ?? 0); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <input type="text" id="kategori" name="kategori" placeholder="Contoh: Roman, Edukasi" value="<?php echo htmlspecialchars($_POST['kategori'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="detail_buku">Detail Buku</label>
                                    <textarea id="detail_buku" name="detail_buku" placeholder="Tuliskan deskripsi lengkap tentang buku ini..." required><?php echo htmlspecialchars($_POST['detail_buku'] ?? ''); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_buku_upload">Gambar Buku</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="gambar_buku" id="gambar_buku_upload" accept="image/*" required>
                                        <label for="gambar_buku_upload" class="custom-file-button">Choose File</label>
                                        <span class="file-name-display" id="file-name-display">No file chosen</span>
                                    </div>
                                </div>
                                <div class="form-buttons">
                                    <button type="reset" class="reset-button">Reset</button>
                                    <button type="submit" name="submit_book" class="submit-button">Add Book</button>
                                </div>
                            </form>
                        </section>

                        <div class="confirmation-section" style="<?php echo $show_form ? 'display: flex;' : 'display: flex;'; ?>">
                            <div class="confirmation-message <?php echo ($message_type === 'success' && !empty($message)) ? 'show' : 'hidden'; ?>" id="confirmationMessage">
                                <img src="img/checkmark.svg" alt="Checkmark Icon" class="checkmark-icon" />
                                <div class="text-wrapper-thanks">TERIMA KASIH TELAH MENYUMBANG!</div>
                                <p>Buku Anda telah berhasil ditambahkan ke koleksi kami.</p>
                                <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script src="js/sidebar-toggle.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logic for rating stars input
            const starsContainer = document.getElementById('rating-input');
            const ratingValueInput = document.getElementById('rating_value');
            if (starsContainer && ratingValueInput) {
                const stars = Array.from(starsContainer.querySelectorAll('.star-input'));
                let currentRating = parseInt(ratingValueInput.value) || 0;

                function highlightStars(rating) {
                    stars.forEach((star, index) => {
                        if (index < rating) {
                            star.src = 'img/star.jpg';
                        } else {
                            star.src = 'img/star2.jpg';
                        }
                    });
                }
                highlightStars(currentRating);

                stars.forEach(star => {
                    star.addEventListener('mouseover', function() {
                        const hoverValue = parseInt(this.dataset.value);
                        highlightStars(hoverValue);
                    });
                    star.addEventListener('mouseout', function() {
                        highlightStars(currentRating);
                    });
                    star.addEventListener('click', function() {
                        currentRating = parseInt(this.dataset.value);
                        ratingValueInput.value = currentRating;
                        highlightStars(currentRating);
                    });
                });
            }

            // Logic for custom file input display
            const fileInput = document.getElementById('gambar_buku_upload');
            const fileNameDisplay = document.getElementById('file-name-display');
            if (fileInput && fileNameDisplay) {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                    } else {
                        fileNameDisplay.textContent = 'No file chosen';
                    }
                });
            }

            // PHP already handles initial display based on $show_form
            // This JS part handles dynamic switching AFTER initial load/submission
            const sumbangFormSection = document.querySelector('.sumbang-buku-form-section');
            const confirmationMessageDiv = document.getElementById('confirmationMessage');

            // If a success message is present from PHP, ensure form is hidden and message is shown
            <?php if ($message_type === 'success' && !empty($message)): ?>
                sumbangFormSection.style.display = 'none'; // Sembunyikan form
                confirmationMessageDiv.classList.add('show'); // Tampilkan pesan konfirmasi
            <?php else: ?>
                confirmationMessageDiv.classList.add('hidden'); // Sembunyikan pesan konfirmasi secara default
            <?php endif; ?>
        });

        // Highlight active sidebar item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname.split('/').pop();
            const sidebarItems = document.querySelectorAll('.menu > div');

            sidebarItems.forEach(item => {
                const link = item.querySelector('a');
                if (link) {
                    const href = link.getAttribute('href');
                    const linkFileName = href ? href.split('/').pop() : '';

                    if (linkFileName === currentPath) {
                        item.classList.add('active');
                    }
                }
            });
        });
    </script>
</body>
</html>
