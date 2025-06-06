<?php
session_start();

// --- DATA DUMMY UNTUK SIMULASI KOLEKSI BUKU ---
// Ini adalah data pengguna dummy (asumsikan sudah login)
$is_logged_in = true;
$current_user_id = 'user123';
$user_name = "Tuan Putri Nura";

$all_books = [
    [
        'id_buku' => 'B001',
        'nama_buku' => 'Mimpi Anak Negeri',
        'author' => 'Andrea Hirata',
        'cover' => 'img/mimpianaknegeri.jpg',
        'genre' => 'Fiksi Edukasi',
        'rating' => 4.5,
        'stock' => 5,
        'status' => 'Tersedia',
        'tahun_terbit' => 2005,
        'bahasa' => 'Indonesia'
    ],
    [
        'id_buku' => 'B002',
        'nama_buku' => 'Laskar Pelangi',
        'author' => 'Andrea Hirata',
        'cover' => 'img/laskarpelangi.jpeg',
        'genre' => 'Fiksi Edukasi',
        'rating' => 4.8,
        'stock' => 0, // Contoh buku habis
        'status' => 'Tidak Tersedia',
        'tahun_terbit' => 2005,
        'bahasa' => 'Indonesia'
    ],
    [
        'id_buku' => 'B003',
        'nama_buku' => 'Filosofi Kopi',
        'author' => 'Dee Lestari',
        'cover' => 'img/filosofikopi.jpeg',
        'genre' => 'Fiksi Filosofi',
        'rating' => 4.2,
        'stock' => 2,
        'status' => 'Tersedia',
        'tahun_terbit' => 2006,
        'bahasa' => 'Indonesia'
    ],
    [
        'id_buku' => 'B004',
        'nama_buku' => 'Bumi',
        'author' => 'Tere Liye',
        'cover' => 'img/bumi.jpeg',
        'genre' => 'Fantasi',
        'rating' => 4.7,
        'stock' => 1,
        'status' => 'Tersedia',
        'tahun_terbit' => 2014,
        'bahasa' => 'Indonesia'
    ],
    [
        'id_buku' => 'B005',
        'nama_buku' => 'Pulang',
        'author' => 'Tere Liye',
        'cover' => 'img/pulang.jpeg',
        'genre' => 'Fiksi Petualangan',
        'rating' => 4.6,
        'stock' => 3,
        'status' => 'Tersedia',
        'tahun_terbit' => 2015,
        'bahasa' => 'Indonesia'
    ],
    [
        'id_buku' => 'B006',
        'nama_buku' => 'Harry Potter dan Batu Bertuah',
        'author' => 'J.K. Rowling',
        'cover' => 'img/harrypoter.jpeg',
        'genre' => 'Fantasi',
        'rating' => 4.9,
        'stock' => 0,
        'status' => 'Tidak Tersedia',
        'tahun_terbit' => 1997,
        'bahasa' => 'Inggris'
    ],
    [
        'id_buku' => 'B007',
        'nama_buku' => 'The Lord of the Rings',
        'author' => 'J.R.R. Tolkien',
        'cover' => 'img/thelord.jpeg',
        'genre' => 'Fantasi',
        'rating' => 5.0,
        'stock' => 1,
        'status' => 'Tersedia',
        'tahun_terbit' => 1954,
        'bahasa' => 'Inggris'
    ],
    [
        'id_buku' => 'B008',
        'nama_buku' => 'Cantik Itu Luka',
        'author' => 'Eka Kurniawan',
        'cover' => 'img/cantik.jpeg',
        'genre' => 'Fiksi Sastra',
        'rating' => 4.4,
        'stock' => 2,
        'status' => 'Tersedia',
        'tahun_terbit' => 2002,
        'bahasa' => 'Indonesia'
    ],
];

// --- LOGIKA FILTER DAN PENCARIAN BUKU ---
$search_query = isset($_GET['search_query']) ? strtolower(trim($_GET['search_query'])) : '';
$filter_genre = isset($_GET['filter_genre']) ? $_GET['filter_genre'] : '';
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$filter_tahun_terbit = isset($_GET['filter_tahun_terbit']) ? $_GET['filter_tahun_terbit'] : '';
$filter_bahasa = isset($_GET['filter_bahasa']) ? $_GET['filter_bahasa'] : '';

$filtered_books = []; // Array untuk hasil filter

