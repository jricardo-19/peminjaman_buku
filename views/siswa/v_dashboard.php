<!-- Siswa Dashboard -->
<div class="siswa-content">
    <!-- Hero Section -->
    <div class="hero-section" style="background-image: url('assets/images/backgrounds/bg-dashboard-hero.png'); background-size: cover; background-position: center;">
        <div class="hero-text">
            <h1>Selamat Datang, <?= $data['user']['nama_lengkap'] ?> 👋</h1>
            <p>Temukan buku favoritmu, pinjam dengan mudah, dan perluas wawasanmu.</p>
            <a href="index.php?page=katalog" class="btn btn-hero">
                Jelajahi Katalog Buku <i class="ti ti-arrow-right"></i>
            </a>
        </div>
        <div class="hero-image">
            <img src="assets/images/illustrations/illustration-reading-student.png" alt="Reading Student">
        </div>
    </div>

    <!-- Quick Access -->
    <div class="quick-access">
        <a href="index.php?page=katalog" class="quick-card">
            <div class="quick-icon">
                <i class="ti ti-search"></i>
            </div>
            <div>
                <h5>Cari Buku</h5>
                <p>Temukan buku favorit</p>
            </div>
        </a>
        <a href="index.php?page=peminjaman" class="quick-card">
            <div class="quick-icon">
                <i class="ti ti-clipboard-list"></i>
            </div>
            <div>
                <h5>Peminjaman Saya</h5>
                <p>Lihat riwayat pinjaman</p>
            </div>
        </a>
        <a href="index.php?page=profil" class="quick-card">
            <div class="quick-icon">
                <i class="ti ti-user"></i>
            </div>
            <div>
                <h5>Profil Saya</h5>
                <p>Kelola informasi akun</p>
            </div>
        </a>
    </div>

    <!-- Buku Terbaru -->
    <div class="section-header">
        <h3>Buku Terbaru</h3>
        <a href="index.php?page=katalog" class="view-all">Lihat Semua <i class="ti ti-arrow-right"></i></a>
    </div>
    <div class="books-grid">
        <?php foreach ($data['buku_terbaru'] as $buku): ?>
            <div class="book-card">
                <a href="index.php?page=detail_buku&id=<?= $buku['id'] ?>" class="book-cover" style="text-decoration:none;">
                    <img src="assets/images/covers/<?= $buku['cover'] ?>" alt="<?= $buku['judul'] ?>">
                </a>
                <div class="book-info">
                    <a href="index.php?page=detail_buku&id=<?= $buku['id'] ?>" style="text-decoration:none; color:inherit;">
                        <h5><?= $buku['judul'] ?></h5>
                    </a>
                    <p class="book-author"><?= $buku['penulis'] ?></p>
                    <span class="book-category"><?= $buku['nama_kategori'] ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
