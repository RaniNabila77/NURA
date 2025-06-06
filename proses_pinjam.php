<?php
session_start();

// --- LOGIKA CEK STATUS LOGIN ---
// Diasumsikan bahwa ketika pengguna login, Anda menyimpan sesuatu di $_SESSION,
// misalnya $_SESSION['user_id'] atau $_SESSION['logged_in'] = true.
$is_logged_in = isset($_SESSION['user_id']); // Atau Anda bisa pakai $_SESSION['logged_in']
$current_user_id = $is_logged_in ? $_SESSION['user_id'] : null;

// Jika pengguna belum login, arahkan ke halaman login
if (!$is_logged_in) {
    // Anda bisa menambahkan pesan di session agar halaman login tahu kenapa diarahkan
    $_SESSION['redirect_message'] = 'Anda harus login terlebih dahulu untuk meminjam buku.';
    // Simpan URL saat ini agar bisa redirect kembali setelah login
    $_SESSION['redirect_message_after_login'] = 'peminjaman.php'; // Atau URL lengkap jika perlu

    header('Location: login.php'); // Arahkan ke halaman login Anda
    exit; // Penting untuk menghentikan eksekusi skrip setelah redirect
}

// ... (sisa kode peminjaman.php Anda) ...
// Jika sudah login, user_name bisa diambil dari session
$user_name = $_SESSION['user_name'] ?? "Pengguna"; // Ambil dari session yang diset di login.php

// Data Pengguna Dummy (untuk tampilan header, asumsikan sudah login)
// Dalam aplikasi nyata, Anda akan ambil ini dari database berdasarkan $current_user_id
$allUserData = [
    'user123' => [
        'id' => 'user123',
        'nama' => 'Nura',
        'nama_lengkap' => 'Nura Aulia Fitri',
        'avatar' => 'img/default-profile.png', // Pastikan path ini benar
    ],
];
$user_avatar = $allUserData[$current_user_id]['avatar'] ?? 'img/default-profile.png';


// ... (sisa kode peminjaman.php Anda tetap sama) ...
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Peminjaman Buku - Perpustakaan Nura</title>
     <link rel="stylesheet" href="css/Peminjaman.css" /> 
    <link rel="stylesheet" href="css/style.css" />
    <!-- <link rel="stylesheet" href="css/main.css" /> -->

</head>
<body class="sidebar-open">
    <div id="dashboard-container" class="app-container"> <?php include 'sidebar.php'; ?>
        <div class="main-content"> <header class="main-header">
                <h1 class="page-main-title">Peminjaman Buku</h1>
                <div class="search-profile-section">
                    <a href="profile.php" class="profile-button-header-round" title="Lihat Profil">
                        <img src="<?php echo htmlspecialchars($user_avatar); ?>" alt="Profil">
                    </a>
                </div>
            </header> 
            <main class="page-content-area"> <div class="peminjaman-buku-content-wrapper">
                    <h2 class="page-title">Formulir Peminjaman</h2> <section class="book-loan-card">
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const dashboardContainer = document.getElementById('dashboard-container');
            const sidebarToggle = sidebar ? sidebar.querySelector("#sidebar-toggle") : null;

            function applySidebarState(isCollapsed) {
                if (sidebar && dashboardContainer) {
                    if (isCollapsed) {
                        sidebar.classList.add("collapsed");
                        dashboardContainer.classList.add("sidebar-collapsed");
                        if (sidebarToggle) sidebarToggle.style.transform = 'rotate(180deg)';
                    } else {
                        sidebar.classList.remove("collapsed");
                        dashboardContainer.classList.remove("sidebar-collapsed");
                        if (sidebarToggle) sidebarToggle.style.transform = 'rotate(0deg)';
                    }
                }
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", function() {
                    const isCurrentlyCollapsed = sidebar.classList.contains("collapsed");
                    applySidebarState(!isCurrentlyCollapsed);
                    localStorage.setItem("sidebarCollapsed", !isCurrentlyCollapsed);
                });
            }

            const savedState = localStorage.getItem("sidebarCollapsed");
            if (savedState !== null) {
                applySidebarState(savedState === "true");
            } else {
                applySidebarState(false); // Default to open
            }

            // --- Logika Peminjaman Buku (AJAX) ---
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
                window.location.href = 'dashboard.php'; // Ganti dengan halaman beranda Anda
            });

            // Try Again button
            tryAgainBtn.addEventListener('click', () => {
                resetForm();
            });
        });
    </script>
</body>
</html>