foreach ($all_books as $book) {
    $match = true;

    // Filter berdasarkan search query (judul, penulis, genre, status, id_buku, tahun, bahasa)
    if (!empty($search_query)) {
        $book_match_search = false;
        if (str_contains(strtolower($book['id_buku']), $search_query)) $book_match_search = true;
        if (str_contains(strtolower($book['nama_buku']), $search_query)) $book_match_search = true;
        if (str_contains(strtolower($book['author']), $search_query)) $book_match_search = true;
        if (str_contains(strtolower($book['genre']), $search_query)) $book_match_search = true;
        if (str_contains(strtolower($book['status']), $search_query)) $book_match_search = true;
        if (str_contains(strtolower((string)$book['tahun_terbit']), $search_query)) $book_match_search = true;
        if (str_contains(strtolower($book['bahasa']), $search_query)) $book_match_search = true;

        if (!$book_match_search) {
            $match = false;
        }
    }

    // Filter berdasarkan Genre
    if ($match && !empty($filter_genre) && $filter_genre !== 'all') {
        if (strtolower($book['genre']) !== strtolower($filter_genre)) {
            $match = false;
        }
    }

    // Filter berdasarkan Status
    if ($match && !empty($filter_status) && $filter_status !== 'all') {
        if (strtolower($book['status']) !== strtolower($filter_status)) {
            $match = false;
        }
    }

    // Filter berdasarkan Tahun Terbit
    if ($match && !empty($filter_tahun_terbit) && $filter_tahun_terbit !== 'all') {
        if ((string)$book['tahun_terbit'] !== $filter_tahun_terbit) {
            $match = false;
        }
    }

    // Filter berdasarkan Bahasa
    if ($match && !empty($filter_bahasa) && $filter_bahasa !== 'all') {
        if (strtolower($book['bahasa']) !== strtolower($filter_bahasa)) {
            $match = false;
        }
    }

    if ($match) {
        $filtered_books[] = $book;
    }
}

// Ambil opsi unik untuk dropdown filter dari SEMUA buku (agar filter selalu lengkap)
$unique_genres = array_unique(array_column($all_books, 'genre'));
sort($unique_genres);

$unique_statuses = array_unique(array_column($all_books, 'status'));
sort($unique_statuses);

$unique_tahun_terbit = array_unique(array_column($all_books, 'tahun_terbit'));
rsort($unique_tahun_terbit);

