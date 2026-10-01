<?php

require_once 'models/m_siswa.php';

class c_siswa {
    private $model;

    public function __construct() {
        $this->model = new m_siswa();
    }

    // ===== TEMPLATE: GABUNGKAN HEADER + TOPBAR + VIEW + FOOTER ===== \\
    private function render($view, $data = []) {
        extract($data);
        require_once 'views/template/header.php';
        require_once 'views/template/topbar.php';
        require_once $view;
        require_once 'views/template/footer.php';
    }

    // ===== DASHBOARD SISWA ===== \\
    public function dashboard() {
        $stats = $this->model->get_stats($_SESSION['id_user']);
        $this->render('views/siswa/v_dashboard.php', ['stats' => $stats]);
    }

    // ===== PEMINJAMAN BUKU (LIST BUKU TERSEDIA + PENCARIAN + AJUKAN PINJAM) ===== \\
    public function peminjaman() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_buku = $_POST['id_buku'];
            $berhasil = $this->model->ajukan_pinjam($_SESSION['id_user'], $id_buku);

            if ($berhasil) {
                header("Location: index.php?page=siswa&action=peminjaman&status=sukses");
            } else {
                header("Location: index.php?page=siswa&action=peminjaman&status=gagal");
            }
            exit;
        }

        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $data_buku = $this->model->get_buku_tersedia($cari);
        $this->render('views/siswa/v_peminjaman.php', ['data_buku' => $data_buku, 'cari' => $cari]);
    }

    // ===== PENGEMBALIAN BUKU (LIST TRANSAKSI AKTIF SISWA + PENCARIAN + PROSES KEMBALI) ===== \\
    public function pengembalian() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_transaksi = $_POST['id_transaksi'];
            $this->model->kembalikan_buku($id_transaksi, $_SESSION['id_user']);
            header("Location: index.php?page=siswa&action=pengembalian&status=sukses");
            exit;
        }

        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $data_transaksi = $this->model->get_transaksi_saya($_SESSION['id_user'], $cari);
        $this->render('views/siswa/v_pengembalian.php', ['data_transaksi' => $data_transaksi, 'cari' => $cari]);
    }
}
?>
