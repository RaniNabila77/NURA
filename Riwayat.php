<?php
session_start();

// --- DATA DUMMY UNTUK SIMULASI (dari database) ---
$is_logged_in = true;
$current_user_id = 'user123';
$user_name = "Tuan Putri Nura";

// Data riwayat peminjaman dummy
$all_loan_history = [
    [
        'id_buku' => '00155',
        'nama_buku' => 'Mimpi Anak Negeri',
        'author' => 'Andrea Hirata', // Tambahkan author jika ingin ditampilkan
        'cover' => 'img/image-19.png',
        'tgl_pinjam' => '2025-01-02',
        'tgl_kembali' => '2025-02-02',
        'denda' => 'Rp.1000',
        'status' => 'Dikembalikan',
        'genre' => 'Romance'
    ],
    [
        'id_buku' => '00097',
        'nama_buku' => 'Laskar Pelangi',
        'author' => 'Andrea Hirata',
        'cover' => 'img/image-20.png',
        'tgl_pinjam' => '2025-01-02',
        'tgl_kembali' => '-',
        'denda' => '-',
        'status' => 'Dipinjam',
        'genre' => 'Education'
    ],
    [
        'id_buku' => '00023',
        'nama_buku' => 'Filosofi Kopi',
        'author' => 'Dee Lestari',
        'cover' => 'img/image-21.png',
        'tgl_pinjam' => '2025-01-02',
        'tgl_kembali' => '2025-02-02',
        'denda' => '-',
        'status' => 'Dikembalikan',
        'genre' => 'Fantasy'
    ],
    [
        'id_buku' => '00004',
        'nama_buku' => 'Bumi',
        'author' => 'Tere Liye',
        'cover' => 'img/image-22.png', // Contoh gambar baru
        'tgl_pinjam' => '2025-03-10',
        'tgl_kembali' => '-',
        'denda' => '-',
        'status' => 'Dipinjam',
        'genre' => 'Fantasi'
    ],
    [
        'id_buku' => '00005',
        'nama_buku' => 'Pulang',
        'author' => 'Tere Liye',
        'cover' => 'img/image-23.png', // Contoh gambar baru
        'tgl_pinjam' => '2025-04-01',
        'tgl_kembali' => '2025-05-01',
        'denda' => 'Rp.500',
        'status' => 'Dikembalikan',
        'genre' => 'Fiksi'
    ],
];

// --- LOGIKA PENCARIAN ---
$search_query = isset($_GET['search_query']) ? strtolower(trim($_GET['search_query'])) : '';
$filtered_loan_history = []; // Array untuk hasil filter

