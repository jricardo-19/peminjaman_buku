<?php

require_once 'models/m_admin.php';

class c_admin {
    private $model;

    public function __construct() {
        $this->model = new m_admin();
    }

    // ===== TEMPLATE: GABUNGKAN HEADER + SIDEBAR + TOPBAR + VIEW + FOOTER ===== \\
    private function render($view, $data = []) {
        extract($data);
        require_once 'views/template/header.php';
        require_once 'views/template/sidebar.php';
        require_once 'views/template/topbar.php';
        require_once $view;
        require_once 'views/template/footer.php';
    }

    // ===== DASHBOARD ADMIN ===== \\
    public function dashboard() {
        $stats = $this->model->get_stats();
        $statistik_mingguan = $this->model->get_statistik_mingguan();
        $statistik_bulanan = $this->model->get_statistik_bulanan();
        $buku_terpopuler = $this->model->get_buku_terpopuler(5);
        $peminjaman_hari_ini = $this->model->get_peminjaman_hari_ini();

        $data = [
            'total_buku' => $stats['total_buku'],
            'total_anggota' => $stats['total_anggota'],
            'peminjaman_aktif' => $stats['dipinjam'],
            'peminjaman_hari_ini' => $peminjaman_hari_ini,
            'terlambat' => $stats['telat'],
            'buku_terpopuler' => $buku_terpopuler,
            'statistik_mingguan' => $statistik_mingguan,
            'statistik_bulanan' => $statistik_bulanan,
        ];
        
        $this->render('views/admin/v_dashboard.php', ['data' => $data]);
    }

    // ===== KELOLA DATA BUKU (LIST + PENCARIAN + TAMBAH) ===== \\
    public function kelola_buku() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_admin     = $_SESSION['id_admin'];
            $kode_buku    = trim($_POST['isbn'] ?? $_POST['kode_buku'] ?? rand(1000,9999));
            $judul_buku   = trim($_POST['judul']);
            $pengarang    = trim($_POST['penulis']);
            $penerbit     = trim($_POST['penerbit']);
            $tahun_terbit = trim($_POST['tahun_terbit']);
            $stok         = trim($_POST['stok']);
            
