<?php
// dashboard.php

// Define book data in a structured array
$books = [
    'new_arrivals' => [
        ['id' => 'buku_baru_1', 'image' => 'img/group-98.png', 'alt' => 'New Arrival 1'],
        ['id' => 'buku_baru_2', 'image' => 'img/image-1.png', 'alt' => 'New Arrival 2'],
        ['id' => 'buku_baru_3', 'image' => 'img/image-17.png', 'alt' => 'New Arrival 3'],
        ['id' => 'buku_baru_4', 'image' => 'img/image-2.png', 'alt' => 'New Arrival 4'],
    ],
    'popular_reads' => [
        ['id' => 'agama_peradaban', 'image' => 'img/image-10.png', 'title' => 'AGAMA UNTUK PERADABAN', 'stars' => 4],
        ['id' => 'atomic_habits', 'image' => 'img/image-11.png', 'title' => 'ATOMIC HABITS', 'stars' => 4],
        ['id' => 'dongeng_kancil', 'image' => 'img/image-13.png', 'title' => 'DONGENG KANCIL', 'stars' => 4],
        ['id' => 'detektif_conan', 'image' => 'img/image-12.png', 'title' => 'DETEKTIF CONAN', 'stars' => 4],
        ['id' => 'rich_dad', 'image' => 'img/image-5.png', 'title' => 'RICH DAD POOR DAD', 'stars' => 4],
        ['id' => 'zero_to_one', 'image' => 'img/image-7.png', 'title' => 'ZERO TO ONE', 'stars' => 4],
        ['id' => 'kamus_lengkap', 'image' => 'img/image-6.png', 'title' => 'KAMUS LENGKAP', 'stars' => 4],
        ['id' => 'kriptografi', 'image' => 'img/image-26.png', 'title' => 'DASAR DASAR KRIPTOGRAFI', 'stars' => 4],
    ],
    'recommended_for_you' => [
        ['id' => 'perahu_kertas', 'image' => 'img/image-23.png', 'title' => 'PERAHU KERTAS', 'stars' => 4],
        ['id' => 'fleeing_babylon', 'image' => 'img/image-24.png', 'title' => 'FLEEING BABYLON', 'stars' => 4],
        ['id' => 'kejar_bintang', 'image' => 'img/image-25.png', 'title' => 'AYO KITA KEJAR <br />BINTANG ITU', 'stars' => 4],
        ['id' => 'art_of_holding', 'image' => 'img/image-22.png', 'title' => 'THE ART OF HOLDING<br />ON AND LETTING GO', 'stars' => 4],
    ],
    'fiction' => [
        ['id' => 'kehidupan_ketiga', 'image' => 'img/image-31.png', 'title' => 'KEHIDUPAN KETIGA', 'stars' => 4],
        ['id' => 'bicara_seninya', 'image' => 'img/image-29.png', 'title' => 'BICARA ITU ADA SENINYA', 'stars' => 4],
        ['id' => 'filosofi_teras', 'image' => 'img/image-28.png', 'title' => 'FILOSOFI TERAS', 'stars' => 4],
    ],
];

/**
 * Renders a book card.
 * @param array $book The book data (id, image, title, stars).
 * @return string HTML for the book card.
 */
function renderBookCard($book) {
    $starsHtml = '';
    for ($i = 0; $i < ($book['stars'] ?? 0); $i++) {
        $starsHtml .= '<img class="star" src="img/star-10-11.svg" alt="star" />';
    }

    return '
        <div class="book-card">
            <img class="book-image" src="' . htmlspecialchars($book['image']) . '" alt="' . htmlspecialchars($book['title'] ?? $book['alt']) . '" />
            <div class="book-title">' . ($book['title'] ?? '') . '</div>
            <div class="star-rating">
                ' . $starsHtml . '
            </div>
            <a href="detail_buku.php?id=' . htmlspecialchars($book['id']) . '" class="detail-button">Detail</a>
        </div>
    ';
}

