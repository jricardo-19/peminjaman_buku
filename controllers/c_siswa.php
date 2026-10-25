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
        
        $raw_buku = $this->model->get_buku_tersedia();
        $buku_terbaru = [];
        $i = 0;
        while($row = $raw_buku->fetch_assoc()) {
            if($i++ >= 6) break;
            $buku_terbaru[] = [
                'id' => $row['id_buku'],
                'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                'judul' => $row['judul_buku'],
                'penulis' => $row['pengarang'],
                'nama_kategori' => 'Umum'
            ];
        }
        
        $data = [
            'user' => ['nama_lengkap' => $_SESSION['nama_lengkap']],
            'buku_terbaru' => $buku_terbaru
        ];
        $this->render('views/siswa/v_dashboard.php', ['data' => $data]);
    }
    
    // ===== KATALOG BUKU ===== \\
    public function katalog() {
        $raw_buku = $this->model->get_buku_tersedia();
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
        $this->render('views/siswa/v_katalog.php', ['data' => $data]);
    }

    // ===== PEMINJAMAN BUKU (LIST BUKU TERSEDIA + PENCARIAN + AJUKAN PINJAM) ===== \\
    public function peminjaman() {
        // Proses Kembalikan Buku Langsung dari Menu Peminjaman
        if (isset($_GET['action']) && $_GET['action'] === 'kembali' && isset($_GET['id'])) {
            $id_transaksi = intval($_GET['id']);
            $this->model->kembalikan_buku($id_transaksi, $_SESSION['id_user']);
            header("Location: index.php?page=peminjaman&status=kembali_sukses");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_buku = $_POST['buku_id'] ?? $_POST['id_buku'] ?? (isset($_GET['id']) ? intval($_GET['id']) : 0);
            $berhasil = $this->model->ajukan_pinjam($_SESSION['id_user'], $id_buku);
            
            $redirect = $_POST['redirect'] ?? (isset($_GET['redirect']) ? $_GET['redirect'] : 'peminjaman');
            if ($redirect === 'detail_buku') {
                header("Location: index.php?page=detail_buku&id=" . $id_buku . "&status=" . ($berhasil ? 'sukses' : 'gagal'));
            } elseif ($redirect === 'katalog') {
                header("Location: index.php?page=katalog&status=" . ($berhasil ? 'sukses' : 'gagal'));
            } else {
                header("Location: index.php?page=peminjaman&status=" . ($berhasil ? 'sukses' : 'gagal'));
            }
            exit;
        }

        $raw_trans = $this->model->get_transaksi_saya($_SESSION['id_user']);
        $peminjaman = [];
        while($row = $raw_trans->fetch_assoc()) {
            $peminjaman[] = [
                'id' => $row['id_transaksi'],
                'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                'judul_buku' => $row['judul_buku'],
                'tanggal_pinjam' => $row['tgl_pinjam'],
                'jatuh_tempo' => $row['tgl_kembali'],
                'status' => 'dipinjam'
            ];
        }
        
        $data = ['peminjaman' => $peminjaman];
        $this->render('views/siswa/v_peminjaman.php', ['data' => $data]);
    }

    // ===== HISTORY PEMINJAMAN BUKU ===== \\
    public function history_peminjaman() {
        $raw_riwayat = $this->model->get_riwayat_saya($_SESSION['id_user']);
        $history = [];
        while($row = $raw_riwayat->fetch_assoc()) {
            $history[] = [
                'id' => $row['id_riwayat'],
                'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                'judul_buku' => $row['judul_buku'],
                'tanggal_pinjam' => $row['tgl_pinjam'],
                'tanggal_kembali' => $row['tgl_dikembalikan'],
                'denda' => $row['denda'],
                'status' => 'dikembalikan'
            ];
        }
        
        $data = ['history' => $history];
        $this->render('views/siswa/v_history_peminjaman.php', ['data' => $data]);
    }

    // Alias Pengembalian ke History Peminjaman
    public function pengembalian() {
        $this->history_peminjaman();
    }
    
    // ===== PROFIL SAYA ===== \\
    public function profil() {
        $raw_riwayat = $this->model->get_riwayat_saya($_SESSION['id_user']);
        $riwayat = [];
        while($row = $raw_riwayat->fetch_assoc()) {
            $riwayat[] = [
                'id' => $row['id_riwayat'],
                'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                'judul_buku' => $row['judul_buku'],
                'tanggal_pinjam' => $row['tgl_pinjam'],
                'status' => 'dikembalikan'
            ];
        }
        
        $data = [
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'],
                'foto_profil' => 'default.svg',
                'nis' => $_SESSION['nis'] ?? '-',
                'email' => ($_SESSION['username'] ?? 'user') . '@sekolah.id',
                'no_telepon' => $_SESSION['kelas'] ?? '-',
                'alamat' => '-'
            ],
            'riwayat' => $riwayat
        ];
        
        $this->render('views/siswa/v_profil.php', ['data' => $data]);
    }

    // ===== DETAIL BUKU ===== \\
    public function detail_buku() {
        $id_buku = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id_buku']) ? intval($_POST['id_buku']) : (isset($_POST['buku_id']) ? intval($_POST['buku_id']) : 0));

        // Proses Pinjam Buku Langsung dari Halaman Detail Buku (tanpa harus ke halaman peminjaman)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ((isset($_POST['action']) && $_POST['action'] === 'pinjam') || (isset($_GET['action']) && $_GET['action'] === 'pinjam'))) {
            $berhasil = $this->model->ajukan_pinjam($_SESSION['id_user'], $id_buku);

            $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || (isset($_POST['ajax']) && $_POST['ajax'] == '1');
            if ($is_ajax) {
                header('Content-Type: application/json');
                $updated_buku = $this->model->get_buku_by_id($id_buku);
                echo json_encode([
                    'status' => $berhasil ? 'sukses' : 'gagal',
                    'message' => $berhasil ? 'Buku berhasil dipinjam! Silakan ambil buku di perpustakaan.' : 'Gagal meminjam buku. Stok habis atau terjadi kesalahan.',
                    'stok' => $updated_buku ? intval($updated_buku['stok']) : 0,
                    'tgl_kembali' => date('d M Y', strtotime('+7 days'))
                ]);
                exit;
            }

            header("Location: index.php?page=detail_buku&id=" . $id_buku . "&status=" . ($berhasil ? 'sukses' : 'gagal'));
            exit;
        }

        $raw = $this->model->get_buku_by_id($id_buku);
        
        if (!$raw) {
            header("Location: index.php?page=katalog");
            exit;
        }

        $buku = [
            'id' => $raw['id_buku'],
            'cover' => !empty($raw['cover']) ? $raw['cover'] : 'default.svg',
            'judul' => $raw['judul_buku'],
            'penulis' => $raw['pengarang'],
            'penerbit' => $raw['penerbit'],
            'tahun_terbit' => $raw['tahun_terbit'],
            'stok' => $raw['stok'],
            'isbn' => $raw['kode_buku'],
            'nama_kategori' => 'Fiksi',
            'rating' => 4.8,
            'ulasan' => 120,
            'jumlah_dipinjam' => max(0, 20 - intval($raw['stok'])),
            'deskripsi' => 'Buku ini merupakan salah satu koleksi terbaik di perpustakaan kami. Tersedia untuk dipinjam oleh seluruh anggota perpustakaan.',
        ];

        $data = ['buku' => $buku];
        $this->render('views/siswa/v_detail_buku.php', ['data' => $data]);
    }

    // ===== HALAMAN PENCARIAN GLOBAL (SISWA) ===== \\
    public function search() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $id_user = $_SESSION['id_user'];
        $results = !empty($q) ? $this->model->search_all($id_user, $q) : ['buku' => [], 'peminjaman' => [], 'riwayat' => []];
        $data = [
            'keyword' => $q,
            'results' => $results
        ];
        $this->render('views/siswa/v_search.php', ['data' => $data]);
    }

    // ===== API LIVE SEARCH DROPDOWN (SISWA) ===== \\
    public function api_search() {
        header('Content-Type: application/json');
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $id_user = $_SESSION['id_user'];
        if (strlen($q) < 1) {
            echo json_encode(['buku' => [], 'peminjaman' => [], 'riwayat' => []]);
            exit;
        }
        $results = $this->model->search_all($id_user, $q);
        echo json_encode($results);
        exit;
    }
}
?>