            $cover = 'default.svg';
            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
                $cover = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['cover']['tmp_name'], "assets/images/covers/" . $cover);
            }

            $this->model->tambah_buku($id_admin, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $cover);
            header("Location: index.php?page=kelola_buku");
            exit;
        }

        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $raw_buku = $this->model->get_semua_buku($cari);
        $buku = [];
        while($row = $raw_buku->fetch_assoc()) {
            $buku[] = [
                'id' => $row['id_buku'],
                'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                'judul' => $row['judul_buku'],
                'penulis' => $row['pengarang'],
                'nama_kategori' => 'Umum',
                'stok' => $row['stok']
            ];
        }
        
        $kategori = [
            ['id' => 1, 'nama_kategori' => 'Fiksi', 'icon' => 'book'],
            ['id' => 2, 'nama_kategori' => 'Non Fiksi', 'icon' => 'book-open'],
            ['id' => 3, 'nama_kategori' => 'Pendidikan', 'icon' => 'school'],
            ['id' => 4, 'nama_kategori' => 'Teknologi', 'icon' => 'cpu'],
            ['id' => 5, 'nama_kategori' => 'Sains', 'icon' => 'flask']
        ];
        
        $data = ['buku' => $buku, 'kategori' => $kategori];
        $this->render('views/admin/v_kelola_buku.php', ['data' => $data, 'cari' => $cari]);
    }

    // ===== EDIT DATA BUKU ===== \\
    public function edit_buku() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_buku      = $_POST['id'];
            $kode_buku    = trim($_POST['isbn'] ?? rand(1000,9999));
            $judul_buku   = trim($_POST['judul']);
            $pengarang    = trim($_POST['penulis']);
            $penerbit     = trim($_POST['penerbit']);
            $tahun_terbit = trim($_POST['tahun_terbit']);
            $stok         = trim($_POST['stok']);
            
            $cover = null;
            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
                $cover = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['cover']['tmp_name'], "assets/images/covers/" . $cover);
            }

            $this->model->edit_buku($id_buku, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $cover);
            header("Location: index.php?page=kelola_buku");
            exit;
        }

        $id_buku = $_GET['id'];
        $raw = $this->model->get_buku_by_id($id_buku);
        $buku = [
            'id' => $raw['id_buku'],
            'cover' => !empty($raw['cover']) ? $raw['cover'] : 'default.svg',
            'judul' => $raw['judul_buku'],
            'penulis' => $raw['pengarang'],
            'penerbit' => $raw['penerbit'],
            'tahun_terbit' => $raw['tahun_terbit'],
            'isbn' => $raw['kode_buku'],
            'stok' => $raw['stok'],
            'deskripsi' => '',
            'kategori_id' => 1
        ];
        
        $kategori = [
            ['id' => 1, 'nama_kategori' => 'Fiksi', 'icon' => 'book'],
            ['id' => 2, 'nama_kategori' => 'Non Fiksi', 'icon' => 'book-open'],
            ['id' => 3, 'nama_kategori' => 'Pendidikan', 'icon' => 'school'],
            ['id' => 4, 'nama_kategori' => 'Teknologi', 'icon' => 'cpu'],
            ['id' => 5, 'nama_kategori' => 'Sains', 'icon' => 'flask']
        ];
        
        $data = ['buku' => $buku, 'kategori' => $kategori];
        $this->render('views/admin/v_edit_buku.php', ['data' => $data]);
    }

    // ===== HAPUS DATA BUKU ===== \\
    public function hapus_buku() {
        $this->model->hapus_buku($_GET['id']);
        header("Location: index.php?page=kelola_buku");
        exit;
    }

    // ===== KELOLA DATA ANGGOTA (LIST + PENCARIAN + TAMBAH) ===== \\
    public function kelola_anggota() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis          = trim($_POST['nis']);
            $username     = explode('@', $_POST['email'])[0] ?? trim($_POST['nama_lengkap']);
            $password     = trim($_POST['password']);
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $kelas        = trim($_POST['no_telepon'] ?? 'Umum'); // repurpose kelas to phone

            $this->model->tambah_anggota($nis, $username, $password, $nama_lengkap, $kelas);
            header("Location: index.php?page=kelola_anggota");
            exit;
        }

        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $raw_anggota = $this->model->get_semua_anggota($cari);
        $anggota = [];
        while($row = $raw_anggota->fetch_assoc()) {
            $anggota[] = [
                'id' => $row['id_user'],
                'foto_profil' => 'default.svg',
                'nama_lengkap' => $row['nama_lengkap'],
                'nis' => $row['nis'],
                'email' => $row['username'] . '@sekolah.id', // mockup
                'no_telepon' => $row['kelas']
            ];
        }
        $data = ['anggota' => $anggota];
        $this->render('views/admin/v_kelola_anggota.php', ['data' => $data, 'cari' => $cari]);
    }

    // ===== EDIT DATA ANGGOTA ===== \\
    public function edit_anggota() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_user      = $_POST['id'];
            $nis          = trim($_POST['nis']);
            $username     = explode('@', $_POST['email'])[0] ?? trim($_POST['nama_lengkap']);
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $kelas        = trim($_POST['no_telepon']);

            $this->model->edit_anggota($id_user, $nis, $username, $nama_lengkap, $kelas);
            header("Location: index.php?page=kelola_anggota");
            exit;
        }

        $id_user = $_GET['id'];
        $raw = $this->model->get_anggota_by_id($id_user);
        $anggota = [
            'id' => $raw['id_user'],
            'nama_lengkap' => $raw['nama_lengkap'],
            'nis' => $raw['nis'],
            'email' => $raw['username'] . '@sekolah.id',
            'no_telepon' => $raw['kelas'],
            'alamat' => ''
        ];
        $data = ['anggota' => $anggota];
        $this->render('views/admin/v_edit_anggota.php', ['data' => $data]);
    }

    // ===== HAPUS DATA ANGGOTA ===== \\
    public function hapus_anggota() {
        $this->model->hapus_anggota($_GET['id']);
        header("Location: index.php?page=kelola_anggota");
        exit;
    }

    // ===== CRUD TRANSAKSI: MONITORING TRANSAKSI AKTIF + PENCARIAN + RIWAYAT ===== \\
    public function transaksi() {
        $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
        $raw_trans = $this->model->get_transaksi_aktif($cari);
        
        $transaksi = [];
        while($row = $raw_trans->fetch_assoc()) {
            $transaksi[] = [
                'id' => $row['id_transaksi'],
                'nama_lengkap' => $row['nama_lengkap'],
                'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                'judul_buku' => $row['judul_buku'],
                'tanggal_pinjam' => $row['tgl_pinjam'],
                'jatuh_tempo' => $row['tgl_kembali'],
                'tanggal_kembali' => null,
                'status' => 'dipinjam',
                'denda' => 0
            ];
        }
        
        // Merge riwayat
        $raw_riwayat = $this->model->get_riwayat();
        while($row = $raw_riwayat->fetch_assoc()) {
            $transaksi[] = [
                'id' => $row['id_riwayat'] . '_riwayat', // mock id
                'nama_lengkap' => $row['nama_lengkap'],
                'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                'judul_buku' => $row['judul_buku'],
                'tanggal_pinjam' => $row['tgl_pinjam'],
                'jatuh_tempo' => $row['tgl_dikembalikan'], // fallback
                'tanggal_kembali' => $row['tgl_dikembalikan'],
                'status' => 'dikembalikan',
                'denda' => $row['denda']
            ];
        }
        
        // Members for pinjam modal
        $raw_anggota = $this->model->get_semua_anggota();
        $anggota = [];
        while($row = $raw_anggota->fetch_assoc()) {
            $anggota[] = [
                'id' => $row['id_user'],
                'nama_lengkap' => $row['nama_lengkap'],
                'nis' => $row['nis']
            ];
        }
        
        // Books for pinjam modal
        $raw_buku = $this->model->get_semua_buku();
        $buku = [];
        while($row = $raw_buku->fetch_assoc()) {
            $buku[] = [
                'id' => $row['id_buku'],
                'judul' => $row['judul_buku'],
                'stok' => $row['stok']
            ];
        }

        $data = ['transaksi' => $transaksi, 'anggota' => $anggota, 'buku' => $buku];
        $this->render('views/admin/v_transaksi.php', ['data' => $data]);
    }
    
    public function pinjam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_user = $_POST['user_id'];
            $id_buku = $_POST['buku_id'];
            // add to model -> reusing m_siswa method? Need to add to m_admin.
            require_once 'models/m_siswa.php';
            $s_model = new m_siswa();
            $s_model->ajukan_pinjam($id_user, $id_buku);
            
            header("Location: index.php?page=transaksi");
            exit;
        }
    }

    // ===== PROSES PENGEMBALIAN BUKU (HITUNG DENDA, PINDAH KE RIWAYAT) ===== \\
    public function proses_pengembalian() {
        $this->model->proses_pengembalian($_GET['id']);
        header("Location: index.php?page=transaksi");
        exit;
    }

    // ===== HAPUS / BATALKAN TRANSAKSI (BAGIAN DARI CRUD TRANSAKSI) ===== \\
    public function hapus_transaksi() {
        $this->model->hapus_transaksi($_GET['id']);
        header("Location: index.php?page=transaksi");
        exit;
    }
    // ===== HALAMAN LAPORAN ===== \\
    public function laporan() {
        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        
        $stats = $this->model->get_stats();
        // Since we don't have a specific report query in model yet, we can use get_riwayat and get_transaksi_aktif and filter them.
        // Actually let's just get all riwayat.
        $raw_riwayat = $this->model->get_riwayat();
        $laporan_data = [];
        
        while($row = $raw_riwayat->fetch_assoc()) {
            // Filter by month/year if needed (simplified for now to just show all or implement basic filter)
            $tgl_kembali = strtotime($row['tgl_dikembalikan']);
            if (date('m', $tgl_kembali) == $bulan && date('Y', $tgl_kembali) == $tahun) {
                $laporan_data[] = [
                    'id' => $row['id_riwayat'],
                    'nama_lengkap' => $row['nama_lengkap'],
                    'judul_buku' => $row['judul_buku'],
                    'tanggal_pinjam' => $row['tgl_pinjam'],
                    'tanggal_kembali' => $row['tgl_dikembalikan'],
                    'denda' => $row['denda'],
                    'status' => 'Selesai'
                ];
            }
        }
        
        $data = [
            'total_buku' => $stats['total_buku'],
            'total_anggota' => $stats['total_anggota'],
            'total_peminjaman' => $stats['dipinjam'],
            'laporan' => $laporan_data,
            'bulan_aktif' => $bulan,
            'tahun_aktif' => $tahun
        ];
        
        $this->render('views/admin/v_laporan.php', ['data' => $data]);
    }

    // ===== PROFIL ADMIN ===== \\
    public function profil_admin() {
        $id_admin = $_SESSION['id_admin'] ?? 1;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
            
            $berhasil = $this->model->update_admin_profil($id_admin, $nama_lengkap, $password);
            if ($berhasil) {
                $_SESSION['nama'] = $nama_lengkap;
                header("Location: index.php?page=profil_admin&status=sukses");
            } else {
                header("Location: index.php?page=profil_admin&status=gagal");
            }
            exit;
        }

        $admin = $this->model->get_admin_by_id($id_admin);
        $data = ['admin' => $admin];
        $this->render('views/admin/v_profil.php', ['data' => $data]);
    }

    // ===== HALAMAN PENCARIAN GLOBAL (ADMIN) ===== \\
    public function search() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $results = !empty($q) ? $this->model->search_all($q) : ['buku' => [], 'anggota' => [], 'transaksi' => []];
        $data = [
            'keyword' => $q,
            'results' => $results
        ];
        $this->render('views/admin/v_search.php', ['data' => $data]);
    }

    // ===== API LIVE SEARCH DROPDOWN (ADMIN) ===== \\
    public function api_search() {
        header('Content-Type: application/json');
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        if (strlen($q) < 1) {
            echo json_encode(['buku' => [], 'anggota' => [], 'transaksi' => []]);
            exit;
        }
        $results = $this->model->search_all($q);
        echo json_encode($results);
        exit;
    }
}
?>