/**
 * Renders a section of books.
 * @param string $title The title of the section.
 * @param array $books The array of book data for the section.
 * @return string HTML for the book section.
 */
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
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Dashboard Perpustakaan Nura</title>
    <style>
        /* --- General Layout for Sticky Footer --- */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .dashboard {
            display: flex;
            flex-grow: 1;
            min-height: 100%;
        }

        .main-content-wrapper {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            /* Margin left controlled by sidebar width */
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            position: relative; /* For FAB positioning */
            
            /* --- Centering Main Content --- */
            /* Add padding to the wrapper itself for overall horizontal spacing */
            padding: 0 20px; /* 0 top/bottom, 20px left/right */
            
            /* Max width for the entire main content area (adjust as needed) */
            max-width: calc(100% - 250px); /* Total screen width minus sidebar width */
            margin-right: auto; /* Push content to center when sidebar is expanded */
            margin-left: auto; /* Push content to center when sidebar is expanded */
            box-sizing: border-box; /* Ensure padding is included in width */
        }
        
        /* Adjust wrapper margin and width when sidebar is collapsed */
        .dashboard.sidebar-collapsed .main-content-wrapper {
            margin-left: 70px; /* Adjust based on your sidebar's collapsed width */
            max-width: calc(100% - 70px); /* Total screen width minus collapsed sidebar width */
        }

        /* The .main-content itself will now handle its own top/bottom padding */
        .main-content {
            flex-grow: 1; /* Pushes the footer down */
            padding-top: 20px;
            padding-bottom: 20px;
            /* Removed horizontal padding here as it's on main-content-wrapper now */
            max-width: 100%; /* Ensure it uses all available width from its parent */
            box-sizing: border-box;
        }

        /* --- Dashboard Specific Styles --- */
        .SELAMAT-DATANG-DI {
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: bold;
            /* Centering the title explicitly */
            text-align: center;
        }

        .section-title {
            font-size: 2em;
            margin-top: 40px;
            margin-bottom: 20px;
            font-weight: bold;
            /* Centering the section titles explicitly */
            text-align: center;
        }

        /* --- Specific styles for Tagline and New Arrivals layout --- */
        .top-content-flex {
            display: flex;
            align-items: stretch;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
            /* Removed max-width and margin:auto here, as parent main-content-wrapper handles it */
            width: 100%; /* Take full width of its centered parent */
            box-sizing: border-box; /* Ensure padding is included in width */
        }

        .hero-section,
        .new-arrivals-section {
            flex: 1;
            min-width: 350px;
            max-width: calc(50% - 10px); /* 50% minus half of gap */
            padding: 25px;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .hero-section {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-text-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .hero-text {
            font-size: 1.3em;
            font-weight: bold;
            line-height: 1.4;
            text-align: center;
        }

        .new-arrivals-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .section-title-small {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .new-arrival-images {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .new-arrival-image {
            width: 80px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* --- Book Grid Layout --- */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 35px;
            padding: 10px 0;
            margin-bottom: 40px;
            /* Removed max-width and margin:auto here, as parent main-content-wrapper handles it */
            width: 100%; /* Take full width of its centered parent */
            box-sizing: border-box;
        }

        .book-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .book-image {
            max-width: 180px;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .book-title {
            font-size: 1.3em;
            font-weight: bold;
            height: 3.4em;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .star-rating {
            display: flex;
            gap: 3px;
            margin-bottom: 15px;
        }

        .star-rating .star {
            width: 20px;
            height: 20px;
        }

        .detail-button {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            color: white;
        }

        /* Search Floating Action Button (FAB) */
        .search-fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s ease, transform 0.2s ease;
            z-index: 999;
        }

        .search-fab .icon {
            width: 32px;
            height: 32px;
            filter: invert(100%);
        }

        /* --- Responsive Design (Media Queries) --- */

        /* Tablets and smaller laptops (e.g., 768px to 1024px) */
        @media (max-width: 1024px) {
            .main-content-wrapper {
                /* Adjust max-width and margin for better centering with smaller screens */
                max-width: calc(100% - 200px); /* Example: 100% - 200px from sidebar default + some extra margin */
                margin-left: auto;
                margin-right: auto;
            }
            .dashboard.sidebar-collapsed .main-content-wrapper {
                max-width: calc(100% - 100px); /* Example: 100% - 70px sidebar + some extra margin */
            }

            .SELAMAT-DATANG-DI {
                font-size: 2.2em;
            }

            .section-title {
                font-size: 1.9em;
            }

            .hero-section,
            .new-arrivals-section {
                min-width: 300px;
                max-width: calc(50% - 10px);
                padding: 20px;
            }

            .hero-text {
                font-size: 1.2em;
            }

            .section-title-small {
                font-size: 1.3em;
            }

            .new-arrival-image {
                width: 65px;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 25px;
            }

            .book-image {
                max-width: 140px;
            }

            .book-title {
                font-size: 1.2em;
                height: 3.2em;
            }
        }

        /* Smaller tablets and large phones (e.g., 480px to 767px) */
        @media (max-width: 767px) {
            .main-content-wrapper {
                margin-left: 70px;
                padding-right: 15px;
                max-width: calc(100% - 70px); /* Fill remaining space after collapsed sidebar */
                margin-left: auto; /* Center when sidebar is collapsed */
                margin-right: auto; /* Center when sidebar is collapsed */
            }

            .main-content {
                padding: 15px 0 15px 0; /* Remove left padding for full content width within wrapper */
            }

            .SELAMAT-DATANG-DI {
                font-size: 2em;
                text-align: center;
            }

            .section-title {
                font-size: 1.7em;
                text-align: center;
            }

            .top-content-flex {
                flex-direction: column;
                align-items: center;
                gap: 25px;
                width: 90%; /* Provide some fixed margin on small screens */
                margin-left: auto;
                margin-right: auto;
            }

            .hero-section,
            .new-arrivals-section {
                max-width: 100%; /* Take full width of its parent */
                min-width: unset;
                padding: 20px;
            }

            .hero-text {
                font-size: 1.1em;
            }

            .new-arrival-images {
                justify-content: space-around;
            }

            .new-arrival-image {
                width: 70px;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 20px;
                width: 90%; /* Provide some fixed margin on small screens */
                margin-left: auto;
                margin-right: auto;
            }

            .book-image {
                max-width: 100px;
            }

            .book-title {
                font-size: 1em;
                height: 2.8em;
            }

            .detail-button {
                padding: 8px 15px;
                font-size: 0.95em;
            }

            .search-fab {
                width: 60px;
                height: 60px;
                bottom: 25px;
                right: 25px;
            }

            .search-fab .icon {
                width: 28px;
                height: 28px;
            }
        }

        /* Very small screens/mobile (e.g., up to 479px) */
        @media (max-width: 479px) {
            .main-content-wrapper {
                padding-right: 10px;
            }

            .main-content {
                padding: 10px 0 10px 0;
            }

            .SELAMAT-DATANG-DI {
                font-size: 1.7em;
            }

            .section-title {
                font-size: 1.5em;
            }

            .top-content-flex {
                width: 95%; /* Even narrower fixed margin */
            }

            .hero-section,
            .new-arrivals-section {
                padding: 15px;
                max-width: 98%;
            }

            .hero-text {
                font-size: 0.95em;
            }

            .new-arrival-images {
                gap: 10px;
            }

            .new-arrival-image {
                width: 55px;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
                gap: 15px;
                width: 95%; /* Even narrower fixed margin */
            }

            .book-image {
                max-width: 75px;
            }

            .book-title {
                font-size: 0.9em;
                height: 2.5em;
            }

            .detail-button {
                padding: 7px 12px;
                font-size: 0.85em;
            }

            .search-fab {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
            }

            .search-fab .icon {
                width: 24px;
                height: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php include 'sidebar.php'; // Sidebar included here ?>

        <div class="main-content-wrapper">
            <div class="main-content">
                <h1 class="SELAMAT-DATANG-DI">SELAMAT DATANG, DI LIBRARY NURA!</h1>

                <div class="top-content-flex">
                    <div class="hero-section">
                        <div class="hero-text-container">
                            <p class="hero-text">Membaca bukan sekadar buku, tapi tentang tumbuh dan bersinar</p>
                        </div>
                    </div>

                    <div class="new-arrivals-section">
                        <h2 class="section-title-small">New Arrivals</h2>
                        <div class="new-arrival-images">
                            <?php foreach ($books['new_arrivals'] as $book): ?>
                                <a href="detail_buku.php?id=<?= htmlspecialchars($book['id']) ?>"><img class="new-arrival-image" src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['alt']) ?>" /></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?php echo renderBookSection('Bacaan Terpopuler', $books['popular_reads']); ?>

                <?php echo renderBookSection('Rekomendasi Untuk Anda', $books['recommended_for_you']); ?>

                <?php echo renderBookSection('Fiksi', $books['fiction']); ?>

                <a href="search_page.php" class="search-fab">
                    <div class="state-layer">
                        <img class="icon" src="img/icon.svg" alt="Search Icon" />
                    </div>
                </a>
            </div>

            <?php include 'footer.php'; // Footer included here ?>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const dashboardContainer = document.querySelector(".dashboard");

            function updateMainContentMargin() {
                if (sidebar && sidebar.classList.contains("collapsed")) {
                    dashboardContainer.classList.add("sidebar-collapsed");
                } else {
                    dashboardContainer.classList.remove("sidebar-collapsed");
                }
            }

            updateMainContentMargin();

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "class") {
                        updateMainContentMargin();
                    }
                });
            });

            if (sidebar) {
                observer.observe(sidebar, { attributes: true });
            }

            if (localStorage.getItem("sidebarCollapsed") === "true") {
                if (sidebar) {
                    sidebar.classList.add("collapsed");
                }
                dashboardContainer.classList.add("sidebar-collapsed");
            }
        });
    </script>
</body>
</html>