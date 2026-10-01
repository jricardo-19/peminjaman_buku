<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="<?= BASE_URL ?>index.php?page=admin&action=dashboard" class="b-brand text-primary">
                    <!-- Logo Aplikasi -->
                    <img src="<?= BASE_URL ?>assets/images/logo-dark.svg" alt="Logo" class="logo logo-lg" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Navigasi Utama</label>
                    </li>
                    <li class="pc-item <?= (($_GET['action'] ?? 'dashboard') == 'dashboard') ? 'active' : ''; ?>">
                        <a href="<?= BASE_URL ?>index.php?page=admin&action=dashboard" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Kelola Data</label>
                    </li>
                    <li class="pc-item <?= (in_array($_GET['action'] ?? '', ['kelola_buku', 'edit_buku'])) ? 'active' : ''; ?>">
                        <a href="<?= BASE_URL ?>index.php?page=admin&action=kelola_buku" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-books"></i></span>
                            <span class="pc-mtext">Kelola Buku</span>
                        </a>
                    </li>
                    <li class="pc-item <?= (in_array($_GET['action'] ?? '', ['kelola_anggota', 'edit_anggota'])) ? 'active' : ''; ?>">
                        <a href="<?= BASE_URL ?>index.php?page=admin&action=kelola_anggota" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Kelola Anggota</span>
                        </a>
                    </li>
                    <li class="pc-item <?= (($_GET['action'] ?? '') == 'transaksi') ? 'active' : ''; ?>">
                        <a href="<?= BASE_URL ?>index.php?page=admin&action=transaksi" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-arrows-exchange"></i></span>
                            <span class="pc-mtext">Transaksi</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Akun</label>
                    </li>
                    <li class="pc-item">
                        <a href="<?= BASE_URL ?>index.php?page=auth&action=logout" class="pc-link" onclick="return confirm('Yakin ingin logout?');">
                            <span class="pc-micon"><i class="ti ti-power"></i></span>
                            <span class="pc-mtext">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->