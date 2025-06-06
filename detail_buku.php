<?php
// detail_buku.php
session_start();

// --- Sertakan file data buku yang terpusat ---
require_once 'data_buku.php'; // Sekarang $allBooksData berasal dari sini

// --- FUNGSI UNTUK MERENDER BINTANG (DISPLAY) ---
// Pastikan fungsi ini tetap di sini karena spesifik untuk display detail
function renderStarsDisplay($rating, $maxStars = 5) {
    $html = '';
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;

    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<img class="star-filled" src="img/Star.png" alt="Bintang Penuh" />'; // Gunakan Star.png untuk konsistensi dengan tampilan display
    }
    if ($halfStar && $fullStars < $maxStars) {
        $html .= '<img class="star-filled" src="img/Star.png" alt="Bintang Setengah" />'; // Atau img/Star-half.png jika ada
    }

    $currentFilled = $fullStars + ($halfStar ? 1 : 0);
    $emptyStars = $maxStars - $currentFilled;

    for ($i = 0; $i < $emptyStars; $i++) {
        $html .= '<img class="star-empty-display" src="img/image.svg" alt="Bintang Kosong" />';
    }
    return $html;
}

// --- Logika pengambilan data dan penanganan form tetap di sini ---
$book_id = $_GET['id'] ?? null; // Jangan beri default, biarkan kosong jika tidak ada ID

if (!$book_id || !isset($allBooksData[$book_id])) {
    // Redirect ke halaman not found atau tampilkan pesan error yang lebih baik
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 - Buku Tidak Ditemukan</h1>";
    echo "<p>Maaf, buku yang Anda cari tidak ada dalam sistem kami.</p>";
    echo "<a href='dashboard.php'>Kembali ke Dashboard</a>";
    exit;
}

$book = $allBooksData[$book_id]; // Ambil data buku yang spesifik

