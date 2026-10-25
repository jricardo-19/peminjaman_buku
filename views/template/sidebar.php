<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="assets/images/logo-icon.svg" alt="E-Perpus" style="height: 28px;">
            <div>
                <h5>E-Perpus</h5>
                <small>Sistem Peminjaman Buku</small>
            </div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'admin_dashboard') ? 'active' : '' ?>">
                    <a href="index.php?page=admin_dashboard">
                        <i class="ti ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'kelola_buku') ? 'active' : '' ?>">
                    <a href="index.php?page=kelola_buku">
                        <i class="ti ti-book"></i>
                        <span>Kelola Buku</span>
                    </a>
                </li>
                <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'kelola_anggota') ? 'active' : '' ?>">
                    <a href="index.php?page=kelola_anggota">
                        <i class="ti ti-users"></i>
                        <span>Kelola Anggota</span>
                    </a>
                </li>
                <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'transaksi') ? 'active' : '' ?>">
                    <a href="index.php?page=transaksi">
                        <i class="ti ti-arrows-exchange"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
                <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'laporan') ? 'active' : '' ?>">
                    <a href="index.php?page=laporan">
                        <i class="ti ti-file-report"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <img src="assets/images/profiles/<?= $_SESSION['foto'] ?? 'default.png' ?>" alt="User">
            <div>
                <span class="user-name"><?= $_SESSION['nama'] ?? 'User' ?></span>
                <span class="user-role"><?= $_SESSION['role'] == 'admin' ? 'Administrator' : 'Siswa' ?></span>
            </div>
        </div>
    </div>
</aside>
