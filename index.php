<?php
// Definisikan BASE_URL untuk absolute path pemanggilan aset CSS/JS
define('BASE_URL', 'http://localhost/peminjaman_buku/');

session_start();
require_once 'config/cn_database.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'landing';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($page) {
    // ===== LANDING PAGE ====== \\
    case 'landing':
        require_once 'views/landing/v_landing.php';
        break;

    // ====== AUTENTIKASI ====== \\
    case 'auth':
        require_once 'controllers/c_auth.php';
        $auth = new c_auth();
        switch ($action) {
            case 'login':
                $auth->login();
                break;
            case 'register':
                $auth->register(); 
                break;
            case 'logout':
                $auth->logout();
                break;
            default:
                $auth->index();
                break;
        }
        break;


    // ===== HALAMAN ADMIN ===== \\
    case 'admin':
        if (!isset($_SESSION['id_admin'])) {
            header("Location: index.php?page=auth&action=login");
            exit;
        }

        require_once 'controllers/c_admin.php';
        $admin = new c_admin();
        switch ($action) {
            case 'kelola_buku':
                $admin->kelola_buku();
                break;
            case 'edit_buku':
                $admin->edit_buku();
                break;
            case 'hapus_buku':
                $admin->hapus_buku();
                break;
            case 'kelola_anggota':
                $admin->kelola_anggota();
                break;
            case 'edit_anggota':
                $admin->edit_anggota();
                break;
            case 'hapus_anggota':
                $admin->hapus_anggota();
                break;
            case 'transaksi':
                $admin->transaksi();
                break;
            case 'proses_pengembalian':
                $admin->proses_pengembalian();
                break;
            case 'hapus_transaksi':
                $admin->hapus_transaksi();
                break;
            default:
                $admin->dashboard(); 
                break;
        }
        break;


    // ====== HALAMAN SISWA ====== \\
    case 'siswa':
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=auth&action=login");
            exit;
        }

        require_once 'controllers/c_siswa.php';
        $siswa = new c_siswa();
        switch ($action) {
            case 'peminjaman':
                $siswa->peminjaman();
                break;
            case 'pengembalian':
                $siswa->pengembalian();
                break;
            default:
                $siswa->dashboard(); 
                break;
        }
        break;


    // ===== JIKA HALAMAN TIDAK DITEMUKAN ===== \\
    default:
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        echo "<p>Maaf, halaman yang Anda cari tidak ada.</p>";
        echo "<a href='index.php?page=landing'>Kembali ke Halaman Utama</a>";
        break;
}
?>