$unique_bahasa = array_unique(array_column($all_books, 'bahasa'));
sort($unique_bahasa);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pencarian Buku - Perpustakaan Nura</title>
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/style.css" /> <?php // Asumsi style.css berisi general style ?>
    <link rel="stylesheet" href="css/Pencarian.css" /> <?php // CSS khusus halaman pencarian ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="sidebar-open">
    <div class="app-container">
        <?php include 'sidebar.php'; // Panggil sidebar ?>

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
                <div class="pencarian-page-container">
                    <h1 class="page-title-pencarian">Pencarian Buku</h1>

                    <div class="pencarian-card">

                        <form action="pencarian.php" method="GET" class="filter-form">
                            <div class="search-and-filter-row">
                                <div class="search-input-wrapper">
                                    <input type="text" name="search_query" class="search-input-field" placeholder="Cari Judul, Penulis, Genre, Status..." value="<?php echo htmlspecialchars($search_query); ?>" />
                                    <button type="submit" class="search-button">
                                        <i class="material-icons">search</i> <?php // Menggunakan Material Icons ?>
                                    </button>
                                </div>
                                <button type="button" class="reset-filter-button" onclick="window.location.href='pencarian.php'">Reset Filter</button>
                            </div>

                            <div class="filter-options-row">
                                <div class="filter-group">
                                    <label for="filter_genre">Genre:</label>
                                    <select name="filter_genre" id="filter_genre" class="filter-select">
                                        <option value="all">Semua Genre</option>
                                        <?php foreach ($unique_genres as $genre): ?>
                                            <option value="<?php echo htmlspecialchars(strtolower($genre)); ?>" <?php echo ($filter_genre === strtolower($genre)) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($genre); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label for="filter_status">Status:</label>
                                    <select name="filter_status" id="filter_status" class="filter-select">
                                        <option value="all">Semua Status</option>
                                        <?php foreach ($unique_statuses as $status): ?>
                                            <option value="<?php echo htmlspecialchars(strtolower($status)); ?>" <?php echo ($filter_status === strtolower($status)) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($status); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label for="filter_tahun_terbit">Tahun Terbit:</label>
                                    <select name="filter_tahun_terbit" id="filter_tahun_terbit" class="filter-select">
                                        <option value="all">Semua Tahun</option>
                                        <?php foreach ($unique_tahun_terbit as $tahun): ?>
                                            <option value="<?php echo htmlspecialchars((string)$tahun); ?>" <?php echo ($filter_tahun_terbit === (string)$tahun) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($tahun); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label for="filter_bahasa">Bahasa:</label>
                                    <select name="filter_bahasa" id="filter_bahasa" class="filter-select">
                                        <option value="all">Semua Bahasa</option>
                                        <?php foreach ($unique_bahasa as $bahasa): ?>
                                            <option value="<?php echo htmlspecialchars(strtolower($bahasa)); ?>" <?php echo ($filter_bahasa === strtolower($bahasa)) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($bahasa); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="apply-filter-button">Terapkan Filter</button>
                            </div>
                        </form>

                        <div class="table-responsive-wrapper">
                            <div class="books-table">

                                <div class="table-header-row">
                                    <div class="header-cell header-book">Buku</div>
                                    <div class="header-cell">Genre</div>
                                    <div class="header-cell">Rating</div>
                                    <div class="header-cell">Status</div>
                                    <div class="header-cell header-action">Aksi</div>
                                </div>

                                <?php
                                if (empty($filtered_books)) {
                                ?>
                                    <div class="no-results-message">
                                        Tidak ada hasil yang cocok dengan filter dan pencarian Anda.
                                    </div>
                                <?php
                                } else {
                                    foreach ($filtered_books as $book) {
                                        $status_class_modifier = '';
                                        if ($book['stock'] > 0) {
                                            $status_class_modifier = 'status-available';
                                        } else {
                                            $status_class_modifier = 'status-unavailable';
                                        }
                                ?>
                                <div class="table-data-row">
                                    <div class="data-cell data-book">
                                        <div class="book-thumbnail" style="background-image: url(<?php echo htmlspecialchars($book['cover']); ?>);"></div>
                                        <div class="book-details">
                                            <div class="book-title-small"><?php echo htmlspecialchars($book['nama_buku']); ?></div>
                                            <div class="book-author-small"><?php echo htmlspecialchars($book['author']); ?></div>
                                        </div>
                                    </div>
                                    <div class="data-cell" data-label="Genre:">
                                        <span class="data-value genre-tag"><?php echo htmlspecialchars($book['genre']); ?></span>
                                    </div>
                                    <div class="data-cell" data-label="Rating:">
                                        <span class="data-value rating-stars">
                                            <?php
                                            // Tampilkan bintang rating
                                            $rating_int = floor($book['rating']);
                                            $has_half = ($book['rating'] - $rating_int) >= 0.5;
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < $rating_int) {
                                                    echo '<i class="material-icons star-filled">star</i>';
                                                } elseif ($i == $rating_int && $has_half) {
                                                    echo '<i class="material-icons star-half">star_half</i>';
                                                } else {
                                                    echo '<i class="material-icons star-empty">star_border</i>';
                                                }
                                            }
                                            ?>
                                            (<?php echo htmlspecialchars(number_format($book['rating'], 1)); ?>)
                                        </span>
                                    </div>
                                    <div class="data-cell" data-label="Status:">
                                        <span class="data-value <?php echo $status_class_modifier; ?>">
                                            <?php echo htmlspecialchars($book['status']); ?> (<?php echo htmlspecialchars($book['stock']); ?>)
                                        </span>
                                    </div>
                                    <div class="data-cell data-action">
                                        <a href="detail_buku.php?id=<?php echo htmlspecialchars($book['id_buku']); ?>" class="action-button detail-button">Detail</a>
                                        <?php if ($book['stock'] > 0) : ?>
                                            <a href="peminjaman.php?book_id=<?php echo htmlspecialchars($book['id_buku']); ?>" class="action-button borrow-button">Pinjam</a>
                                        <?php else : ?>
                                            <button class="action-button disabled-button" disabled>Habis</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                                    } // End foreach
                                } // End else (if empty filtered_books)
                                ?>

                            </div> <?php // End .books-table ?>
                        </div> <?php // End .table-responsive-wrapper ?>

                    </div> <?php // End .pencarian-card ?>
                </div> <?php // End .pencarian-page-container ?>
            </main>
            <?php include 'footer.php'; ?>
        </div>
    </div>
    <script src="js/sidebar-toggle.js"></script>
</body>
</html>
