<?php
/**
 * ==========================================================================
 * E-PERPUS - MODERN LANDING PAGE VIEW
 * Professional Educational & Digital School Library
 * ==========================================================================
 */

// 1. Ambil data statistik & buku nyata dari database jika tersedia
$stats = [
    'buku'      => 1250,
    'siswa'     => 580,
    'transaksi' => 2840,
    'puas'      => '99.4%'
];

$books_showcase = [];

if (file_exists('config/cn_database.php')) {
    try {
        require_once 'config/cn_database.php';
        $db_instance = new Database();
        $db = $db_instance->getConnection();

        if ($db) {
            // Count total buku
            $q_buku = $db->query("SELECT COUNT(*) AS total FROM tb_data_buku");
            if ($q_buku && $row = $q_buku->fetch_assoc()) {
                if ($row['total'] > 0) {
                    $stats['buku'] = $row['total'];
                }
            }

            // Count total siswa
            $q_user = $db->query("SELECT COUNT(*) AS total FROM tb_user");
            if ($q_user && $row = $q_user->fetch_assoc()) {
                if ($row['total'] > 0) {
                    $stats['siswa'] = $row['total'];
                }
            }

            // Count total transaksi peminjaman & riwayat
            $q_tx = $db->query("SELECT COUNT(*) AS total FROM tb_transaksi");
            $q_hi = $db->query("SELECT COUNT(*) AS total FROM tb_riwayat");
            $total_tx = 0;
            if ($q_tx && $r1 = $q_tx->fetch_assoc()) $total_tx += (int)$r1['total'];
            if ($q_hi && $r2 = $q_hi->fetch_assoc()) $total_tx += (int)$r2['total'];
            if ($total_tx > 0) {
                $stats['transaksi'] = $total_tx;
            }

            // Ambil koleksi buku terbaru dari database
            $q_buku_list = $db->query("SELECT id_buku, judul_buku, pengarang, penerbit, tahun_terbit, cover, stok FROM tb_data_buku ORDER BY id_buku DESC LIMIT 8");
            if ($q_buku_list) {
                while ($b = $q_buku_list->fetch_assoc()) {
                    $books_showcase[] = [
                        'id'         => $b['id_buku'],
                        'judul'      => $b['judul_buku'],
                        'pengarang'  => $b['pengarang'] ?? 'Penulis Sekolah',
                        'penerbit'   => $b['penerbit'] ?? 'Penerbit Edukasi',
                        'tahun'      => $b['tahun_terbit'] ?? date('Y'),
                        'stok'       => (int)($b['stok'] ?? 1),
                        'cover'      => !empty($b['cover']) ? BASE_URL . 'assets/images/covers/' . $b['cover'] : BASE_URL . 'assets/images/covers/default.svg',
                        'kategori'   => 'pelajaran',
                        'kategori_label' => 'Buku Sekolah'
                    ];
                }
            }
        }
    } catch (Exception $e) {
        // Fallback jika database belum siap
    }
}

// Jika buku database kurang dari 4, lengkapi dengan buku kurasi edukasi agar preview menarik
$dummy_books = [
    [
        'id'             => 'd2',
        'judul'          => 'Dasar-Dasar Rekayasa Perangkat Lunak',
        'pengarang'      => 'Prof. Dr. Ir. Harianto',
        'penerbit'       => 'Informatika Press',
        'tahun'          => '2023',
        'stok'           => 8,
        'cover'          => BASE_URL . 'assets/images/covers/rpl.jpg',
        'kategori'       => 'teknologi',
        'kategori_label' => 'Teknologi'
    ],
    [
        'id'             => 'd3',
        'judul'          => 'Fisika Kuantum & Kosmologi Modern',
        'pengarang'      => 'Dr. Siti Rahmawati, M.Sc',
        'penerbit'       => 'Erlangga Sains',
        'tahun'          => '2022',
        'stok'           => 12,
        'cover'          => BASE_URL . 'assets/images/covers/fisika.jpg',
        'kategori'       => 'sains',
        'kategori_label' => 'Sains & Alam'
    ],
    [
        'id'             => 'd4',
        'judul'          => 'Bumi Manusia',
        'pengarang'      => 'Pramoedya Ananta Toer',
        'penerbit'       => 'Hasta Mitra',
        'tahun'          => '1980',
        'stok'           => 6,
        'cover'          => BASE_URL . 'assets/images/covers/bumi-manusia.jpg',
        'kategori'       => 'fiksi',
        'kategori_label' => 'Sastra Sejarah'
    ]
];

