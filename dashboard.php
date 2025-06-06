<?php
session_start();

// --- PENTING: SERTAKAN FILE DATA BUKU YANG TERPUSAT ---
require_once 'data_buku.php'; // PASTIIN INI ADA DAN TIDAK DIKOMEN

// --- Mapping untuk menentukan buku mana yang muncul di setiap bagian dashboard ---
// Kunci array ini HARUS SESUAI dengan kunci array di $allBooksData (dari data_buku.php)
$dashboard_sections_books = [
    'new_arrivals' => [ // ID buku dari data_buku.php
        'rich_dad_poor_dad', // ID di data_buku.php
        'atomic_habits',
        'bumi', // ID 'bumi' dari data_buku.php
        'filosofi_teras',
    ],
    'popular_reads' => [ // ID buku dari data_buku.php
        'agama_untuk_peradaban',
        'atomic_habits',
        'dongeng_kancil',
        'detektif_conan',
        'rich_dad_poor_dad',
        'zero_to_one',
        'kamus_lengkap',
        'dasar_dasar_kriptografi',
    ],
    'recommended_for_you' => [ // ID buku dari data_buku.php
        'perahu_kertas',
        'fleeing_babylon',
        'ayo_kita_kejar_bintang_itu',
        'the_art_of_holding_on_and_letting_go',
    ],
    'fiction' => [ // ID buku dari data_buku.php
        'kehidupan_ketiga',
        'perahu_kertas',
        'dongeng_kancil',
        'detektif_conan',
       
    ],
    'non_fiction' => [ // Kategori Non-Fiksi yang BARU (sesuai ID di data_buku.php)
        'sejarah_dunia', // ID dari data_buku.php (Sapiens)
        'filsafat_ilmu', // ID dari data_buku.php
        'atomic_habits',
        'rich_dad_poor_dad',
    ],
    'education' => [ // Kategori Pendidikan & Referensi
        'kamus_lengkap',
        'kesehatan_olahraga',
        'dasar_dasar_kriptografi',
        'filsafat_ilmu',
    ],
    'motivation' => [ // Kategori Motivasi & Inspirasi
        'atomic_habits',
        'filosofi_teras',
        'ayo_kita_kejar_bintang_itu',
        'zero_to_one',
    ]
];

// --- Fungsi untuk Merender Kartu Buku ---
// Fungsi ini menerima ID buku, BUKAN array buku utuh seperti `$book` sebelumnya.
function renderBookCard($bookId, $allBooksData, $is_new_arrival_hero = false) {
    // Pastikan buku ada di data_buku.php. Jika tidak ada, tampilkan pesan error.
    if (!isset($allBooksData[$bookId])) {
        error_log("Book ID '{$bookId}' not found in \$allBooksData. Please check data_buku.php or dashboard_sections_books array.");
        return '<div>Error: Buku ID ' . htmlspecialchars($bookId) . ' tidak ditemukan.</div>';
    }
    $book = $allBooksData[$bookId]; // Ambil data buku lengkap dari $allBooksData

    // Render khusus untuk gambar hero (New Arrivals) - Bagian ini tidak akan lagi digunakan
    // karena New Arrivals akan dihapus, tapi fungsi tetap ada untuk menjaga konsistensi.
    if ($is_new_arrival_hero) {
        return ''; // Mengembalikan string kosong karena bagian ini tidak akan dirender.
    }

    // Render standar untuk kartu buku lainnya
    $starsHtml = '';
    $average_rating = $book['average_rating'] ?? 0; // Pastikan average_rating ada
    $fullStars = floor($average_rating);
    $halfStar = ($average_rating - $fullStars) >= 0.5;

    // PATH GAMBAR BINTANG DIKOREKSI AGAR SESUAI DENGAN data_buku.php
    for ($i = 0; $i < $fullStars; $i++) {
        $starsHtml .= '<img class="star" src="img/star.jpg" alt="star filled" />'; 
    }
    if ($halfStar) {
        $starsHtml .= '<img class="star" src="img/star3.jpg" alt="half star filled" />'; 
    }
    for ($i = ($fullStars + ($halfStar ? 1 : 0)); $i < 5; $i++) {
        $starsHtml .= '<img class="star" src="img/star2.jpg" alt="star empty" />'; 
    }

    return '
        <div class="book-card">
            <a href="detail_buku.php?id=' . htmlspecialchars($bookId) . '" class="book-link-wrapper">
                <img class="book-image" src="' . htmlspecialchars($book['cover_image']) . '" alt="' . htmlspecialchars($book['judul']) . '" />
                <h3 class="book-title">' . htmlspecialchars($book['judul']) . '</h3>
                <p class="book-author">' . htmlspecialchars($book['author']) . '</p>
                <div class="star-rating">
                    ' . $starsHtml . '
                </div>
                <div class="rating-count-dashboard">(' . htmlspecialchars($book['rating_count'] ?? 0) . ' Reviews)</div>
            </a>
            <a href="detail_buku.php?id=' . htmlspecialchars($bookId) . '" class="detail-button">Detail</a>
        </div>';
}

