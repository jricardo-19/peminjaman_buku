<?php
// Definisikan BASE_URL untuk absolute path pemanggilan aset CSS/JS
define('BASE_URL', 'http://localhost/peminjaman_buku/');

session_start();
require_once 'config/cn_database.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'landing';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// ====== AUTENTIKASI ====== \\
if (in_array($page, ['login', 'register', 'logout']) || $page == 'auth') {
    require_once 'controllers/c_auth.php';
    $auth = new c_auth();
    
    // Normalize page if using old auth url
    if ($page == 'auth') {
        if ($action == 'register') $page = 'register';
        else if ($action == 'logout') $page = 'logout';
        else $page = 'login';
    }

    if ($page == 'login') {
        if ($action == 'proses') $auth->login(); else $auth->login();
    } elseif ($page == 'register') {
        if ($action == 'proses') $auth->register(); else $auth->register();
    } elseif ($page == 'logout') {
        $auth->logout();
    }
    exit;
}

// ===== LANDING PAGE ====== \\
if ($page == 'landing') {
    require_once 'views/landing/v_landing.php';
    exit;
}

// Check session
if (!isset($_SESSION['id_admin']) && !isset($_SESSION['id_user'])) {
    header("Location: index.php?page=login");
    exit;
}

// Map Session UI Variables
if (isset($_SESSION['id_admin'])) {
    $_SESSION['role'] = 'admin';
    $_SESSION['nama'] = $_SESSION['nama_lengkap'];
    $_SESSION['foto'] = 'default.svg';
} else if (isset($_SESSION['id_user'])) {
    $_SESSION['role'] = 'siswa';
    $_SESSION['nama'] = $_SESSION['nama_lengkap'];
    $_SESSION['foto'] = 'default.svg';
}

// ===== HALAMAN ADMIN ===== \\
if (in_array($page, ['admin_dashboard', 'kelola_buku', 'kelola_anggota', 'transaksi', 'laporan', 'profil_admin']) || ($page === 'search' && isset($_SESSION['id_admin'])) || ($page === 'api_search' && isset($_SESSION['id_admin']))) {
    if (!isset($_SESSION['id_admin'])) {
        header("Location: index.php?page=siswa_dashboard");
        exit;
    }
    require_once 'controllers/c_admin.php';
    $admin = new c_admin();
    
    switch ($page) {
        case 'admin_dashboard':
            $admin->dashboard();
            break;
        case 'kelola_buku':
            if ($action == 'tambah') $admin->kelola_buku();
            else if ($action == 'edit' || $action == 'update') $admin->edit_buku();
            else if ($action == 'hapus') $admin->hapus_buku();
            else $admin->kelola_buku();
            break;
        case 'kelola_anggota':
            if ($action == 'tambah') $admin->kelola_anggota();
            else if ($action == 'edit' || $action == 'update') $admin->edit_anggota();
            else if ($action == 'hapus') $admin->hapus_anggota();
            else $admin->kelola_anggota();
            break;
        case 'transaksi':
            if ($action == 'pinjam') $admin->pinjam();
            else if ($action == 'kembali') {
                $_GET['id'] = $_GET['id']; // pass to model
                $admin->proses_pengembalian();
            } else $admin->transaksi();
            break;
        case 'laporan':
            $admin->laporan();
            break;
        case 'profil_admin':
            $admin->profil_admin();
            break;
        case 'search':
            $admin->search();
            break;
        case 'api_search':
            $admin->api_search();
            break;
    }
    exit;
}

// ====== HALAMAN SISWA ====== \\
if (in_array($page, ['siswa_dashboard', 'katalog', 'detail_buku', 'peminjaman', 'history_peminjaman', 'pengembalian', 'profil']) || ($page === 'search' && isset($_SESSION['id_user'])) || ($page === 'api_search' && isset($_SESSION['id_user']))) {
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?page=admin_dashboard");
        exit;
    }
    require_once 'controllers/c_siswa.php';
    $siswa = new c_siswa();
    
    switch ($page) {
        case 'siswa_dashboard':
            $siswa->dashboard();
            break;
        case 'katalog':
            $siswa->katalog();
            break;
        case 'detail_buku':
            $siswa->detail_buku();
            break;
        case 'peminjaman':
            $siswa->peminjaman();
            break;
        case 'history_peminjaman':
        case 'pengembalian':
            $siswa->history_peminjaman();
            break;
        case 'profil':
            $siswa->profil();
            break;
        case 'search':
            $siswa->search();
            break;
        case 'api_search':
            $siswa->api_search();
            break;
    }
    exit;
}

echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
echo "<p>Maaf, halaman yang Anda cari tidak ada.</p>";
echo "<a href='index.php?page=landing'>Kembali ke Halaman Utama</a>";