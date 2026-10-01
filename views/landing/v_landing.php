<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-Perpus | Sistem Peminjaman Buku</title>

    <meta
        name="description"
        content="E-Perpus adalah platform perpustakaan digital untuk membantu siswa mencari, meminjam, dan membaca buku dengan mudah.">

    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>assets/images/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Landing Page CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/landing.css">
</head>

<body>

    <!-- =========================
         NAVBAR
    ========================== -->
    <header class="landing-navbar" id="navbar">

        <div class="navbar-container">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>index.php?page=landing" class="navbar-brand">

                <img
                    src="<?= BASE_URL ?>assets/images/logo-dark.svg"
                    alt="E-Perpus"
                    class="navbar-logo">

                <div class="brand-text">
                    <span class="brand-name">E-Perpus</span>
                    <span class="brand-tagline">Sistem Peminjaman Buku</span>
                </div>

            </a>


            <!-- Desktop Navigation -->
            <nav class="navbar-menu">

                <a href="#beranda" class="nav-link active">
                    Beranda
                </a>

                <a href="#tentang" class="nav-link">
                    Tentang
                </a>

                <!-- Layanan Dropdown -->
                <div class="nav-dropdown">

                    <button
                        type="button"
                        class="nav-link dropdown-toggle"
                        id="serviceDropdown">

                        Layanan

                        <span class="dropdown-arrow">⌄</span>

                    </button>

                    <div class="dropdown-menu" id="serviceMenu">

                        <a href="<?= BASE_URL ?>index.php?page=auth&action=login" class="dropdown-item">

                            <span class="dropdown-icon">↗</span>

                            <div>
                                <strong>Pinjam Buku</strong>
                                <small>Mulai meminjam koleksi kami</small>
                            </div>

                        </a>

                        <a href="#cara-kerja" class="dropdown-item">

                            <span class="dropdown-icon">?</span>

                            <div>
                                <strong>Cara Pinjam</strong>
                                <small>Pelajari langkah peminjaman</small>
                            </div>

                        </a>

                        <a href="<?= BASE_URL ?>index.php?page=auth&action=login" class="dropdown-item">

                            <span class="dropdown-icon">☷</span>

                            <div>
                                <strong>Katalog Buku</strong>
                                <small>Lihat daftar buku tersedia</small>
                            </div>

                        </a>

                    </div>

                </div>

            </nav>


            <!-- Tombol Daftar & Masuk -->
            <div class="navbar-actions">

                <a href="<?= BASE_URL ?>index.php?page=auth&action=register" class="navbar-register">
                    <span>Daftar</span>
                </a>

                <a href="<?= BASE_URL ?>index.php?page=auth&action=login" class="navbar-login">
                    <span class="login-icon">♙</span>
                    <span>Masuk</span>
                </a>

            </div>


            <!-- Mobile Menu Button -->
            <button
                type="button"
                class="mobile-menu-button"
                id="mobileMenuButton"
                aria-label="Buka menu">

                <span></span>
                <span></span>
                <span></span>

            </button>

        </div>


        <!-- Mobile Navigation -->
        <div class="mobile-menu" id="mobileMenu">

            <a href="#beranda" class="mobile-nav-link">
                Beranda
            </a>

            <a href="#tentang" class="mobile-nav-link">
                Tentang
            </a>

            <button
                type="button"
                class="mobile-service-toggle"
                id="mobileServiceToggle">

                <span>Layanan</span>
                <span>⌄</span>

            </button>

            <div class="mobile-service-menu" id="mobileServiceMenu">

                <a href="<?= BASE_URL ?>index.php?page=auth&action=login">
                    Pinjam Buku
                </a>

                <a href="#cara-kerja">
                    Cara Pinjam
                </a>

                <a href="<?= BASE_URL ?>index.php?page=auth&action=login">
                    Katalog Buku
                </a>

            </div>

            <a href="<?= BASE_URL ?>index.php?page=auth&action=register" class="mobile-nav-link">
                Daftar
            </a>

            <a href="<?= BASE_URL ?>index.php?page=auth&action=login" class="mobile-login">
                Masuk
            </a>

        </div>

    </header>


    <!-- =========================
         HERO SECTION
    ========================== -->
    <main>
        <section class="hero-section" id="beranda">
            <div class="hero-container">
                <!-- Hero Content -->
                <div class="hero-content">


                    <h1 class="hero-title">

                        Pinjam dan Baca Buku
                        <br>

                        Favoritmu

                        <span>
                            dengan Mudah.
                        </span>

                    </h1>


                    <p class="hero-description">

                        Temukan berbagai macam buku pelajaran dan novel menarik. 
                        Pinjam buku secara digital melalui E-Perpus 
                        dan tingkatkan literasimu kapan saja.

                    </p>


                    <!-- Hero CTA -->
                    <div class="hero-actions">

                        <a
                            href="<?= BASE_URL ?>index.php?page=auth&action=login"
                            class="btn-primary">

                            <span>Mulai Meminjam</span>

                            <span class="btn-arrow">
                                →
                            </span>

                        </a>


                        <a
                            href="#cara-kerja"
                            class="btn-secondary">

                            <span class="play-icon">
                                ▶
                            </span>

                            <span>
                                Cara Pinjam
                            </span>

                        </a>

                    </div>


                    <!-- Trust Message -->
                    <div class="hero-trust">

                        <span class="trust-icon">
                            ✓
                        </span>

                        <span>
                            Koleksi lengkap, proses cepat, dan mudah diakses.
                        </span>

                    </div>

                </div>


                <!-- Hero Illustration -->
                <div class="hero-visual">

                    <div class="visual-decoration decoration-one"></div>

                    <div class="visual-decoration decoration-two"></div>

                    <div class="visual-decoration decoration-three"></div>


                    <div class="illustration-wrapper">
                        <!-- Placeholder ikon buku. Ganti dengan <img class="school-illustration" src="..."> kalau sudah punya ilustrasi -->
                        <span class="school-illustration" role="img" aria-label="Ilustrasi perpustakaan">📚</span>

                    </div>

                </div>

            </div>


            <!-- Decorative Bottom Wave -->
            <div class="hero-wave">

                <svg
                    viewBox="0 0 1440 150"
                    preserveAspectRatio="none"
                    aria-hidden="true">

                    <path
                        class="wave-back"
                        d="M0,80 C240,10 420,25 650,95 C850,155 1080,125 1440,30 L1440,150 L0,150 Z">
                    </path>

                    <path
                        class="wave-front"
                        d="M0,110 C220,45 430,55 650,110 C880,170 1110,125 1440,55 L1440,150 L0,150 Z">
                    </path>

                </svg>

            </div>

        </section>


        <!-- =========================
             TENTANG
        ========================== -->
        <section class="about-preview" id="tentang">

            <div class="section-container">

                <div class="section-label">
                    TENTANG E-PERPUS
                </div>

                <h2>
                    Membaca ikut membuka
                    jendela dunia.
                </h2>

                <p>
                    E-Perpus hadir sebagai platform perpustakaan digital 
                    untuk mempermudah Anda dalam mencari, meminjam, 
                    dan membaca buku secara terstruktur dan efisien.
                </p>

            </div>

        </section>


        <!-- =========================
             CARA KERJA
        ========================== -->
        <section class="how-it-works" id="cara-kerja">

            <div class="section-container">

                <div class="section-label">
                    CARA MEMINJAM
                </div>

                <h2>
                    Empat langkah sederhana.
                </h2>

                <p class="section-description">
                    Ikuti panduan mudah ini untuk mulai meminjam buku favorit Anda.
                </p>


                <div class="steps-grid">

                    <div class="step-card">

                        <span class="step-number">
                            01
                        </span>

                        <h3>
                            Daftar / Login
                        </h3>

                        <p>
                            Buat akun menggunakan data diri Anda, lalu masuk ke dalam sistem.
                        </p>

                    </div>


                    <div class="step-card">

                        <span class="step-number">
                            02
                        </span>

                        <h3>
                            Pilih Buku
                        </h3>

                        <p>
                            Cari dan pilih buku yang ingin Anda baca dari katalog perpustakaan.
                        </p>

                    </div>


                    <div class="step-card">

                        <span class="step-number">
                            03
                        </span>

                        <h3>
                            Ajukan Pinjaman
                        </h3>

                        <p>
                            Klik tombol pinjam dan tunggu persetujuan dari petugas perpustakaan.
                        </p>

                    </div>


                    <div class="step-card">

                        <span class="step-number">
                            04
                        </span>

                        <h3>
                            Kembalikan
                        </h3>

                        <p>
                            Kembalikan buku sebelum batas waktu agar terhindar dari denda.
                        </p>

                    </div>

                </div>

            </div>

        </section>

    </main>


    <!-- =========================
         FOOTER
    ========================== -->
    <footer class="landing-footer">

        <div class="footer-container">

            <div>
                <strong>E-Perpus</strong>
                <span>
                    Sistem Peminjaman Buku
                </span>
            </div>

            <p>
                © <?= date('Y'); ?> E-Perpus. All rights reserved.
            </p>

        </div>

    </footer>


    <!-- =========================
         NAVIGATION SCRIPT
    ========================== -->
    <script>
        /* =========================
           Desktop Dropdown
        ========================== */

        const serviceDropdown =
            document.getElementById('serviceDropdown');

        const serviceMenu =
            document.getElementById('serviceMenu');


        serviceDropdown.addEventListener('click', function(event) {

            event.stopPropagation();

            serviceMenu.classList.toggle('show');

            serviceDropdown.classList.toggle('open');

        });


        document.addEventListener('click', function() {

            serviceMenu.classList.remove('show');

            serviceDropdown.classList.remove('open');

        });


        /* =========================
           Mobile Menu
        ========================== */

        const mobileMenuButton =
            document.getElementById('mobileMenuButton');

        const mobileMenu =
            document.getElementById('mobileMenu');


        mobileMenuButton.addEventListener('click', function() {

            mobileMenu.classList.toggle('show');

            mobileMenuButton.classList.toggle('active');

        });


        /* =========================
           Mobile Service Dropdown
        ========================== */

        const mobileServiceToggle =
            document.getElementById('mobileServiceToggle');

        const mobileServiceMenu =
            document.getElementById('mobileServiceMenu');


        mobileServiceToggle.addEventListener('click', function() {

            mobileServiceMenu.classList.toggle('show');

        });


        /* =========================
           Close Mobile Menu
        ========================== */

        document.querySelectorAll('.mobile-nav-link, .mobile-service-menu a, .mobile-login')
            .forEach(function(link) {

                link.addEventListener('click', function() {

                    mobileMenu.classList.remove('show');

                    mobileMenuButton.classList.remove('active');

                });

            });


        /* =========================
           Navbar Scroll Effect
        ========================== */

        const navbar =
            document.getElementById('navbar');


        window.addEventListener('scroll', function() {

            if (window.scrollY > 20) {

                navbar.classList.add('scrolled');

            } else {

                navbar.classList.remove('scrolled');

            }

        });
    </script>

</body>

</html>