// --- Fungsi untuk Merender Bagian Buku ---
// Fungsi ini menerima array ID buku (misalnya $dashboard_sections_books['popular_reads'])
function renderBookSection($title, $bookIdsArray, $allBooksData) {
    $html = '<section class="book-section">';
    $html .= '<h2 class="section-title">' . htmlspecialchars($title) . '</h2>';
    $html .= '<div class="book-grid">';
    foreach ($bookIdsArray as $bookId) { // Loop melalui setiap ID buku di array
        $html .= renderBookCard($bookId, $allBooksData); // Panggil renderBookCard dengan ID dan data lengkap
    }
    $html .= '</div>';
    $html .= '</section>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Dashboard Perpustakaan Nura</title>
    <link rel="stylesheet" href="css/main.css">
    <!-- <link rel="stylesheet" href="css/dashboard.css"> -->
    <link rel="stylesheet" href="css/style.css">

    
</head>
<body>
    <div id="dashboard-container" class="app-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <header class="main-header">
                <h1 class="page-main-title">SELAMAT DATANG, DI LIBRARY NURA!</h1>
                <div class="search-profile-section">
                    <?php
                    // Logika tampilan tombol profil/login/register
                    // Asumsi $_SESSION['user_id'] diatur saat login berhasil
                    $is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
                    $user_avatar_path = 'img/profile.png'; // Default avatar

                    // Contoh dummy user data (dalam aplikasi nyata, ini dari database)
                    // Anda harus memiliki data pengguna yang sesuai dengan $_SESSION['user_id']
                    $allUserDataDummy = [
                        'user123' => [
                            'avatar' => 'img/default-profile.png', // Contoh avatar pengguna
                            // ... data pengguna lainnya
                        ],
                    ];

                    if ($is_logged_in) {
                        $current_user_id = $_SESSION['user_id'];
                        // Cek apakah user_id yang ada di sesi valid di data dummy
                        if (isset($allUserDataDummy[$current_user_id]['avatar'])) {
                            $user_avatar_path = $allUserDataDummy[$current_user_id]['avatar'];
                        } else {
                            // Jika user_id di sesi tidak valid (misal: sesi kadaluarsa/data dummy tidak cocok)
                            // Anda mungkin ingin menghancurkan sesi dan mengarahkan ke login
                            // session_destroy();
                            // header('Location: login.php');
                            // exit();
                        }

                        echo '<a href="profile.php" class="profile-button-header-round" title="Edit Profil">';
                        echo '    <img src="' . htmlspecialchars($user_avatar_path) . '" alt="Profil">';
                        echo '</a>';
                    } else {
                        echo '<div class="header-buttons">';
                        echo '    <a href="login.php" class="header-button login-button">Login</a>';
                        echo '    <a href="register.php" class="header-button register-button">Register</a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </header>

            <div class="page-content-area">
                <section class="hero-section-centered-tagline">
                    <div class="hero-text-container">
                        <p class="hero-text">Membaca bukan sekadar buku, tapi tentang tumbuh dan bersinar</p>
                    </div>
                </section>

                <?php echo renderBookSection('Bacaan Terpopuler', $dashboard_sections_books['popular_reads'], $allBooksData); ?>
                <?php echo renderBookSection('Rekomendasi Untuk Anda', $dashboard_sections_books['recommended_for_you'], $allBooksData); ?>
                <?php echo renderBookSection('Fiksi', $dashboard_sections_books['fiction'], $allBooksData); ?>
                <?php echo renderBookSection('Non-Fiksi', $dashboard_sections_books['non_fiction'], $allBooksData); ?>
                <?php echo renderBookSection('Pendidikan & Referensi', $dashboard_sections_books['education'], $allBooksData); ?>
                <?php echo renderBookSection('Motivasi & Inspirasi', $dashboard_sections_books['motivation'], $allBooksData); ?>

            </div>
            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const dashboardContainer = document.getElementById('dashboard-container'); // Get the main container
            const toggleButton = sidebar ? sidebar.querySelector("#sidebar-toggle") : null; // Use #sidebar-toggle ID

            function applySidebarState(isCollapsed) {
                if (sidebar && dashboardContainer) {
                    if (isCollapsed) {
                        sidebar.classList.add("collapsed");
                        dashboardContainer.classList.add("sidebar-collapsed"); // Add class to main container
                        if (toggleButton) toggleButton.style.transform = 'rotate(180deg)';
                    } else {
                        sidebar.classList.remove("collapsed");
                        dashboardContainer.classList.remove("sidebar-collapsed"); // Remove class from main container
                        if (toggleButton) toggleButton.style.transform = 'rotate(0deg)';
                    }
                }
            }

            function toggleSidebarOnClick() {
                if (sidebar) {
                    const isCurrentlyCollapsed = sidebar.classList.contains("collapsed");
                    applySidebarState(!isCurrentlyCollapsed);
                    localStorage.setItem("sidebarCollapsed", !isCurrentlyCollapsed);
                }
            }

            if (toggleButton) {
                toggleButton.addEventListener("click", toggleSidebarOnClick);
            }

            const savedState = localStorage.getItem("sidebarCollapsed");
            if (savedState !== null) {
                applySidebarState(savedState === "true");
            } else {
                applySidebarState(false); // Default to open if no state saved
            }
        });
    </script>
</body>
</html>
