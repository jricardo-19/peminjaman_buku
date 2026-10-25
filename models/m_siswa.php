<?php

require_once 'config/cn_database.php';

class m_siswa {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // ===== STATISTIK UNTUK DASHBOARD SISWA ===== \\
    public function get_stats($id_user) {
        $query = "SELECT COUNT(*) AS jml FROM tb_transaksi WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $sedang_dipinjam = $stmt->get_result()->fetch_assoc()['jml'];

        $query2 = "SELECT COUNT(*) AS jml FROM tb_riwayat WHERE id_user = ?";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param("i", $id_user);
        $stmt2->execute();
        $total_riwayat = $stmt2->get_result()->fetch_assoc()['jml'];

        return [
            'sedang_dipinjam' => $sedang_dipinjam,
            'total_riwayat'   => $total_riwayat
        ];
    }

    // ===== AMBIL DAFTAR BUKU YANG STOKNYA MASIH ADA (BISA DIFILTER PENCARIAN) ===== \\
    public function get_buku_tersedia($cari = '') {
        if ($cari !== '') {
            $kw = '%' . $cari . '%';
            $query = "SELECT * FROM tb_data_buku WHERE stok > 0 AND (judul_buku LIKE ? OR pengarang LIKE ?) ORDER BY judul_buku ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $kw, $kw);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->db->query("SELECT * FROM tb_data_buku WHERE stok > 0 ORDER BY judul_buku ASC");
    }

    // ===== AMBIL SATU DATA BUKU (UNTUK PROSES PEMINJAMAN) ===== \\
    public function get_buku_by_id($id_buku) {
        $query = "SELECT * FROM tb_data_buku WHERE id_buku = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_buku);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ===== AJUKAN PEMINJAMAN BUKU (LAMA PINJAM 7 HARI) ===== \\
    public function ajukan_pinjam($id_user, $id_buku) {
        $buku = $this->get_buku_by_id($id_buku);
        if (!$buku || $buku['stok'] < 1) {
            return false;
        }

        $id_admin    = $buku['id_admin'];
        $tgl_pinjam  = date('Y-m-d');
        $tgl_kembali = date('Y-m-d', strtotime('+7 days'));

        $query = "INSERT INTO tb_transaksi (id_admin, id_user, id_buku, tgl_pinjam, tgl_kembali) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iiiss", $id_admin, $id_user, $id_buku, $tgl_pinjam, $tgl_kembali);

        if ($stmt->execute()) {
            $this->db->query("UPDATE tb_data_buku SET stok = stok - 1 WHERE id_buku = " . intval($id_buku));
            return true;
        }
        return false;
    }

    // ===== AMBIL TRANSAKSI AKTIF MILIK SISWA INI (BISA DIFILTER PENCARIAN) ===== \\
    public function get_transaksi_saya($id_user, $cari = '') {
        $query = "SELECT t.id_transaksi, t.tgl_pinjam, t.tgl_kembali, b.judul_buku, b.kode_buku, b.cover
                   FROM tb_transaksi t
                   JOIN tb_data_buku b ON t.id_buku = b.id_buku
                   WHERE t.id_user = ?";
        if ($cari !== '') {
            $kw = '%' . $cari . '%';
            $query .= " AND b.judul_buku LIKE ?";
            $query .= " ORDER BY t.tgl_kembali ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $id_user, $kw);
            $stmt->execute();
            return $stmt->get_result();
        }
        $query .= " ORDER BY t.tgl_kembali ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result();
    }

    // ===== SISWA MENGEMBALIKAN BUKU SENDIRI (HITUNG DENDA, PINDAH KE RIWAYAT) ===== \\
    public function kembalikan_buku($id_transaksi, $id_user) {
        $query = "SELECT * FROM tb_transaksi WHERE id_transaksi = ? AND id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $id_transaksi, $id_user);
        $stmt->execute();
        $transaksi = $stmt->get_result()->fetch_assoc();

        if (!$transaksi) {
            return false;
        }

        $tgl_dikembalikan = date('Y-m-d');

        // ===== HITUNG DENDA JIKA TELAT LEBIH DARI 1 HARI (RP 1.000 / HARI) ===== \\
        $selisih_hari = (strtotime($tgl_dikembalikan) - strtotime($transaksi['tgl_kembali'])) / 86400;
        $denda = ($selisih_hari > 1) ? ($selisih_hari * 1000) : 0;

        $query_riwayat = "INSERT INTO tb_riwayat (id_transaksi, id_admin, id_user, id_buku, tgl_pinjam, tgl_dikembalikan, denda)
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $this->db->prepare($query_riwayat);
        $stmt2->bind_param(
            "iiiissi",
            $transaksi['id_transaksi'],
            $transaksi['id_admin'],
            $transaksi['id_user'],
            $transaksi['id_buku'],
            $transaksi['tgl_pinjam'],
            $tgl_dikembalikan,
            $denda
        );

        if ($stmt2->execute()) {
            $this->db->query("UPDATE tb_data_buku SET stok = stok + 1 WHERE id_buku = " . intval($transaksi['id_buku']));

            $query_hapus = "DELETE FROM tb_transaksi WHERE id_transaksi = ?";
            $stmt3 = $this->db->prepare($query_hapus);
            $stmt3->bind_param("i", $id_transaksi);
            return $stmt3->execute();
        }
        return false;
    }

    // ===== AMBIL RIWAYAT PEMINJAMAN MILIK SISWA INI ===== \\
    public function get_riwayat_saya($id_user) {
        $query = "SELECT r.*, b.judul_buku, b.cover
                   FROM tb_riwayat r
                   JOIN tb_data_buku b ON r.id_buku = b.id_buku
                   WHERE r.id_user = ?
                   ORDER BY r.tgl_dikembalikan DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result();
    }

    // ===== PENCARIAN GLOBAL SEMUA HAL DALAM SISTEM (ROLE SISWA) ===== \\
    public function search_all($id_user, $keyword) {
        $kw = '%' . $keyword . '%';

        // 1. Buku di Katalog
        $stmt1 = $this->db->prepare("SELECT id_buku, judul_buku, pengarang, penerbit, kode_buku, cover, stok FROM tb_data_buku WHERE judul_buku LIKE ? OR pengarang LIKE ? OR penerbit LIKE ? OR kode_buku LIKE ? ORDER BY judul_buku ASC LIMIT 20");
        $stmt1->bind_param("ssss", $kw, $kw, $kw, $kw);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
        $buku = [];
        while ($r = $res1->fetch_assoc()) {
            $r['cover'] = !empty($r['cover']) ? $r['cover'] : 'default.svg';
            $buku[] = $r;
        }

        // 2. Peminjaman Aktif Saya
        $stmt2 = $this->db->prepare("SELECT t.id_transaksi, t.tgl_pinjam, t.tgl_kembali, b.judul_buku, b.cover, 'dipinjam' AS status
                                     FROM tb_transaksi t
                                     JOIN tb_data_buku b ON t.id_buku = b.id_buku
                                     WHERE t.id_user = ? AND (b.judul_buku LIKE ? OR b.pengarang LIKE ?)");
        $stmt2->bind_param("iss", $id_user, $kw, $kw);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        $peminjaman = [];
        while ($r = $res2->fetch_assoc()) {
            $r['cover'] = !empty($r['cover']) ? $r['cover'] : 'default.svg';
            $peminjaman[] = $r;
        }

        // 3. Riwayat Saya
        $stmt3 = $this->db->prepare("SELECT r.id_riwayat, r.tgl_pinjam, r.tgl_dikembalikan, r.denda, b.judul_buku, b.cover, 'selesai' AS status
                                     FROM tb_riwayat r
                                     JOIN tb_data_buku b ON r.id_buku = b.id_buku
                                     WHERE r.id_user = ? AND (b.judul_buku LIKE ? OR b.pengarang LIKE ?)");
        $stmt3->bind_param("iss", $id_user, $kw, $kw);
        $stmt3->execute();
        $res3 = $stmt3->get_result();
        $riwayat = [];
        while ($r = $res3->fetch_assoc()) {
            $r['cover'] = !empty($r['cover']) ? $r['cover'] : 'default.svg';
            $riwayat[] = $r;
        }

        return [
            'buku' => $buku,
            'peminjaman' => $peminjaman,
            'riwayat' => $riwayat
        ];
    }
}
?>