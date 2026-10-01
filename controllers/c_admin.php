<?php

require_once 'models/m_admin.php';

class c_admin {
    private $model;

    public function __construct() {
        $this->model = new m_admin();
    }

    // ===== TEMPLATE: GABUNGKAN HEADER + SIDEBAR + VIEW + FOOTER ===== \\
    private function render($view, $data = []) {
        extract($data);
        require_once 'views/template/header.php';
        require_once 'views/template/sidebar.php';
        require_once $view;
        require_once 'views/template/footer.php';
    }

    // ===== DASHBOARD ADMIN ===== \\
    public function dashboard() {
        $stats = $this->model->get_stats();
        $this->render('views/admin/v_dashboard.php', ['stats' => $stats]);
    }

    // ===== KELOLA DATA BUKU (LIST + PENCARIAN + TAMBAH) ===== \\
    public function kelola_buku() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_admin     = $_SESSION['id_admin'];
            $kode_buku    = trim($_POST['kode_buku']);
            $judul_buku   = trim($_POST['judul_buku']);
            $pengarang    = trim($_POST['pengarang']);
            $penerbit     = trim($_POST['penerbit']);
            $tahun_terbit = trim($_POST['tahun_terbit']);
            $stok         = trim($_POST['stok']);

            $this->model->tambah_buku($id_admin, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok);
            header("Location: index.php?page=admin&action=kelola_buku");
            exit;
        }

        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $data_buku = $this->model->get_semua_buku($cari);
        $this->render('views/admin/v_kelola_buku.php', ['data_buku' => $data_buku, 'cari' => $cari]);
    }

    // ===== EDIT DATA BUKU ===== \\
    public function edit_buku() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_buku      = $_POST['id_buku'];
            $kode_buku    = trim($_POST['kode_buku']);
            $judul_buku   = trim($_POST['judul_buku']);
            $pengarang    = trim($_POST['pengarang']);
            $penerbit     = trim($_POST['penerbit']);
            $tahun_terbit = trim($_POST['tahun_terbit']);
            $stok         = trim($_POST['stok']);

            $this->model->edit_buku($id_buku, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok);
            header("Location: index.php?page=admin&action=kelola_buku");
            exit;
        }

        $id_buku = $_GET['id'];
        $buku = $this->model->get_buku_by_id($id_buku);
        $this->render('views/admin/v_edit_buku.php', ['buku' => $buku]);
    }

    // ===== HAPUS DATA BUKU ===== \\
    public function hapus_buku() {
        $this->model->hapus_buku($_GET['id']);
        header("Location: index.php?page=admin&action=kelola_buku");
        exit;
    }

    // ===== KELOLA DATA ANGGOTA (LIST + PENCARIAN + TAMBAH) ===== \\
    public function kelola_anggota() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis          = trim($_POST['nis']);
            $username     = trim($_POST['username']);
            $password     = trim($_POST['password']);
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $kelas        = trim($_POST['kelas']);

            $this->model->tambah_anggota($nis, $username, $password, $nama_lengkap, $kelas);
            header("Location: index.php?page=admin&action=kelola_anggota");
            exit;
        }

        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $data_anggota = $this->model->get_semua_anggota($cari);
        $this->render('views/admin/v_kelola_anggota.php', ['data_anggota' => $data_anggota, 'cari' => $cari]);
    }

    // ===== EDIT DATA ANGGOTA ===== \\
    public function edit_anggota() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_user      = $_POST['id_user'];
            $nis          = trim($_POST['nis']);
            $username     = trim($_POST['username']);
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $kelas        = trim($_POST['kelas']);

            $this->model->edit_anggota($id_user, $nis, $username, $nama_lengkap, $kelas);
            header("Location: index.php?page=admin&action=kelola_anggota");
            exit;
        }

        $id_user = $_GET['id'];
        $anggota = $this->model->get_anggota_by_id($id_user);
        $this->render('views/admin/v_edit_anggota.php', ['anggota' => $anggota]);
    }

    // ===== HAPUS DATA ANGGOTA ===== \\
    public function hapus_anggota() {
        $this->model->hapus_anggota($_GET['id']);
        header("Location: index.php?page=admin&action=kelola_anggota");
        exit;
    }

    // ===== CRUD TRANSAKSI: MONITORING TRANSAKSI AKTIF + PENCARIAN + RIWAYAT ===== \\
    public function transaksi() {
        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $data_transaksi = $this->model->get_transaksi_aktif($cari);
        $data_riwayat   = $this->model->get_riwayat();
        $this->render('views/admin/v_transaksi.php', [
            'data_transaksi' => $data_transaksi,
            'data_riwayat'   => $data_riwayat,
            'cari'           => $cari
        ]);
    }

    // ===== PROSES PENGEMBALIAN BUKU (HITUNG DENDA, PINDAH KE RIWAYAT) ===== \\
    public function proses_pengembalian() {
        $this->model->proses_pengembalian($_GET['id']);
        header("Location: index.php?page=admin&action=transaksi");
        exit;
    }

    // ===== HAPUS / BATALKAN TRANSAKSI (BAGIAN DARI CRUD TRANSAKSI) ===== \\
    public function hapus_transaksi() {
        $this->model->hapus_transaksi($_GET['id']);
        header("Location: index.php?page=admin&action=transaksi");
        exit;
    }
}
?>
