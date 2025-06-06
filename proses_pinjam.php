<?php
session_start();

// --- DATA BUKU DUMMY (STATIS DALAM ARRAY) ---
// Data ini tidak akan persisten (tidak disimpan setelah refresh halaman)
$dummyBooks = [
    'B001' => ['title' => 'Mimpi Anak Negeri', 'author' => 'Andrea Hirata', 'stock' => 5],
    'B002' => ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'stock' => 3],
    'B003' => ['title' => 'Filosofi Kopi', 'author' => 'Dee Lestari', 'stock' => 2],
    'B004' => ['title' => 'Bumi', 'author' => 'Tere Liye', 'stock' => 0], // Contoh buku habis
];

// --- LOGIKA CEK STATUS LOGIN ---
// Diasumsikan bahwa ketika pengguna login, Anda menyimpan sesuatu di $_SESSION,
// misalnya $_SESSION['user_id'] atau $_SESSION['logged_in'] = true.
$is_logged_in = isset($_SESSION['user_id']); // Atau Anda bisa pakai $_SESSION['logged_in']
$current_user_id = $is_logged_in ? $_SESSION['user_id'] : null;

// Jika pengguna belum login, arahkan ke halaman login
if (!$is_logged_in) {
    // Anda bisa menambahkan pesan di session agar halaman login tahu kenapa diarahkan
    $_SESSION['redirect_message'] = 'Anda harus login terlebih dahulu untuk meminjam buku.';
    header('Location: login.php'); // Arahkan ke halaman login Anda
    exit; // Penting untuk menghentikan eksekusi skrip setelah redirect
}

// --- Data Pengguna Dummy (untuk tampilan header, asumsikan sudah login) ---
// Jika sudah login, user_name bisa diambil dari session atau database
// Untuk tujuan demonstrasi ini, kita tetap pakai dummy
$user_name = "Tuan Putri Nura"; 

