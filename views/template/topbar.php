<!-- [ Header Topbar ] start -->
<header class="pc-header">
        <div class="header-wrapper"> 
            <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->

            <!-- Menu Navigasi Siswa -->
            <?php $aksi_aktif = $_GET['action'] ?? 'dashboard'; ?>
            <ul class="list-unstyled d-flex mb-0 gap-2">
                <li class="pc-h-item">
                    <a href="<?= BASE_URL ?>index.php?page=siswa&action=dashboard" class="pc-head-link ms-0 <?= ($aksi_aktif == 'dashboard') ? 'active' : ''; ?>">
                        <i class="ti ti-dashboard me-1"></i> Dashboard
                    </a>
                </li>
                <li class="pc-h-item">
                    <a href="<?= BASE_URL ?>index.php?page=siswa&action=peminjaman" class="pc-head-link ms-0 <?= ($aksi_aktif == 'peminjaman') ? 'active' : ''; ?>">
                        <i class="ti ti-books me-1"></i> Peminjaman
                    </a>
                </li>
                <li class="pc-h-item">
                    <a href="<?= BASE_URL ?>index.php?page=siswa&action=pengembalian" class="pc-head-link ms-0 <?= ($aksi_aktif == 'pengembalian') ? 'active' : ''; ?>">
                        <i class="ti ti-arrow-back-up me-1"></i> Pengembalian
                    </a>
                </li>
            </ul>

            <div class="ms-auto">
                <ul class="list-unstyled">
                    <!-- User Profile / Login Button -->
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti ti-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <?php if (isset($_SESSION['id_user'])): ?>
                                <div class="dropdown-header px-3 py-2">
                                    <h6 class="m-0 fw-bold"><?= htmlspecialchars($_SESSION['nama_lengkap']); ?></h6>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="<?= BASE_URL ?>index.php?page=auth&action=logout" class="dropdown-item" onclick="return confirm('Yakin ingin logout?');">
                                    <i class="ti ti-power"></i>
                                    <span>Logout</span>
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>index.php?page=auth&action=login" class="dropdown-item">
                                    <i class="ti ti-login"></i>
                                    <span>Login</span>
                                </a>
                                <a href="<?= BASE_URL ?>index.php?page=auth&action=register" class="dropdown-item">
                                    <i class="ti ti-user-plus"></i>
                                    <span>Register</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header Topbar ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- Konten halaman dinamis akan di-include di sini -->