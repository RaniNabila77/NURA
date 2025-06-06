<?php
// data_buku.php
// File ini hanya berisi array data buku

$allBooksData = [
    'atomic_habits' => [
        'id_buku' => '00829',
        'judul' => 'ATOMIC HABITS',
        'author' => 'JAMES CLEAR',
        'penerbit' => 'AVERY',
        'genre' => 'PSIKOLOGY',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/atomichabits.jpeg', // Sesuaikan path gambar
        'deskripsi' => 'Atomic Habits menjelaskan bagaimana perubahan kecil dalam kebiasaan sehari-hari dapat menghasilkan hasil yang luar biasa dalam jangka panjang. James Clear menawarkan pendekatan sistematis untuk membentuk kebiasaan baik dan menghentikan kebiasaan buruk melalui pemahaman ilmiah tentang perilaku manusia. Buku ini dilengkapi dengan strategi praktis yang mudah diterapkan, seperti hukum membentuk kebiasaban, kekuatan lingkungan, serta pentingnya sistem dibandingkan tujuan. Cocok untuk siapa saja yang ingin meningkatkan produktivitas, fokus, kesehatan, atau aspek lainnya dalam hidup secara konsisten dan berkelanjutan.',
        'average_rating' => 4.5,
        'rating_count' => 60,
        'reviews' => [
            [
                'reviewer_name' => 'Aliya Ramadani',
                'review_text' => 'Atomic Habits adalah buku yang wajib dibaca! Penjelasannya jelas dan mudah dipahami. Saya merasa termotivasi untuk membentuk kebiasaban positif.',
                'review_date' => '01/05/2025',
                'rating' => 5
            ],
            [
                'reviewer_name' => 'Budi Santoso',
                'review_text' => 'Sangat membantu untuk mengubah perspektif tentang kebiasaan. Beberapa bab agak repetitif, tapi intinya sangat kuat.',
                'review_date' => '15/04/2025',
                'rating' => 4
            ],
            [
                'reviewer_name' => 'Citra Lestari',
                'review_text' => 'Buku yang bagus, memberikan banyak insight praktis. Sudah mulai menerapkan beberapa tipsnya.',
                'review_date' => '10/04/2025',
                'rating' => 4
            ],
            [
                'reviewer_name' => 'Dewi Anggraini',
                'review_text' => 'Konsepnya sederhana tapi dampaknya besar. Sangat direkomendasikan untuk pengembangan diri.',
                'review_date' => '05/04/2025',
                'rating' => 5
            ],
            [
                'reviewer_name' => 'Eko Prasetyo',
                'review_text' => 'Salah satu buku self-help terbaik yang pernah saya baca. Mudah dicerna dan actionable.',
                'review_date' => '02/04/2025',
                'rating' => 5
            ]
        ]
    ],
    // --- START BUKU TAMBAHAN (Pastikan semua ada di sini) ---
    'agama_untuk_peradaban' => [
        'id_buku' => '00101',
        'judul' => 'AGAMA UNTUK PERADABAN',
        'author' => 'NURCHOLISH MADJID',
        'penerbit' => 'PARAMADINA',
        'genre' => 'FILOSOFI, AGAMA',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/agamauntukperadaban.jpeg', // Contoh path gambar
        'deskripsi' => 'Agama untuk Peradaban adalah kumpulan esai dan pemikiran Nurcholish Madjid (Cak Nur) yang membahas peran agama dalam membangun peradaban modern yang inklusif, toleran, dan maju. Cak Nur menekankan pentingnya pemahaman agama yang kontekstual dan substantif, bukan formalistik, untuk menghadapi tantangan zaman. Buku ini mengajak pembaca untuk merefleksikan kembali nilai-nilai keagamaan sebagai fondasi etika dan moral dalam kehidupan bermasyarakat dan bernegara, serta sebagai pendorong kemajuan ilmu pengetahuan dan kebudayaan.',
        'average_rating' => 4.7,
        'rating_count' => 45,
        'reviews' => [
            ['reviewer_name' => 'Fajarudin', 'review_text' => 'Pemikiran Cak Nur selalu relevan dan mencerahkan. Buku ini wajib dibaca untuk memahami peran agama di era modern.', 'review_date' => '20/03/2025', 'rating' => 5],
            ['reviewer_name' => 'Gina Lestari', 'review_text' => 'Mengajak kita untuk berpikir kritis tentang agama dan peradaban. Sangat inspiratif!', 'review_date' => '05/02/2025', 'rating' => 5],
        ]
    ],
    'dongeng_kancil' => [
        'id_buku' => '00202',
        'judul' => 'DONGENG KANCIL',
        'author' => 'ANONIM', // Atau penulis koleksi jika ada
        'penerbit' => 'GRAMEDIA PUSTAKA UTAMA',
        'genre' => 'ANAK, CERITA RAKYAT',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/dongengkancil.jpeg',
        'deskripsi' => 'Dongeng Kancil adalah kumpulan cerita rakyat populer yang mengisahkan petualangan Si Kancil, seekor hewan cerdik yang selalu berhasil mengatasi masalah dengan kecerdikannya. Cerita-cerita ini tidak hanya menghibur tetapi juga mengandung pesan moral dan pelajaran hidup yang cocok untuk anak-anak. Melalui tokoh Kancil, pembaca diajarkan tentang pentingnya akal, keberanian, dan cara menyelesaikan konflik dengan bijaksana.',
        'average_rating' => 4.2,
        'rating_count' => 80,
        'reviews' => [
            ['reviewer_name' => 'Hani Nurani', 'review_text' => 'Anak saya suka sekali! Gambar-gambarnya menarik dan ceritanya mudah dipahami.', 'review_date' => '10/04/2025', 'rating' => 4],
            ['reviewer_name' => 'Iman Budiman', 'review_text' => 'Nostalgia masa kecil. Pesan moralnya masih relevan.', 'review_date' => '25/03/2025', 'rating' => 4],
        ]
    ],
    'detektif_conan' => [
        'id_buku' => '00303',
        'judul' => 'DETEKTIF CONAN',
        'author' => 'GOSHO AOYAMA',
        'penerbit' => 'ELEX MEDIA KOMPUTINDO',
        'genre' => 'MANGA, MISTERI',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/detektifconan.jpeg',
        'deskripsi' => 'Detektif Conan mengisahkan Shinichi Kudo, seorang detektif SMA terkenal yang secara misterius diracuni oleh Organisasi Hitam hingga tubuhnya mengecil menjadi anak-anak. Dengan identitas baru sebagai Conan Edogawa, ia terus memecahkan kasus-kasus kriminal sambil berusaha menemukan penawar dan mengungkap misteri organisasi tersebut. Manga ini penuh dengan teka-teki cerdas, plot twist mendebarkan, dan karakter-karakter unik.',
        'average_rating' => 4.8,
        'rating_count' => 120,
        'reviews' => [
            ['reviewer_name' => 'Joko Susilo', 'review_text' => 'Salah satu manga misteri terbaik! Selalu bikin penasaran.', 'review_date' => '01/05/2025', 'rating' => 5],
            ['reviewer_name' => 'Kiki Amalia', 'review_text' => 'Koleksi lengkap Conan di perpustakaan ini sangat membantu. Ceritanya tidak pernah membosankan.', 'review_date' => '18/04/2025', 'rating' => 5],
        ]
    ],
    'rich_dad_poor_dad' => [
        'id_buku' => '00404',
        'judul' => 'RICH DAD POOR DAD',
        'author' => 'ROBERT KIYOSAKI',
        'penerbit' => 'GRAMEDIA PUSTAKA UTAMA',
        'genre' => 'KEUANGAN PRIBADI, PENDIDIKAN',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/richdad.jpeg',
        'deskripsi' => 'Rich Dad Poor Dad adalah buku klasik tentang literasi keuangan yang menantang pandangan tradisional tentang uang. Robert Kiyosaki membandingkan pelajaran keuangan yang ia dapat dari "ayah kaya" (teman ayahnya yang sukses) dan "ayah miskin" (ayah kandungnya yang berpendidikan tinggi namun kurang sukses secara finansial). Buku ini mengajarkan pentingnya investasi, memiliki aset, dan membangun kecerdasan finansial untuk mencapai kebebasan finansial.',
        'average_rating' => 4.6,
        'rating_count' => 95,
        'reviews' => [
            ['reviewer_name' => 'Linda Permata', 'review_text' => 'Membuka wawasan tentang cara mengelola keuangan. Sangat direkomendasikan untuk semua orang!', 'review_date' => '03/05/2025', 'rating' => 5],
            ['reviewer_name' => 'Maman S.', 'review_text' => 'Beberapa konsepnya agak sulit dicerna tapi intinya sangat kuat untuk mengubah mindset.', 'review_date' => '20/04/2025', 'rating' => 4],
        ]
    ],
    'kamus_lengkap' => [
        'id_buku' => '00505',
        'judul' => 'KAMUS LENGKAP',
        'author' => 'TIM PENYUSUN',
        'penerbit' => 'PUSTAKA BARU PRESS',
        'genre' => 'REFERENSI, BAHASA',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/kamus.jpeg',
        'deskripsi' => 'Kamus Lengkap adalah sumber referensi esensial yang memuat ribuan entri kata dari berbagai bidang, dilengkapi dengan definisi yang jelas, contoh penggunaan, sinonim, dan antonim. Kamus ini dirancang untuk membantu pengguna dalam memahami kosakata, meningkatkan kemampuan berbahasa, dan menjadi alat bantu yang praktis untuk belajar atau bekerja. Mencakup berbagai istilah umum maupun khusus.',
        'average_rating' => 4.0,
        'rating_count' => 30,
        'reviews' => [
            ['reviewer_name' => 'Nina Kartika', 'review_text' => 'Sangat membantu untuk pekerjaan. Lengkap dan mudah dicari.', 'review_date' => '15/03/2025', 'rating' => 4],
            ['reviewer_name' => 'Otong Supratman', 'review_text' => 'Versi cetak masih sangat berguna, apalagi saat tidak ada internet.', 'review_date' => '01/03/2025', 'rating' => 4],
        ]
    ],
    'dasar_dasar_kriptografi' => [
        'id_buku' => '00606',
        'judul' => 'DASAR-DASAR KRIPTOGRAFI',
        'author' => 'BRUCE SCHNEIER', // Atau penulis lain yang relevan
        'penerbit' => 'PENERBIT X',
        'genre' => 'TEKNOLOGI, ILMU KOMPUTER',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/kriptografi.jpeg',
        'deskripsi' => 'Buku Dasar-Dasar Kriptografi memperkenalkan konsep fundamental dan teknik-teknik dalam kriptografi, ilmu yang mempelajari metode-metode untuk menjaga kerahasiaan informasi. Pembaca akan memahami prinsip-prinsip enkripsi, dekripsi, hash function, tanda tangan digital, dan protokol keamanan jaringan. Buku ini cocok untuk mahasiswa ilmu komputer, praktisi IT, dan siapa saja yang tertarik pada keamanan siber dan perlindungan data.',
        'average_rating' => 4.4,
        'rating_count' => 55,
        'reviews' => [
            ['reviewer_name' => 'Pramudya', 'review_text' => 'Penjelasan yang komprehensif, cocok untuk pemula di bidang kriptografi.', 'review_date' => '22/04/2025', 'rating' => 4],
            ['reviewer_name' => 'Qonita', 'review_text' => 'Topik yang kompleks dijelaskan dengan baik. Sangat direkomendasikan untuk mendalami cybersecurity.', 'review_date' => '08/04/2025', 'rating' => 5],
        ]
    ],
    'perahu_kertas' => [
        'id_buku' => '00707',
        'judul' => 'PERAHU KERTAS',
        'author' => 'DEE LESTARI',
        'penerbit' => 'GRAMEDIA PUSTAKA UTAMA',
        'genre' => 'FIKSI, ROMAN',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/perahukertas.jpeg',
        'deskripsi' => 'Perahu Kertas adalah novel romansa yang mengharukan karya Dee Lestari. Mengisahkan tentang Keenan, seorang seniman berbakat, dan Kugy, seorang penulis dongeng yang berjiwa bebas. Keduanya bertemu dan menemukan kecocokan di tengah perbedaan cita-cita dan jalan hidup. Novel ini menggambarkan perjuangan mengejar impian, persahabatan, cinta, dan takdir yang saling berkaitan dalam balutan kisah yang penuh makna.',
        'average_rating' => 4.3,
        'rating_count' => 70,
        'reviews' => [
            ['reviewer_name' => 'Rina Wijaya', 'review_text' => 'Novel yang sangat indah, bikin baper dan banyak pelajaran hidup.', 'review_date' => '07/05/2025', 'rating' => 5],
            ['reviewer_name' => 'Santi Devi', 'review_text' => 'Sudah baca berkali-kali, tidak pernah bosan. Salah satu novel terbaik Dee Lestari.', 'review_date' => '25/04/2025', 'rating' => 4],
        ]
    ],
    'fleeing_babylon' => [
        'id_buku' => '00808',
        'judul' => 'FLEEING BABYLON',
        'author' => 'STEPHEN MANSFIELD', // Asumsi penulis yang relevan untuk topik ini
        'penerbit' => 'PENERBIT Y',
        'genre' => 'SPIRITUAL, SOSIAL',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/fleefrom.jpeg',
        'deskripsi' => 'Fleeing Babylon adalah buku yang mengajak pembaca untuk merefleksikan kembali nilai-nilai kehidupan di tengah hiruk pikuk dunia modern. Buku ini membahas konsep "Babylon" sebagai simbol sistem atau budaya yang materialistis dan menyesatkan, serta mendorong individu untuk mencari jalan keluar menuju kehidupan yang lebih bermakna, spiritual, dan autentik. Pembaca diajak untuk mengevaluasi prioritas hidup dan menemukan kedamaian batin.',
        'average_rating' => 4.1,
        'rating_count' => 40,
        'reviews' => [
            ['reviewer_name' => 'Tulus Adi', 'review_text' => 'Sangat menggugah pikiran, membuat saya introspeksi diri.', 'review_date' => '01/04/2025', 'rating' => 4],
            ['reviewer_name' => 'Umi Kulsum', 'review_text' => 'Buku yang penting di tengah era konsumerisme ini.', 'review_date' => '10/03/2025', 'rating' => 4],
        ]
    ],
    'ayo_kita_kejar_bintang_itu' => [
        'id_buku' => '00909',
        'judul' => 'AYO KITA KEJAR BINTANG ITU',
        'author' => 'FISCHER SPENCER', // Asumsi penulis
        'penerbit' => 'PENERBIT Z',
        'genre' => 'MOTIVASI, INSPIRASI',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/kejarbintang.jpeg',
        'deskripsi' => 'Ayo Kita Kejar Bintang Itu adalah buku motivasi yang mendorong pembaca untuk berani bermimpi besar dan tidak takut mengejar tujuan hidup. Dengan gaya bahasa yang inspiratif dan cerita-cerita nyata yang membakar semangat, buku ini memberikan langkah-langkah praktis dan strategi untuk mengatasi rintangan, membangun mentalitas positif, dan meraih potensi maksimal dalam diri. Sangat cocok bagi siapa saja yang membutuhkan dorongan untuk memulai perubahan.',
        'average_rating' => 4.6,
        'rating_count' => 65,
        'reviews' => [
            ['reviewer_name' => 'Vina Amelia', 'review_text' => 'Sangat memotivasi! Setelah membaca ini, saya jadi lebih berani mengambil langkah.', 'review_date' => '12/05/2025', 'rating' => 5],
            ['reviewer_name' => 'Wawan Darmawan', 'review_text' => 'Memberi banyak energi positif, cocok dibaca saat down.', 'review_date' => '28/04/2025', 'rating' => 4],
        ]
    ],
    'the_art_of_holding_on_and_letting_go' => [
        'id_buku' => '01010',
        'judul' => 'THE ART OF HOLDING ON AND LETTING GO',
        'author' => 'KRISTIN BARTLEY LENSEN', // Asumsi penulis
        'penerbit' => 'PENERBIT A',
        'genre' => 'FIKSI, KEHIDUPAN',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/artofholding.jpeg',
        'deskripsi' => 'The Art of Holding On and Letting Go adalah novel yang menggali tema-tema universal tentang kehilangan, penerimaan, dan kekuatan untuk melanjutkan hidup. Kisah ini mengikuti perjalanan karakter utama dalam menghadapi perubahan besar dan belajar bagaimana melepaskan hal-hal yang tidak bisa dipertahankan, sambil tetap menggenggam erat nilai-nilai dan kenangan yang membentuk dirinya. Sebuah narasi yang menyentuh dan memberikan inspirasi tentang resiliensi.',
        'average_rating' => 4.4,
        'rating_count' => 50,
        'reviews' => [
            ['reviewer_name' => 'Xena Putri', 'review_text' => 'Novel yang emosional dan penuh makna. Saya bisa relate dengan ceritanya.', 'review_date' => '05/05/2025', 'rating' => 4],
            ['reviewer_name' => 'Yudi Santoso', 'review_text' => 'Menyentuh hati, sangat bagus untuk refleksi diri.', 'review_date' => '20/04/2025', 'rating' => 5],
        ]
    ],
    'kehidupan_ketiga' => [
        'id_buku' => '01111',
        'judul' => 'KEHIDUPAN KETIGA',
        'author' => 'ACHMAD MUSTOFA BISRI', // Asumsi penulis
        'penerbit' => 'PENERBIT B',
        'genre' => 'SPIRITUAL, FILOSOFI',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/dimensiketiga.jpeg',
        'deskripsi' => 'Kehidupan Ketiga adalah sebuah karya yang mengajak pembaca merenungkan eksistensi manusia di luar dimensi materi dan spiritual. Buku ini menyajikan pandangan mendalam tentang pencarian makna hidup, hubungan antara dunia dan akhirat, serta bagaimana menjalani kehidupan yang seimbang dan berkah. Dengan gaya penulisan yang puitis dan penuh hikmah, buku ini menawarkan perspektif segar tentang perjalanan spiritual dan esensi keberadaan.',
        'average_rating' => 4.7,
        'rating_count' => 35,
        'reviews' => [
            ['reviewer_name' => 'Zahra F.', 'review_text' => 'Karya yang mencerahkan dari Gus Mus. Sangat dalam maknanya.', 'review_date' => '10/05/2025', 'rating' => 5],
            ['reviewer_name' => 'Abdurrahman', 'review_text' => 'Setiap kalimatnya mengandung hikmah. Harus dibaca perlahan untuk meresapi.', 'review_date' => '01/05/2025', 'rating' => 5],
        ]
    ],
    'bicara_itu_ada_seninya' => [
        'id_buku' => '01212',
        'judul' => 'BICARA ITU ADA SENINYA',
        'author' => 'OH SU HYANG',
        'penerbit' => 'ALEXANDRIA',
        'genre' => 'PENGEMBANGAN DIRI, KOMUNIKASI',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/bicaraseni.jpeg',
        'deskripsi' => 'Bicara Itu Ada Seninya adalah panduan praktis untuk meningkatkan kemampuan komunikasi dan berbicara di depan umum. Buku ini membahas berbagai teknik dan strategi, mulai dari cara menyusun pesan yang efektif, mengendalikan emosi, membaca audiens, hingga tips untuk berbicara dengan percaya diri dan persuasif. Ditulis dengan gaya yang mudah dipahami, buku ini sangat cocok bagi siapa saja yang ingin menjadi komunikator yang lebih baik dalam berbagai situasi.',
        'average_rating' => 4.5,
        'rating_count' => 90,
        'reviews' => [
            ['reviewer_name' => 'Bagas Putra', 'review_text' => 'Banyak tips yang sangat aplikatif, langsung saya coba dan hasilnya bagus!', 'review_date' => '02/05/2025', 'rating' => 5],
            ['reviewer_name' => 'Cindy Dewi', 'review_text' => 'Sangat membantu saya yang pemalu. Sekarang lebih berani bicara di depan umum.', 'review_date' => '19/04/2025', 'rating' => 4],
        ]
    ],
    'filosofi_teras' => [
        'id_buku' => '01313',
        'judul' => 'FILOSOFI TERAS',
        'author' => 'HENRY MANAMPIRAN',
        'penerbit' => 'PENERBIT BUKU KOMPAS',
        'genre' => 'FILOSOFI, PENGEMBANGAN DIRI',
        'jenis_buku' => 'HARD COPY',
        'status' => 'TERSEDIA',
        'cover_image' => 'img/filosofiteras.jpeg',
        'deskripsi' => 'Filosofi Teras memperkenalkan konsep Stoisisme, sebuah aliran filsafat Yunani kuno, ke dalam konteks kehidupan modern. Buku ini menjelaskan bagaimana prinsip-prinsip Stoisisme dapat membantu kita menghadapi tantangan hidup, mengelola emosi, dan menemukan ketenangan batin di tengah ketidakpastian. Dengan bahasa yang ringan dan contoh-contoh relevan, Henry Manampiring berhasil membuat filsafat yang kompleks menjadi mudah diakses dan diterapkan dalam kehidupan sehari-hari.',
        'average_rating' => 4.8,
        'rating_count' => 110,
        'reviews' => [
            ['reviewer_name' => 'Dian Kusuma', 'review_text' => 'Buku yang mengubah hidup! Panduan praktis untuk hidup lebih tenang dan bahagia.', 'review_date' => '08/05/2025', 'rating' => 5],
            ['reviewer_name' => 'Eko Prasetya', 'review_text' => 'Sangat mencerahkan, saya jadi lebih bijak dalam menyikapi masalah.', 'review_date' => '26/04/2025', 'rating' => 5],
        ]
    ],
    // --- END BUKU TAMBAHAN ---
];
?>