// Jika ini adalah request AJAX untuk mendapatkan detail buku (tanpa database)
if (isset($_GET['action']) && $_GET['action'] === 'get_book_details' && isset($_GET['book_id'])) {
    header('Content-Type: application/json');

    $book_id = strtoupper($_GET['book_id']); // Konversi ke uppercase untuk match key array
    
    if (isset($dummyBooks[$book_id])) {
        // Cek stok, jika 0 anggap tidak ditemukan juga untuk peminjaman
        if ($dummyBooks[$book_id]['stock'] > 0) {
            echo json_encode(['success' => true, 'data' => $dummyBooks[$book_id]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Buku ada, tapi stok kosong.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Buku tidak ditemukan.']);
    }
    exit;
}

// Jika ini adalah request AJAX untuk memproses peminjaman (tanpa database)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'process_loan') {
    header('Content-Type: application/json');

    // Pastikan pengguna masih login saat request AJAX ini
    if (!$is_logged_in) {
        echo json_encode(['success' => false, 'message' => 'Sesi Anda telah berakhir. Mohon login kembali.']);
        exit;
    }

    $book_id = strtoupper($_POST['book_id']);
    $return_date = $_POST['return_date'];
    $loan_date = date('Y-m-d'); // Tanggal peminjaman hari ini

    // Validasi data (contoh sederhana)
    if (empty($book_id) || empty($return_date)) {
        echo json_encode(['success' => false, 'message' => 'ID Buku dan Tanggal Kembali harus diisi.']);
        exit;
    }

    // Simulasi pemeriksaan stok dan peminjaman
    if (isset($dummyBooks[$book_id])) {
        if ($dummyBooks[$book_id]['stock'] > 0) {
            // Pada mode tanpa database, kita tidak benar-benar mengurangi stok
            // Tapi kita bisa mensimulasikan bahwa peminjaman berhasil
            echo json_encode(['success' => true, 'message' => 'Peminjaman buku "' . $dummyBooks[$book_id]['title'] . '" berhasil!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Stok buku "' . $dummyBooks[$book_id]['title'] . '" kosong.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Buku dengan ID "' . $book_id . '" tidak ditemukan.']);
    }
    exit;
}

// Jika bukan request AJAX dan sudah login, tampilkan halaman HTML
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Peminjaman Buku - Perpustakaan Nura</title>
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/peminjaman.css" /> </head>
<body class="sidebar-open">
    <div class="app-container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content-area">
            <?php // Header dipanggil di sini. Tidak perlu conditional lagi karena sudah di-redirect di atas. ?>
            <header class="main-header">
                <a href="profile.php" class="profile-button-header-round" title="Lihat Profil">
                    <img src="img/default-profile.png" alt="Profil">
                </a>
            </header> 
            <main class="main-content">
                <div class="peminjaman-buku-content-wrapper">
                    <h1 class="page-title">Peminjaman Buku</h1>

                    <section class="book-loan-card">
                        <form id="loanForm" class="loan-form-grid">
                            <div class="form-group">
                                <label for="book-id">ID Buku</label>
                                <input type="text" id="book-id" name="book_id" placeholder="Cari atau masukkan ID Buku" required autocomplete="off" />
                                <div id="book-suggestions" class="suggestions-box"></div>
                            </div>
                            <div class="form-group">
                                <label for="book-name">Nama Buku</label>
                                <input type="text" id="book-name" name="book_name" placeholder="Nama buku akan terisi otomatis" readonly />
                            </div>
                            <div class="form-group">
                                <label for="book-author">Penulis Buku</label>
                                <input type="text" id="book-author" name="book_author" placeholder="Penulis buku akan terisi otomatis" readonly />
                            </div>
                            <div class="form-group">
                                <label for="return-date">Tanggal Kembali</label>
                                <input type="date" id="return-date" name="return_date" required />
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="submit-btn">Pinjam sekarang</button>
                            </div>
                        </form>

                        <div class="confirmation-message" style="display: none;">
                            <h2>TERIMA KASIH TELAH MEMINJAM BUKU!</h2>
                            <p>Selamat Membaca!</p>
                            <button class="back-to-home-btn">Kembali ke Beranda</button>
                        </div>
                        <div class="error-message" style="display: none;">
                            <p id="error-text"></p>
                            <button class="try-again-btn">Coba Lagi</button>
                        </div>
                    </section>
                </div>
            </main>
            <?php include 'footer.php'; ?>
        </div>
    </div>
    <script src="js/sidebar-toggle.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loanForm = document.getElementById('loanForm');
            const confirmationMessage = document.querySelector('.confirmation-message');
            const errorMessage = document.querySelector('.error-message');
            const errorText = document.getElementById('error-text');
            const backToHomeBtn = document.querySelector('.back-to-home-btn');
            const tryAgainBtn = document.querySelector('.try-again-btn');
            const bookIdInput = document.getElementById('book-id');
            const bookNameInput = document.getElementById('book-name');
            const bookAuthorInput = document.getElementById('book-author');
            const returnDateInput = document.getElementById('return-date');
            const bookSuggestions = document.getElementById('book-suggestions');

            // Set min date for return date to today
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            returnDateInput.min = `${yyyy}-${mm}-${dd}`;

            // Function to reset form and messages
            const resetForm = () => {
                loanForm.reset();
                bookNameInput.value = '';
                bookAuthorInput.value = '';
                loanForm.style.display = 'grid';
                confirmationMessage.style.display = 'none';
                errorMessage.style.display = 'none';
                bookSuggestions.innerHTML = '';
            };

            // Event listener for book ID input (auto-fill based on dummy data)
            let debounceTimer;
            bookIdInput.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const query = bookIdInput.value.trim();
                    if (query.length > 0) {
                        fetch(`peminjaman.php?action=get_book_details&book_id=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && data.data) {
                                    bookNameInput.value = data.data.title;
                                    bookAuthorInput.value = data.data.author;
                                    bookSuggestions.innerHTML = ''; // Clear suggestions if exact match
                                } else {
                                    bookNameInput.value = '';
                                    bookAuthorInput.value = '';
                                    bookSuggestions.innerHTML = `<div class="suggestion-item">${data.message || 'Buku tidak ditemukan.'}</div>`;
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching book details:', error);
                                bookNameInput.value = '';
                                bookAuthorInput.value = '';
                                bookSuggestions.innerHTML = `<div class="suggestion-item">Terjadi kesalahan.</div>`;
                            });
                    } else {
                        bookNameInput.value = '';
                        bookAuthorInput.value = '';
                        bookSuggestions.innerHTML = '';
                    }
                }, 300); // Debounce for 300ms
            });

            // Handle form submission
            loanForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const formData = new FormData(loanForm);
                formData.append('action', 'process_loan'); // Memberi tahu PHP untuk memproses peminjaman

                fetch('peminjaman.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loanForm.style.display = 'none';
                        confirmationMessage.style.display = 'block';
                        errorMessage.style.display = 'none';
                    } else {
                        loanForm.style.display = 'none';
                        confirmationMessage.style.display = 'none';
                        errorMessage.style.display = 'block';
                        errorText.textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Error during loan process:', error);
                    loanForm.style.display = 'none';
                    confirmationMessage.style.display = 'none';
                    errorMessage.style.display = 'block';
                    errorText.textContent = 'Terjadi kesalahan jaringan atau server. Silakan coba lagi.';
                });
            });

            // Back to Home button
            backToHomeBtn.addEventListener('click', () => {
                window.location.href = 'index.php'; // Ganti dengan halaman beranda Anda
            });

            // Try Again button
            tryAgainBtn.addEventListener('click', () => {
                resetForm();
            });
        });
    </script>
</body>
</html>