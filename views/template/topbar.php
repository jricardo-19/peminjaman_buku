<!-- [ Header Topbar ] start -->
<header class="pc-header ep-user-header">
    <div class="header-wrapper">
        <a href="<?= BASE_URL ?>index.php?page=siswa&action=dashboard" class="ep-user-brand">
            <span class="ep-brand-mark"><i class="ti ti-books"></i></span>
            <span>
                <strong>E-Perpus</strong>
                <small>Perpustakaan Sekolah</small>
            </span>
        </a>

        <?php $aksi_aktif = $_GET['action'] ?? 'dashboard'; ?>

        <nav class="ep-user-nav" aria-label="Navigasi siswa">
            <a href="<?= BASE_URL ?>index.php?page=siswa&action=dashboard" class="ep-nav-item <?= ($aksi_aktif == 'dashboard') ? 'active' : ''; ?>">
                <i class="ti ti-dashboard"></i><span>Dashboard</span>
            </a>
            <a href="<?= BASE_URL ?>index.php?page=siswa&action=peminjaman" class="ep-nav-item <?= ($aksi_aktif == 'peminjaman') ? 'active' : ''; ?>">
                <i class="ti ti-books"></i><span>Peminjaman</span>
            </a>
            <a href="<?= BASE_URL ?>index.php?page=siswa&action=pengembalian" class="ep-nav-item <?= ($aksi_aktif == 'pengembalian') ? 'active' : ''; ?>">
                <i class="ti ti-arrow-back-up"></i><span>Pengembalian</span>
            </a>
        </nav>

        <div class="dropdown ep-user-account">
            <a class="ep-account-button dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                <span class="ep-avatar"><i class="ti ti-user"></i></span>
                <span class="ep-account-text">
                    <strong><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Pengguna'); ?></strong>
                    <small>Siswa</small>
                </span>
                <i class="ti ti-chevron-down ep-account-chevron"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end ep-account-menu">
                <div class="ep-account-header">
                    <span class="ep-avatar large"><i class="ti ti-user"></i></span>
                    <div>
                        <strong><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Pengguna'); ?></strong>
                        <small>Akun Siswa</small>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="<?= BASE_URL ?>index.php?page=auth&action=logout" class="dropdown-item" onclick="return confirm('Yakin ingin logout?');">
                    <i class="ti ti-power"></i><span>Keluar dari akun</span>
                </a>
            </div>
        </div>
    </div>
</header>
<!-- [ Header Topbar ] end -->

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">