if (!empty($search_query)) {
    foreach ($all_loan_history as $loan) {
        // Cek di ID Buku, Nama Buku, Author, Genre, atau Status
        if (
            str_contains(strtolower($loan['id_buku']), $search_query) ||
            str_contains(strtolower($loan['nama_buku']), $search_query) ||
            str_contains(isset($loan['author']) ? strtolower($loan['author']) : '', $search_query) || // Cek author jika ada
            str_contains(strtolower($loan['genre']), $search_query) ||
            str_contains(strtolower($loan['status']), $search_query)
        ) {
            $filtered_loan_history[] = $loan;
        }
    }
} else {
    // Jika tidak ada query pencarian, tampilkan semua data
    $filtered_loan_history = $all_loan_history;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Peminjaman Buku - Perpustakaan Nura</title>
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/Riwayat.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="sidebar-open">
    <div class="app-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content-area">
            <?php // Header tidak ada, maka tombol profil akan ditempatkan langsung di sini ?>
            <div class="header-placeholder">
                <?php if ($is_logged_in): ?>
                    <a href="profile.php" class="profile-button-header-round" title="Lihat Profil">
                        <img src="img/default-profile.png" alt="Profil">
                    </a>
                <?php else: ?>
                    <div class="header-buttons">
                        <a href="login.php" class="header-button login-button">Login</a>
                        <a href="register.php" class="header-button register-button">Register</a>
                    </div>
                <?php endif; ?>
            </div>

            <main class="main-content">
                <div class="riwayat-page-container"> <?php // Wrapper luar halaman riwayat ?>

                    <h1 class="page-title-riwayat">Riwayat Peminjaman Buku</h1>

                    <div class="riwayat-card"> <?php // Ini adalah "card" putih utama ?>

                        <form action="riwayat.php" method="GET" class="search-form-flex"> <?php // Form pencarian ?>
                            <div class="search-input-wrapper">
                                <input type="text" name="search_query" class="search-input-field" placeholder="Cari ID Buku, Nama, Genre, Status..." value="<?php echo htmlspecialchars($search_query); ?>" />
                                <button type="submit" class="search-button">
                                    <i class="material-icons">search</i> <?php // Menggunakan Material Icons ?>
                                </button>
                            </div>
                        </form>

                        <div class="table-responsive-wrapper"> <?php // Wrapper untuk overflow di layar kecil ?>
                            <div class="history-table"> <?php // Tabel utama dengan Flexbox ?>

                                <div class="table-header-row">
                                    <div class="header-cell header-book">Buku</div>
                                    <div class="header-cell">ID Buku</div>
                                    <div class="header-cell">Peminjaman</div>
                                    <div class="header-cell">Pengembalian</div>
                                    <div class="header-cell">Denda</div>
                                    <div class="header-cell">Status</div>
                                    <div class="header-cell">Genre</div>
                                </div>

                                <?php
                                if (empty($filtered_loan_history)) {
                                ?>
                                    <div class="no-results-message">
                                        Tidak ada hasil untuk pencarian "<?php echo htmlspecialchars($search_query); ?>".
                                    </div>
                                <?php
                                } else {
                                    foreach ($filtered_loan_history as $loan) {
                                        $status_class_modifier = '';
                                        if ($loan['status'] == 'Dikembalikan') {
                                            $status_class_modifier = 'status-returned';
                                        } elseif ($loan['status'] == 'Dipinjam') {
                                            $status_class_modifier = 'status-borrowed';
                                        }

                                        $denda_class_modifier = ($loan['denda'] != '-') ? 'denda-paid' : 'denda-none';
                                ?>
                                <div class="table-data-row">
                                    <div class="data-cell data-book">
                                        <div class="book-thumbnail" style="background-image: url(<?php echo htmlspecialchars($loan['cover']); ?>);"></div>
                                        <div class="book-details">
                                            <div class="book-title-small"><?php echo htmlspecialchars($loan['nama_buku']); ?></div>
                                            <div class="book-author-small"><?php echo htmlspecialchars($loan['author']); ?></div>
                                        </div>
                                    </div>
                                    <div class="data-cell" data-label="ID Buku:">
                                        <span class="data-value"><?php echo htmlspecialchars($loan['id_buku']); ?></span>
                                    </div>
                                    <div class="data-cell" data-label="Peminjaman:">
                                        <span class="data-value"><?php echo htmlspecialchars($loan['tgl_pinjam']); ?></span>
                                    </div>
                                    <div class="data-cell" data-label="Pengembalian:">
                                        <span class="data-value"><?php echo htmlspecialchars($loan['tgl_kembali']); ?></span>
                                    </div>
                                    <div class="data-cell" data-label="Denda:">
                                        <span class="data-value <?php echo $denda_class_modifier; ?>"><?php echo htmlspecialchars($loan['denda']); ?></span>
                                    </div>
                                    <div class="data-cell" data-label="Status:">
                                        <span class="data-value <?php echo $status_class_modifier; ?>"><?php echo htmlspecialchars($loan['status']); ?></span>
                                    </div>
                                    <div class="data-cell" data-label="Genre:">
                                        <span class="data-value"><?php echo htmlspecialchars($loan['genre']); ?></span>
                                    </div>
                                </div>
                                <?php
                                    } // End foreach
                                } // End else (if empty filtered_loan_history)
                                ?>

                            </div> <?php // End .history-table ?>
                        </div> <?php // End .table-responsive-wrapper ?>

                    </div> <?php // End .riwayat-card ?>
                </div> <?php // End .riwayat-page-container ?>
            </main>
            <?php include 'footer.php'; ?>
        </div>
    </div>
    <script src="js/sidebar-toggle.js"></script>
</body>
</html>