// --- PENANGANAN FORM SUBMISSION KOMENTAR & RATING (tetap sama) ---
$comment_message = '';
$message_type = ''; // 'success' atau 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_comment'])) {
        $user_rating = isset($_POST['user_rating_from_stars']) ? (int)$_POST['user_rating_from_stars'] : 0;
        $comment_text = isset($_POST['comment_textarea']) ? trim($_POST['comment_textarea']) : '';

        if (empty($comment_text)) {
            $comment_message = "Komentar tidak boleh kosong.";
            $message_type = 'error';
        } elseif ($user_rating < 1 || $user_rating > 5) {
            $comment_message = "Harap berikan rating bintang (1-5) sebelum mengirim komentar.";
            $message_type = 'error';
        } else {
            $new_review = [
                'reviewer_name' => 'Pengguna Anda',
                'review_text' => $comment_text,
                'review_date' => date('d/m/Y'),
                'rating' => $user_rating
            ];
            // Tambahkan ulasan ke data buku yang sedang ditampilkan (sementara)
            array_unshift($book['reviews'], $new_review);

            // Hitung ulang average rating
            $total_ratings = 0;
            $review_count = 0;
            foreach ($book['reviews'] as $rev) {
                $total_ratings += $rev['rating'];
                $review_count++;
            }
            $book['average_rating'] = $review_count > 0 ? $total_ratings / $review_count : 0;
            $book['rating_count'] = $review_count;

            $comment_message = "Ulasan dan rating (".htmlspecialchars($user_rating)." bintang) Anda telah berhasil dikirim!";
            $message_type = 'success';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/detail.css" />
    <title>Detail Buku | <?php echo htmlspecialchars($book['judul']); ?></title>
    <style>
        /* Gaya minimal tambahan jika belum ada di file CSS eksternal */
        .user-rating-stars img.star-input {
            cursor: pointer;
            width: 28px; /* Sesuaikan ukuran bintang input */
            height: 28px;
            margin: 0 2px;
        }
        .star-empty-display {
            opacity: 0.4; /* Contoh style untuk bintang kosong pada display rating */
            filter: grayscale(1);
        }
        .comment-feedback {
            margin-bottom: 15px;
            padding: 12px 15px;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .comment-feedback.success {
            background-color: #e6ffed; color: #006422; border: 1px solid #9fddb3;
        }
        .comment-feedback.error {
            background-color: #ffebeb; color: #d32f2f; border: 1px solid #ffcdd2;
        }
        /* Gaya untuk metadata buku agar lebih rapi */
        .book-metadata { line-height: 1.8; }
        .book-metadata dt {
            display: inline-block;
            width: 120px; /* Sesuaikan lebar label */
            font-weight: 600;
            color: #555;
        }
        .book-metadata dd {
            display: inline;
            margin-left: 0;
            color: #333;
        }
          /* Aturan untuk bintang display agar konsisten */
        .rating-stars img, .review-stars img {
            width: 20px; /* Ukuran standar bintang display */
            height: 20px;
            margin: 0 1px;
        }
        @media (max-width: 767px) {
            .user-rating-stars img.star-input { width: 25px; height: 25px; }
            .rating-stars img, .review-stars img { width: 18px; height: 18px;}
        }

    </style>
</head>
<body>
    <div class="dashboard" id="dashboard-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <header class="main-header">
                <?php
                $is_logged_in = true; // Ganti dengan logika status login Anda

                if ($is_logged_in) {
                    echo '<a href="profile_edit.php" class="profile-button-header-round" title="Edit Profil">';
                    echo '  <img src="img/default-profile.png" alt="Profil">'; // Ganti dengan path gambar profil Anda
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
                <div class="detail-buku-content">
                    <div class="book-info-section">
                        <div class="book-cover-area">
                            <img class="book-cover-image" src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover <?php echo htmlspecialchars($book['judul']); ?>" />
                        </div>
                        <div class="book-details-area">
                            <h1 class="section-title" style="margin-top:0;"><?php echo htmlspecialchars($book['judul']); ?></h1>
                            <dl class="book-metadata">
                                <div><dt>ID BUKU</dt><dd>: <?php echo htmlspecialchars($book['id_buku']); ?></dd></div>
                                <div><dt>AUTHOR</dt><dd>: <?php echo htmlspecialchars($book['author']); ?></dd></div>
                                <div><dt>PENERBIT</dt><dd>: <?php echo htmlspecialchars($book['penerbit']); ?></dd></div>
                                <div><dt>GENRE</dt><dd>: <?php echo htmlspecialchars($book['genre']); ?></dd></div>
                                <div><dt>JENIS BUKU</dt><dd>: <?php echo htmlspecialchars($book['jenis_buku']); ?></dd></div>
                                <div><dt>STATUS</dt><dd>: <?php echo htmlspecialchars($book['status']); ?></dd></div>
                            </dl>
                            <a href="proses_pinjam.php?id=<?php echo htmlspecialchars($book['id_buku']); ?>" class="borrow-button">Pinjam Sekarang</a>
                        </div>
                    </div>

                    <div class="book-description-section">
                        <h3 class="section-subtitle">Deskripsi Buku</h3>
                        <p class="book-description-text">
                            <?php echo nl2br(htmlspecialchars($book['deskripsi'])); ?>
                        </p>
                    </div>

                    <div class="rating-review-section">
                        <div class="book-rating-summary">
                            <div class="rating-value"><?php echo htmlspecialchars(number_format((float)$book['average_rating'], 1)); ?></div>
                            <div class="rating-stars">
                                <?php echo renderStarsDisplay($book['average_rating']); ?>
                            </div>
                            <div class="rating-count"><?php echo htmlspecialchars($book['rating_count']); ?> Ratings</div>
                        </div>

                        <div class="write-review-area">
                            <h3 class="section-subtitle">Beri Rating Buku Ini</h3>
                            <div class="user-rating-stars" id="userRatingInput">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <img class="star-input" src="img/image.svg" alt="Beri <?php echo $i; ?> bintang" data-value="<?php echo $i; ?>" />
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <div class="comment-input-section">
                        <h3 class="section-subtitle">Tambahkan Komentar dan Ulasan Anda</h3>
                        <?php if (!empty($comment_message)): ?>
                            <p class="comment-feedback <?php echo $message_type; ?>">
                                <?php echo $comment_message; ?>
                            </p>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . urlencode($book_id); ?>">
                            <input type="hidden" name="user_rating_from_stars" id="user_rating_from_stars_value" value="0">
                            <textarea class="comment-textarea" name="comment_textarea" placeholder="Tulis komentar atau ulasan Anda di sini..." rows="5" required></textarea>
                            <button type="submit" name="submit_comment" class="submit-comment-button">Kirim Ulasan</button>
                        </form>
                    </div>

                    <div class="book-reviews-list">
                        <h3 class="section-subtitle">Ulasan Pengguna (<?php echo count($book['reviews']); ?>)</h3>
                        <?php if (!empty($book['reviews'])): ?>
                            <?php foreach ($book['reviews'] as $review): ?>
                                <div class="review-card">
                                    <div class="reviewer-name"><?php echo htmlspecialchars($review['reviewer_name']); ?></div>
                                    <div class="review-rating-date">
                                        <div class="review-stars">
                                            <?php echo renderStarsDisplay($review['rating']); ?>
                                        </div>
                                        <div class="review-date"><?php echo htmlspecialchars($review['review_date']); ?></div>
                                    </div>
                                    <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Belum ada ulasan untuk buku ini. Jadilah yang pertama memberi ulasan!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script src="js/sidebar-toggle.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const starsContainer = document.getElementById('userRatingInput');
        if (starsContainer) {
            const stars = Array.from(starsContainer.querySelectorAll('.star-input'));
            const ratingValueForCommentInput = document.getElementById('user_rating_from_stars_value');
            let currentRating = 0;

            // Function to visually highlight stars
            function highlightStarsVisual(rating) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.src = 'img/star-filled.svg'; // Path to your filled star icon
                    } else {
                        star.src = 'img/image.svg'; // Path to your empty star icon
                    }
                });
            }

            // Initialize from input value if present (e.g., after failed validation submit)
            if (ratingValueForCommentInput && parseInt(ratingValueForCommentInput.value) > 0) {
                currentRating = parseInt(ratingValueForCommentInput.value);
                highlightStarsVisual(currentRating);
                if (starsContainer) starsContainer.classList.add('rated');
            }

            stars.forEach(star => {
                star.addEventListener('mouseover', function () {
                    if (!starsContainer.classList.contains('rated')) {
                        const hoverValue = parseInt(this.dataset.value);
                        highlightStarsVisual(hoverValue);
                    }
                });

                star.addEventListener('mouseout', function () {
                    if (!starsContainer.classList.contains('rated')) {
                       highlightStarsVisual(currentRating); // Revert to selected rating (or 0 if none)
                    }
                });

                star.addEventListener('click', function () {
                    currentRating = parseInt(this.dataset.value);
                    if (ratingValueForCommentInput) {
                        ratingValueForCommentInput.value = currentRating;
                    }
                    highlightStarsVisual(currentRating);
                    starsContainer.classList.add('rated');
                });
            });
        }
    });
    </script>
</body>
</html>