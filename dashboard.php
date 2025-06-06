<?php
// dashboard.php (data buku dan fungsi PHP tetap sama)
$books = [
    'new_arrivals' => [
        ['id' => 'buku_baru_1', 'image' => 'img/richdad.jpeg', 'alt' => 'New Arrival 1'],
        ['id' => 'buku_baru_2', 'image' => 'img/atomichabits.jpeg', 'alt' => 'New Arrival 2'],
        ['id' => 'buku_baru_3', 'image' => 'img/bumi.jpeg', 'alt' => 'New Arrival 3'],
        ['id' => 'buku_baru_4', 'image' => 'img/filosofiteras.jpeg', 'alt' => 'New Arrival 4'],
    ],
    'popular_reads' => [
        ['id' => 'agama_peradaban', 'image' => 'img/agamauntukperadaban.jpg', 'title' => 'AGAMA UNTUK PERADABAN', 'stars' => 4],
        ['id' => 'atomic_habits', 'image' => 'img/atomichabits.jpeg', 'title' => 'ATOMIC HABITS', 'stars' => 4],
        ['id' => 'dongeng_kancil', 'image' => 'img/dongengkancil.jpeg', 'title' => 'DONGENG KANCIL', 'stars' => 4],
        ['id' => 'detektif_conan', 'image' => 'img/detektifconan.jpeg', 'title' => 'DETEKTIF CONAN', 'stars' => 4],
        ['id' => 'rich_dad', 'image' => 'img/richdad.jpeg', 'title' => 'RICH DAD POOR DAD', 'stars' => 4],
        ['id' => 'zero_to_one', 'image' => 'img/zeroone.jpeg', 'title' => 'ZERO TO ONE', 'stars' => 4],
        ['id' => 'kamus_lengkap', 'image' => 'img/kamus.jpeg', 'title' => 'KAMUS LENGKAP', 'stars' => 4],
        ['id' => 'kriptografi', 'image' => 'img/kriptografi.jpeg', 'title' => 'DASAR DASAR KRIPTOGRAFI', 'stars' => 4],
    ],
    'recommended_for_you' => [
        ['id' => 'perahu_kertas', 'image' => 'img/perahukertas.jpeg', 'title' => 'PERAHU KERTAS', 'stars' => 4],
        ['id' => 'fleeing_babylon', 'image' => 'img/fleefrom.jpeg', 'title' => 'FLEEING BABYLON', 'stars' => 4],
        ['id' => 'kejar_bintang', 'image' => 'img/kejarbintang.jpeg', 'title' => 'AYO KITA KEJAR <br />BINTANG ITU', 'stars' => 4],
        ['id' => 'art_of_holding', 'image' => 'img/artofholding.jpeg', 'title' => 'THE ART OF HOLDING<br />ON AND LETTING GO', 'stars' => 4],
    ],
    'fiction' => [
        ['id' => 'kehidupan_ketiga', 'image' => 'img/dimensiketiga.jpeg', 'title' => 'KEHIDUPAN KETIGA', 'stars' => 4],
        ['id' => 'bicara_seninya', 'image' => 'img/bicaraseni.jpeg', 'title' => 'BICARA ITU ADA SENINYA', 'stars' => 4],
        ['id' => 'filosofi_teras', 'image' => 'img/filosofiteras.jpeg', 'title' => 'FILOSOFI TERAS', 'stars' => 4],
    ],
];

function renderBookCard($book) {
    $starsHtml = '';
    for ($i = 0; $i < ($book['stars'] ?? 0); $i++) {
        $starsHtml .= '<img class="star" src="img/star.jpg" alt="star" />';
    }
    return '
        <div class="book-card">
            <img class="book-image" src="' . htmlspecialchars($book['image']) . '" alt="' . htmlspecialchars($book['title'] ?? $book['alt']) . '" />
            <h3 class="book-title">' . ($book['title'] ?? '') . '</h3>
            <div class="star-rating">
                ' . $starsHtml . '
            </div>
            <a href="detail_buku.php?id=' . htmlspecialchars($book['id']) . '" class="detail-button">Detail</a>
        </div>';
}

function renderBookSection($title, $books) {
    $html = '<h2 class="section-title">' . htmlspecialchars($title) . '</h2>';
    $html .= '<div class="book-grid">';
    foreach ($books as $book) {
        $html .= renderBookCard($book);
    }
    $html .= '</div>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Dashboard Perpustakaan Nura</title>
    <link rel="stylesheet" href="css/dashboard.css"> 
</head>
<body>
    <div id="dashboard-container" class="dashboard">
        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <header class="main-header">
                <?php
            
                $is_logged_in = true; // Ganti dengan logika status login Anda

                if ($is_logged_in) {
                    echo '<a href="profile.php" class="profile-button-header-round" title="Edit Profil">';
                    echo '  <img src="img/profile.png" alt="Profil">'; // Ganti dengan path gambar profil user
                    echo '</a>';
                } else {
                    echo '<div class="header-buttons">';
                    echo '  <a href="login.php" class="header-button login-button">Login</a>';
                    echo '  <a href="register.php" class="header-button register-button">Register</a>';
                    echo '</div>';
                }
                ?>
            </header>

            <div class="page-content-area">
                <h1 class="page-main-title">SELAMAT DATANG, DI LIBRARY NURA!</h1>

                <div class="dashboard-top-layout">
                    <section class="hero-section">
                        <div class="hero-text-container">
                            <p class="hero-text">Membaca bukan sekadar buku, tapi tentang tumbuh dan bersinar</p>
                        </div>
                    </section>

                    <section class="new-arrivals-section">
                        <h2 class="section-title">New Arrivals</h2>
                        <div class="new-arrival-images">
                            <?php foreach ($books['new_arrivals'] as $book): ?>
                                <a href="detail_buku.php?id=<?= htmlspecialchars($book['id']) ?>">
                                    <img class="new-arrival-image" src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['alt']) ?>" />
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>

                <?php echo renderBookSection('Bacaan Terpopuler', $books['popular_reads']); ?>
                <?php echo renderBookSection('Rekomendasi Untuk Anda', $books['recommended_for_you']); ?>
                <?php echo renderBookSection('Fiksi', $books['fiction']); ?>

            </div> <?php include 'footer.php'; ?>
        </div> </div> <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dashboardContainer = document.getElementById("dashboard-container");
        const sidebar = document.getElementById("sidebar");
        const toggleButton = sidebar ? sidebar.querySelector(".chevrons-left") : null;

        function applySidebarState(isCollapsed) {
            if (sidebar && dashboardContainer) {
                if (isCollapsed) {
                    sidebar.classList.add("collapsed");
                    dashboardContainer.classList.add("sidebar-collapsed");
                } else {
                    sidebar.classList.remove("collapsed");
                    dashboardContainer.classList.remove("sidebar-collapsed");
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
             applySidebarState(false); 
        }

        if (sidebar && dashboardContainer) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "class" && mutation.target === sidebar) {
                        const isSidebarCollapsed = sidebar.classList.contains("collapsed");
                        const isContainerCollapsed = dashboardContainer.classList.contains("sidebar-collapsed");
                        if (isSidebarCollapsed && !isContainerCollapsed) {
                            dashboardContainer.classList.add("sidebar-collapsed");
                        } else if (!isSidebarCollapsed && isContainerCollapsed) {
                            dashboardContainer.classList.remove("sidebar-collapsed");
                        }
                    }
                });
            });
            observer.observe(sidebar, { attributes: true });
        }
    });
    </script>
</body>
</html>