foreach ($dummy_books as $dbk) {
    if (count($books_showcase) >= 6) break;
    $books_showcase[] = $dbk;
}

// Cek apakah user sudah login
$is_logged_in = isset($_SESSION['id_user']) || isset($_SESSION['id_admin']);
$dashboard_url = isset($_SESSION['id_admin']) 
    ? BASE_URL . 'index.php?page=admin_dashboard' 
    : (isset($_SESSION['id_user']) ? BASE_URL . 'index.php?page=siswa_dashboard' : null);
$user_name = $_SESSION['nama_lengkap'] ?? ($_SESSION['username'] ?? 'User');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Perpus | Perpustakaan Sekolah Digital Terintegrasi</title>
    <meta name="description" content="E-Perpus adalah platform perpustakaan sekolah digital modern. Cari koleksi buku, pinjam dalam 1 klik, dan pantau masa pengembalian dengan mudah dan transparan.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>assets/images/favicon.svg">
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tabler Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Landing Page Modern CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/landing.css?v=<?= time(); ?>">
</head>
<body>

    <!-- =======================================================================
         1. NAVBAR (STICKY & GLASSMORPHISM)
    ======================================================================== -->
    <header class="landing-navbar" id="navbar">
        <div class="container navbar-inner">
            
            <!-- Brand Logo -->
            <a href="<?= BASE_URL ?>index.php?page=landing" class="navbar-brand">
                <div class="brand-icon-box">
                    <img src="<?= BASE_URL ?>assets/images/logo-icon.svg" alt="E-Perpus Logo">
                </div>
                <div class="brand-text-group">
                    <span class="brand-title">E-Perpus</span>
                    <span class="brand-subtitle">Digital Library</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="navbar-links" id="desktopNav">
                <a href="#beranda" class="nav-item active">Beranda</a>
                <a href="#fitur" class="nav-item">Fitur Unggulan</a>
                <a href="#koleksi" class="nav-item">Koleksi Buku</a>
                <a href="#cara-kerja" class="nav-item">Cara Pinjam</a>
                <a href="#tentang" class="nav-item">Tentang</a>
                <a href="#faq" class="nav-item">FAQ</a>
            </nav>

            <!-- Navbar Action Buttons -->
            <div class="navbar-actions">
                <?php if ($is_logged_in): ?>
                    <a href="<?= $dashboard_url ?>" class="btn-nav-register">
                        <i class="ti ti-layout-dashboard"></i>
                        <span>Dashboard (<?= htmlspecialchars($user_name) ?>)</span>
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>index.php?page=login" class="btn-nav-login">
                        <i class="ti ti-login"></i>
                        <span>Masuk</span>
                    </a>
                    <a href="<?= BASE_URL ?>index.php?page=register" class="btn-nav-register">
                        <i class="ti ti-user-plus"></i>
                        <span>Daftar Siswa</span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Hamburger Toggle -->
            <button type="button" class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Buka menu navigasi">
                <i class="ti ti-menu-2" id="navToggleIcon"></i>
            </button>

        </div>

        <!-- Mobile Drawer Menu -->
        <div class="mobile-nav-drawer" id="mobileNavDrawer">
            <a href="#beranda" class="mobile-nav-item active">
                <i class="ti ti-home"></i> Beranda
            </a>
            <a href="#fitur" class="mobile-nav-item">
                <i class="ti ti-star"></i> Fitur Unggulan
            </a>
            <a href="#koleksi" class="mobile-nav-item">
                <i class="ti ti-books"></i> Koleksi Buku
            </a>
            <a href="#cara-kerja" class="mobile-nav-item">
                <i class="ti ti-help-circle"></i> Cara Pinjam
            </a>
            <a href="#tentang" class="mobile-nav-item">
                <i class="ti ti-info-circle"></i> Tentang
            </a>
            <a href="#faq" class="mobile-nav-item">
                <i class="ti ti-message-2-question"></i> FAQ
            </a>
            <div class="mobile-nav-actions">
                <?php if ($is_logged_in): ?>
                    <a href="<?= $dashboard_url ?>" class="btn-nav-register">
                        <i class="ti ti-layout-dashboard"></i> Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>index.php?page=login" class="btn-nav-login">
                        <i class="ti ti-login"></i> Masuk Akun
                    </a>
                    <a href="<?= BASE_URL ?>index.php?page=register" class="btn-nav-register">
                        <i class="ti ti-user-plus"></i> Daftar Siswa
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- =======================================================================
         2. HERO SECTION
    ======================================================================== -->
    <main>
        <section class="hero-section" id="beranda">
            <div class="hero-backdrop-pattern"></div>
            
            <div class="container hero-grid">
                
                <!-- Left Hero Content -->
                <div class="hero-content">
                    
                    <div class="hero-pill-badge">
                        <i class="ti ti-sparkles"></i>
                        <span>Perpustakaan Sekolah Digital Modern</span>
                    </div>

                    <h1 class="hero-heading">
                        Akses Ribuan Buku & <br>
                        Tingkatkan Literasi <br>
                        <span class="gradient-text">Tanpa Batas Antre.</span>
                    </h1>

                    <p class="hero-subtext">
                        Platform resmi perpustakaan sekolah untuk mencari koleksi buku pelajaran, ensiklopedia, 
                        hingga novel favorit. Pinjam cepat secara digital, pantau tanggal jatuh tempo secara akurat, 
                        dan tingkatkan prestasimu kapan saja.
                    </p>

                    <!-- Hero Call to Action Buttons -->
                    <div class="hero-cta-group">
                        <a href="<?= $is_logged_in ? $dashboard_url : BASE_URL . 'index.php?page=login' ?>" class="btn-hero-primary">
                            <span>Mulai Pinjam Buku</span>
                            <i class="ti ti-arrow-right"></i>
                        </a>

                        <a href="#koleksi" class="btn-hero-secondary">
                            <i class="ti ti-book"></i>
                            <span>Jelajahi Koleksi</span>
                        </a>
                    </div>

                    <!-- Trust Highlights -->
                    <div class="hero-trust-chips">
                        <div class="trust-chip">
                            <div class="trust-chip-icon"><i class="ti ti-check"></i></div>
                            <span>100% Bebas Antre</span>
                        </div>
                        <div class="trust-chip">
                            <div class="trust-chip-icon"><i class="ti ti-check"></i></div>
                            <span>Jatuh Tempo 7 Hari</span>
                        </div>
                        <div class="trust-chip">
                            <div class="trust-chip-icon"><i class="ti ti-check"></i></div>
                            <span>Akses 24/7 Multi-Device</span>
                        </div>
                    </div>

                </div>

                <!-- Right Hero Visual with 3D Illustration & Floating Cards -->
                <div class="hero-visual-wrapper">
                    <div class="hero-visual-backdrop"></div>
                    
                    <img 
                        src="<?= BASE_URL ?>assets/images/illustrations/illustration-reading-student.png" 
                        alt="Siswa Membaca Buku E-Perpus" 
                        class="hero-main-illustration">

                    <!-- Floating Card 1: Rating Siswa -->
                    <div class="hero-floating-card card-pos-top-left">
                        <div class="floating-icon-box icon-box-warning">
                            <i class="ti ti-star-filled"></i>
                        </div>
                        <div class="floating-text">
                            <strong>Rating 4.9/5</strong>
                            <span>500+ Siswa Aktif</span>
                        </div>
                    </div>

                    <!-- Floating Card 2: Peminjaman Cepat -->
                    <div class="hero-floating-card card-pos-bottom-right">
                        <div class="floating-icon-box icon-box-success">
                            <i class="ti ti-bolt"></i>
                        </div>
                        <div class="floating-text">
                            <strong>Peminjaman Cepat</strong>
                            <span>Disetujui Otomatis</span>
                        </div>
                    </div>

                    <!-- Floating Card 3: Katalog Lengkap -->
                    <div class="hero-floating-card card-pos-top-right">
                        <div class="floating-icon-box icon-box-primary">
                            <i class="ti ti-books"></i>
                        </div>
                        <div class="floating-text">
                            <strong>Koleksi Terupdate</strong>
                            <span>Buku Pelajaran & Fiksi</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- =======================================================================
             3. STATS STRIP (SOCIAL PROOF)
        ======================================================================== -->
        <section class="stats-strip-section">
            <div class="container">
                <div class="stats-card-container">
                    
                    <div class="stat-item">
                        <div class="stat-icon-wrapper">
                            <i class="ti ti-books"></i>
                        </div>
                        <div class="stat-info-group">
                            <span class="stat-number"><?= number_format($stats['buku'], 0, ',', '.') ?>+</span>
                            <span class="stat-label">Koleksi Judul Buku</span>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon-wrapper">
                            <i class="ti ti-users"></i>
                        </div>
                        <div class="stat-info-group">
                            <span class="stat-number"><?= number_format($stats['siswa'], 0, ',', '.') ?>+</span>
                            <span class="stat-label">Siswa Aktif Terdaftar</span>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon-wrapper">
                            <i class="ti ti-arrows-exchange"></i>
                        </div>
                        <div class="stat-info-group">
                            <span class="stat-number"><?= number_format($stats['transaksi'], 0, ',', '.') ?>+</span>
                            <span class="stat-label">Peminjaman Selesai</span>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon-wrapper">
                            <i class="ti ti-shield-check"></i>
                        </div>
                        <div class="stat-info-group">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Digital & Terverifikasi</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- =======================================================================
             4. FITUR UNGGULAN (FEATURES GRID)
        ======================================================================== -->
        <section class="features-section" id="fitur">
            <div class="container">
                
                <div class="section-header">
                    <div class="section-badge">
                        <i class="ti ti-sparkles"></i>
                        <span>Fitur Unggulan</span>
                    </div>
                    <h2 class="section-title">Dirancang untuk <span>Kemudahan Literasi</span> Siswa</h2>
                    <p class="section-subtitle">
                        Nikmati seluruh alur peminjaman buku perpustakaan yang modern, praktis, dan transparan tanpa proses manual yang berbelit.
                    </p>
                </div>

                <div class="features-grid">
                    
                    <!-- Feature 1 -->
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="ti ti-search"></i>
                        </div>
                        <h3 class="feature-title">Pencarian Cerdas & Cepat</h3>
                        <p class="feature-desc">
                            Temukan buku berdasarkan judul, nama pengarang, penerbit, atau kategori dengan hasil pencarian instan dalam hitungan detik.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="ti ti-hand-click"></i>
                        </div>
                        <h3 class="feature-title">Peminjaman 1-Klik</h3>
                        <p class="feature-desc">
                            Cukup klik tombol pinjam pada buku yang kamu inginkan. Sistem otomatis memproses transaksi tanpa perlu mengisi formulir kertas manual.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="ti ti-calendar-time"></i>
                        </div>
                        <h3 class="feature-title">Pengingat Jatuh Tempo</h3>
                        <p class="feature-desc">
                            Pantau batas waktu pengembalian buku 7 hari secara akurat. Hindari denda keterlambatan dengan status tanggal kembali yang transparan.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="ti ti-rotate-rectangle"></i>
                        </div>
                        <h3 class="feature-title">Pengembalian Mandiri</h3>
                        <p class="feature-desc">
                            Siswa dapat melakukan konfirmasi pengembalian buku secara langsung melalui dashboard, lalu menyerahkan buku fisik ke meja petugas.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="ti ti-history"></i>
                        </div>
                        <h3 class="feature-title">Riwayat Peminjaman Lengkap</h3>
                        <p class="feature-desc">
                            Semua catatan buku yang pernah kamu pinjam tersimpan rapi sebagai jejak literasi membaca dan pencapaian belajarmu selama di sekolah.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="ti ti-device-mobile"></i>
                        </div>
                        <h3 class="feature-title">Responsif di Semua Perangkat</h3>
                        <p class="feature-desc">
                            Akses E-Perpus dengan nyaman melalui smartphone, tablet, laptop maupun PC laboratorium sekolah dengan tampilan yang selalu optimal.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- =======================================================================
             5. KOLEKSI BUKU POPULER (CATALOG PREVIEW)
        ======================================================================== -->
        <section class="catalog-section" id="koleksi">
            <div class="container">
                
                <div class="section-header">
                    <div class="section-badge">
                        <i class="ti ti-books"></i>
                        <span>Katalog Pilihan</span>
                    </div>
                    <h2 class="section-title">Koleksi Buku <span>Terpopuler</span> Sekolah</h2>
                    <p class="section-subtitle">
                        Temukan beragam buku pelajaran wajib, pengayaan sains, teknologi, serta karya sastra inspiratif yang siap dipinjam.
                    </p>
                </div>

                <!-- Category Filter Bar -->
                <div class="catalog-filter-bar">
                    <button type="button" class="filter-btn active" data-filter="all">Semua Koleksi</button>
                    <button type="button" class="filter-btn" data-filter="pelajaran">Buku Sekolah</button>
                    <button type="button" class="filter-btn" data-filter="fiksi">Fiksi & Sastra</button>
                    <button type="button" class="filter-btn" data-filter="teknologi">Teknologi</button>
                    <button type="button" class="filter-btn" data-filter="sains">Sains</button>
                </div>

                <!-- Book Cards Grid -->
                <div class="book-cards-grid" id="bookGrid">
                    <?php foreach ($books_showcase as $book): ?>
                        <div class="book-card" data-category="<?= htmlspecialchars($book['kategori']) ?>">
                            <div class="book-card-cover">
                                <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['judul']) ?>" loading="lazy">
                                <span class="book-category-tag"><?= htmlspecialchars($book['kategori_label']) ?></span>
                            </div>
                            <div class="book-card-body">
                                <h3 class="book-card-title"><?= htmlspecialchars($book['judul']) ?></h3>
                                <div class="book-card-author">
                                    <i class="ti ti-user"></i> <?= htmlspecialchars($book['pengarang']) ?> (<?= htmlspecialchars($book['tahun']) ?>)
                                </div>
                                <div class="book-card-meta">
                                    <span class="book-stock-badge <?= $book['stok'] > 5 ? 'stock-available' : 'stock-limited' ?>">
                                        <i class="ti ti-circle-filled" style="font-size: 0.55rem;"></i>
                                        Stok: <?= (int)$book['stok'] ?>
                                    </span>
                                    <a href="<?= $is_logged_in ? $dashboard_url : BASE_URL . 'index.php?page=login' ?>" class="btn-book-borrow">
                                        <span>Pinjam</span>
                                        <i class="ti ti-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Catalog Bottom CTA Banner -->
                <div class="catalog-bottom-banner">
                    <div class="catalog-banner-text">
                        <strong>Ingin melihat koleksi buku lainnya?</strong>
                        <p>Masuk ke sistem E-Perpus untuk menelusuri ratusan judul buku lengkap dan ketersediaan stok secara real-time.</p>
                    </div>
                    <a href="<?= $is_logged_in ? $dashboard_url : BASE_URL . 'index.php?page=login' ?>" class="btn-hero-primary" style="padding: 12px 24px;">
                        <span>Buka Katalog Lengkap</span>
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>

        <!-- =======================================================================
             6. ALUR & CARA PINJAM (HOW IT WORKS)
        ======================================================================== -->
        <section class="how-section" id="cara-kerja">
            <div class="container">
                
                <div class="section-header">
                    <div class="section-badge">
                        <i class="ti ti-bulb"></i>
                        <span>Alur Peminjaman</span>
                    </div>
                    <h2 class="section-title">4 Langkah <span>Mudah & Cepat</span> Meminjam</h2>
                    <p class="section-subtitle">
                        Sistem dirancang tanpa hambatan. Ikuti langkah sederhana berikut untuk mendapatkan buku bacaan pilihanmu.
                    </p>
                </div>

                <div class="how-steps-grid">
                    
                    <!-- Step 1 -->
                    <div class="step-card-item">
                        <span class="step-badge-number">01</span>
                        <div class="step-icon-bubble">
                            <i class="ti ti-user-check"></i>
                        </div>
                        <h3 class="step-card-title">Masuk / Daftar Akun</h3>
                        <p class="step-card-text">
                            Gunakan NISN dan password terdaftar. Jika belum memiliki akun, lakukan pendaftaran siswa dalam 1 menit.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="step-card-item">
                        <span class="step-badge-number">02</span>
                        <div class="step-icon-bubble">
                            <i class="ti ti-search"></i>
                        </div>
                        <h3 class="step-card-title">Pilih Buku Favorit</h3>
                        <p class="step-card-text">
                            Cari buku dari katalog perpustakaan berdasarkan judul atau pengarang, lalu periksa ketersediaan stok bukunya.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="step-card-item">
                        <span class="step-badge-number">03</span>
                        <div class="step-icon-bubble">
                            <i class="ti ti-bookmark-check"></i>
                        </div>
                        <h3 class="step-card-title">Klik Pinjam Buku</h3>
                        <p class="step-card-text">
                            Tekan tombol pinjam. Transaksi tercatat secara instan dengan tenggat waktu pengembalian otomatis 7 hari.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="step-card-item">
                        <span class="step-badge-number">04</span>
                        <div class="step-icon-bubble">
                            <i class="ti ti-book-upload"></i>
                        </div>
                        <h3 class="step-card-title">Baca & Kembalikan</h3>
                        <p class="step-card-text">
                            Nikmati bacaanmu dan kembalikan tepat waktu melalui dashboard siswa serta serahkan fisik buku ke perpustakaan.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- =======================================================================
             7. VALUE PROPOSITION / KENAPA E-PERPUS
        ======================================================================== -->
        <section class="why-section" id="tentang">
            <div class="container why-grid">
                
                <div class="why-image-wrapper">
                    <img 
                        src="<?= BASE_URL ?>assets/images/illustrations/illustration-borrow.png" 
                        alt="E-Perpus Sistem Peminjaman Digital" 
                        class="why-main-image">
                </div>

                <div class="why-content">
                    <div class="section-badge">
                        <i class="ti ti-award"></i>
                        <span>Keunggulan Sistem</span>
                    </div>

                    <h2>Transformasi Literasi Digital untuk Masa Depan Sekolah</h2>

                    <p>
                        E-Perpus hadir menggantikan buku pencatatan manual yang rentan rusak dan hilang. 
                        Dengan sistem digital yang terintegrasi, perpustakaan sekolah menjadi lebih ramah, cepat, 
                        dan menyenangkan untuk diakses setiap saat oleh seluruh siswa dan bapak/ibu guru.
                    </p>

                    <div class="benefits-list">
                        
                        <div class="benefit-item">
                            <div class="benefit-check-icon"><i class="ti ti-check"></i></div>
                            <div class="benefit-text">
                                <strong>Hemat Waktu & Bebas Antre</strong>
                                <p>Siswa tidak perlu berebut mengisi formulir kertas saat jam istirahat yang terbatas.</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-check-icon"><i class="ti ti-check"></i></div>
                            <div class="benefit-text">
                                <strong>Pencatatan Presisi & Transparansi Denda</strong>
                                <p>Tanggal pinjam, batas waktu kembali, dan denda tercatat otomatis tanpa kesalahan hitung.</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-check-icon"><i class="ti ti-check"></i></div>
                            <div class="benefit-text">
                                <strong>Koleksi Terdata Rapi & Akurat</strong>
                                <p>Petugas perpustakaan dan siswa mengetahui kepastian stok buku yang tersedia secara real-time.</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-check-icon"><i class="ti ti-check"></i></div>
                            <div class="benefit-text">
                                <strong>Mendorong Budaya Membaca Berkelanjutan</strong>
                                <p>Riwayat bacaan yang tersimpan memotivasi siswa untuk terus mengeksplorasi ilmu pengetahuan baru.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- =======================================================================
             8. FAQ ACCORDION
        ======================================================================== -->
        <section class="faq-section" id="faq">
            <div class="container">
                
                <div class="section-header">
                    <div class="section-badge">
                        <i class="ti ti-help"></i>
                        <span>Pertanyaan Umum</span>
                    </div>
                    <h2 class="section-title">Sering <span>Ditanyakan</span> (FAQ)</h2>
                    <p class="section-subtitle">
                        Temukan jawaban cepat seputar ketentuan peminjaman buku, batas waktu, dan akun siswa.
                    </p>
                </div>

                <div class="faq-accordion-container">
                    
                    <!-- FAQ 1 -->
                    <div class="faq-card active">
                        <button type="button" class="faq-question-btn">
                            <span>Berapa lama batas waktu peminjaman buku?</span>
                            <div class="faq-chevron"><i class="ti ti-chevron-down"></i></div>
                        </button>
                        <div class="faq-answer-collapse">
                            <div class="faq-answer-content">
                                Setiap buku yang dipinjam melalui E-Perpus memiliki masa pinjam standar selama <strong>7 (tujuh) hari kalender</strong> terhitung sejak transaksi peminjaman berhasil dibuat di sistem.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="faq-card">
                        <button type="button" class="faq-question-btn">
                            <span>Apakah dikenakan denda jika terlambat mengembalikan buku?</span>
                            <div class="faq-chevron"><i class="ti ti-chevron-down"></i></div>
                        </button>
                        <div class="faq-answer-collapse">
                            <div class="faq-answer-content">
                                Ya. Untuk menjaga kedisiplinan dan memberi kesempatan kepada siswa lain, keterlambatan pengembalian buku dikenakan denda otomatis sebesar <strong>Rp 1.000,- per hari</strong> untuk setiap buku yang terlambat dikembalikan.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="faq-card">
                        <button type="button" class="faq-question-btn">
                            <span>Bagaimana alur mengembalikan buku yang sudah saya pinjam?</span>
                            <div class="faq-chevron"><i class="ti ti-chevron-down"></i></div>
                        </button>
                        <div class="faq-answer-collapse">
                            <div class="faq-answer-content">
                                Masuk ke akun Anda, buka menu <strong>Peminjaman</strong>, lalu klik tombol <strong>Kembalikan</strong> pada buku yang bersangkutan. Setelah itu, bawa buku fisik ke meja petugas perpustakaan sekolah untuk verifikasi kondisi buku.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="faq-card">
                        <button type="button" class="faq-question-btn">
                            <span>Berapa banyak buku yang bisa saya pinjam sekaligus?</span>
                            <div class="faq-chevron"><i class="ti ti-chevron-down"></i></div>
                        </button>
                        <div class="faq-answer-collapse">
                            <div class="faq-answer-content">
                                Siswa dapat meminjam hingga beberapa buku dengan judul yang berbeda sekaligus, asalkan stok buku masih tersedia dan siswa tidak memiliki tunggakan denda atau buku yang lewat jatuh tempo.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="faq-card">
                        <button type="button" class="faq-question-btn">
                            <span>Bagaimana cara mendaftar jika saya belum memiliki akun?</span>
                            <div class="faq-chevron"><i class="ti ti-chevron-down"></i></div>
                        </button>
                        <div class="faq-answer-collapse">
                            <div class="faq-answer-content">
                                Anda dapat mengklik tombol <strong>Daftar Siswa</strong> di bagian atas halaman, mengisi formulir dengan data NISN valid, nama lengkap, username, dan kata sandi. Setelah berhasil, Anda bisa langsung login.
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- =======================================================================
             9. HIGH-CONVERSION CTA BANNER
        ======================================================================== -->
        <section class="cta-banner-section">
            <div class="container">
                <div class="cta-banner-card">
                    <div class="cta-orb-1"></div>
                    <div class="cta-orb-2"></div>
                    
                    <div class="cta-banner-content">
                        <h2 class="cta-banner-title">Mulai Petualangan Membaca Bersama E-Perpus Sekarang!</h2>
                        <p class="cta-banner-text">
                            Tingkatkan wawasan dan raih prestasi terbaik dengan akses buku sekolah tanpa batas. 
                            Daftar gratis hari ini dan nikmati kemudahan membaca dari ujung jari.
                        </p>
                        
                        <div class="cta-button-group">
                            <?php if ($is_logged_in): ?>
                                <a href="<?= $dashboard_url ?>" class="btn-cta-white">
                                    <i class="ti ti-layout-dashboard"></i>
                                    <span>Buka Dashboard Saya</span>
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>index.php?page=register" class="btn-cta-white">
                                    <i class="ti ti-user-plus"></i>
                                    <span>Daftar Akun Siswa</span>
                                </a>
                                <a href="<?= BASE_URL ?>index.php?page=login" class="btn-cta-outline">
                                    <i class="ti ti-login"></i>
                                    <span>Masuk ke Perpustakaan</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- =======================================================================
         10. MODERN FOOTER
    ======================================================================== -->
    <footer class="landing-footer">
        <div class="container">
            
            <div class="footer-top-grid">
                
                <!-- Col 1: Brand Info -->
                <div class="footer-brand-col">
                    <div class="footer-brand-logo">
                        <div class="brand-icon-box" style="width: 36px; height: 36px;">
                            <img src="<?= BASE_URL ?>assets/images/logo-icon.svg" alt="Logo">
                        </div>
                        <span class="footer-brand-title">E-Perpus</span>
                    </div>
                    <p class="footer-brand-text">
                        Sistem manajemen peminjaman buku dan perpustakaan sekolah digital untuk mempermudah siswa dan guru mengakses literasi berkualitas secara cepat dan terstruktur.
                    </p>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="footer-col-title">Navigasi</h4>
                    <ul class="footer-nav-list">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#fitur">Fitur Unggulan</a></li>
                        <li><a href="#koleksi">Koleksi Buku</a></li>
                        <li><a href="#cara-kerja">Alur Peminjaman</a></li>
                        <li><a href="#faq">Tanya Jawab (FAQ)</a></li>
                    </ul>
                </div>

                <!-- Col 3: Akses Layanan -->
                <div>
                    <h4 class="footer-col-title">Layanan Siswa</h4>
                    <ul class="footer-nav-list">
                        <li><a href="<?= BASE_URL ?>index.php?page=login">Masuk Akun</a></li>
                        <li><a href="<?= BASE_URL ?>index.php?page=register">Daftar Siswa</a></li>
                        <li><a href="<?= BASE_URL ?>index.php?page=login">Login Petugas/Admin</a></li>
                        <li><a href="#cara-kerja">Ketentuan Denda</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Lokasi -->
                <div class="footer-contact-col">
                    <h4 class="footer-col-title">Perpustakaan Sekolah</h4>
                    <div class="footer-contact-item">
                        <i class="ti ti-map-pin"></i>
                        <span>Gedung Perpustakaan Utama, Lantai 1 - Lingkungan Sekolah</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="ti ti-clock"></i>
                        <span>Senin - Jumat: 07.30 - 15.30 WIB (Sabtu/Minggu Libur)</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="ti ti-mail"></i>
                        <span>perpustakaan@sekolah.sch.id</span>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Bar -->
            <div class="footer-bottom-bar">
                <p>&copy; <?= date('Y'); ?> E-Perpus Perpustakaan Digital. Seluruh hak cipta dilindungi.</p>
                <div>
                    <span>Platform Edukasi Literasi Sekolah Modern</span>
                </div>
            </div>

        </div>
    </footer>

    <!-- Back to Top Floating Button -->
    <button type="button" class="back-to-top-btn" id="backToTopBtn" aria-label="Kembali ke atas">
        <i class="ti ti-arrow-up"></i>
    </button>

    <!-- =======================================================================
         11. INTERACTIVE CLIENT-SIDE JAVASCRIPT
    ======================================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            /* --- A. Sticky Navbar on Scroll --- */
            const navbar = document.getElementById('navbar');
            const backToTopBtn = document.getElementById('backToTopBtn');

            window.addEventListener('scroll', function () {
                const scrollPos = window.scrollY;

                if (scrollPos > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                if (scrollPos > 400) {
                    backToTopBtn.classList.add('visible');
                } else {
                    backToTopBtn.classList.remove('visible');
                }
            });

            /* --- B. Back to Top Smooth Scroll --- */
            backToTopBtn.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            /* --- C. Mobile Navigation Drawer Toggle --- */
            const mobileToggle = document.getElementById('mobileNavToggle');
            const mobileDrawer = document.getElementById('mobileNavDrawer');
            const navToggleIcon = document.getElementById('navToggleIcon');

            if (mobileToggle && mobileDrawer) {
                mobileToggle.addEventListener('click', function () {
                    const isOpen = mobileDrawer.classList.toggle('open');
                    if (isOpen) {
                        navToggleIcon.className = 'ti ti-x';
                    } else {
                        navToggleIcon.className = 'ti ti-menu-2';
                    }
                });

                // Close mobile drawer when any link is clicked
                document.querySelectorAll('.mobile-nav-item, .mobile-nav-actions a').forEach(function (link) {
                    link.addEventListener('click', function () {
                        mobileDrawer.classList.remove('open');
                        navToggleIcon.className = 'ti ti-menu-2';
                    });
                });
            }

            /* --- D. Active Nav Link on Scroll (ScrollSpy) --- */
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar-links .nav-item');

            function highlightNavOnScroll() {
                const scrollY = window.pageYOffset;

                sections.forEach(function (current) {
                    const sectionHeight = current.offsetHeight;
                    const sectionTop = current.offsetTop - 120;
                    const sectionId = current.getAttribute('id');

                    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                        navLinks.forEach(function (link) {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === '#' + sectionId) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }

            window.addEventListener('scroll', highlightNavOnScroll);

            /* --- E. Book Category Filter Tabs --- */
            const filterBtns = document.querySelectorAll('.filter-btn');
            const bookCards = document.querySelectorAll('.book-card');

            filterBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    // Reset active class
                    filterBtns.forEach(function (b) { b.classList.remove('active'); });
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    bookCards.forEach(function (card) {
                        const cardCat = card.getAttribute('data-category');
                        if (filterValue === 'all' || cardCat === filterValue) {
                            card.style.display = 'flex';
                            setTimeout(function () {
                                card.style.opacity = '1';
                                card.style.transform = 'scale(1)';
                            }, 50);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.95)';
                            setTimeout(function () {
                                card.style.display = 'none';
                            }, 200);
                        }
                    });
                });
            });

            /* --- F. FAQ Accordion Logic --- */
            const faqCards = document.querySelectorAll('.faq-card');

            faqCards.forEach(function (card) {
                const btn = card.querySelector('.faq-question-btn');
                if (btn) {
                    btn.addEventListener('click', function () {
                        const isActive = card.classList.contains('active');

                        // Tutup semua FAQ lain untuk efek accordion rapi
                        faqCards.forEach(function (c) {
                            c.classList.remove('active');
                        });

                        // Buka yang diklik jika sebelumnya tertutup
                        if (!isActive) {
                            card.classList.add('active');
                        }
                    });
                }
            });

        });
    </script>
</body>
</html>
