<?php

require_once 'config/cn_database.php';

class m_admin {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // ===== STATISTIK UNTUK DASHBOARD ===== \\
    public function get_stats() {
        $total_buku    = $this->db->query("SELECT COUNT(*) AS jml FROM tb_data_buku")->fetch_assoc()['jml'];
        $total_anggota = $this->db->query("SELECT COUNT(*) AS jml FROM tb_user")->fetch_assoc()['jml'];
        $dipinjam      = $this->db->query("SELECT COUNT(*) AS jml FROM tb_transaksi")->fetch_assoc()['jml'];
        $telat         = $this->db->query("SELECT COUNT(*) AS jml FROM tb_transaksi WHERE tgl_kembali < CURDATE()")->fetch_assoc()['jml'];

        return [
            'total_buku'    => $total_buku,
            'total_anggota' => $total_anggota,
            'dipinjam'      => $dipinjam,
            'telat'         => $telat
        ];
    }

    // ===== AMBIL DATA BUKU (BISA DIFILTER PENCARIAN) ===== \\
    public function get_semua_buku($cari = '') {
        if ($cari !== '') {
            $kw = '%' . $cari . '%';
            $query = "SELECT * FROM tb_data_buku WHERE judul_buku LIKE ? OR kode_buku LIKE ? OR pengarang LIKE ? ORDER BY judul_buku ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sss", $kw, $kw, $kw);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->db->query("SELECT * FROM tb_data_buku ORDER BY judul_buku ASC");
    }

    // ===== TAMBAH DATA BUKU ===== \\
    public function tambah_buku($id_admin, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok) {
        $query = "INSERT INTO tb_data_buku (id_admin, kode_buku, judul_buku, pengarang, penerbit, tahun_terbit, stok) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("issssii", $id_admin, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok);
        return $stmt->execute();
    }

    // ===== EDIT DATA BUKU ===== \\
    public function edit_buku($id_buku, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok) {
        $query = "UPDATE tb_data_buku SET kode_buku=?, judul_buku=?, pengarang=?, penerbit=?, tahun_terbit=?, stok=? WHERE id_buku=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssiii", $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $id_buku);
        return $stmt->execute();
    }

    // ===== HAPUS DATA BUKU ===== \\
    public function hapus_buku($id_buku) {
        $query = "DELETE FROM tb_data_buku WHERE id_buku = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_buku);
        return $stmt->execute();
    }

    // ===== AMBIL SATU DATA BUKU (UNTUK FORM EDIT) ===== \\
    public function get_buku_by_id($id_buku) {
        $query = "SELECT * FROM tb_data_buku WHERE id_buku = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_buku);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ===== AMBIL DATA ANGGOTA (BISA DIFILTER PENCARIAN) ===== \\
    public function get_semua_anggota($cari = '') {
        if ($cari !== '') {
            $kw = '%' . $cari . '%';
            $query = "SELECT * FROM tb_user WHERE nama_lengkap LIKE ? OR nis LIKE ? OR kelas LIKE ? ORDER BY nama_lengkap ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sss", $kw, $kw, $kw);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->db->query("SELECT * FROM tb_user ORDER BY nama_lengkap ASC");
    }

    // ===== TAMBAH ANGGOTA BARU (OLEH ADMIN) ===== \\
    public function tambah_anggota($nis, $username, $password, $nama_lengkap, $kelas) {
        $pass_hash = md5($password);
        $query = "INSERT INTO tb_user (nis, username, password, nama_lengkap, kelas) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssss", $nis, $username, $pass_hash, $nama_lengkap, $kelas);
        return $stmt->execute();
    }

    // ===== EDIT DATA ANGGOTA ===== \\
    public function edit_anggota($id_user, $nis, $username, $nama_lengkap, $kelas) {
        $query = "UPDATE tb_user SET nis=?, username=?, nama_lengkap=?, kelas=? WHERE id_user=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssi", $nis, $username, $nama_lengkap, $kelas, $id_user);
        return $stmt->execute();
    }

    // ===== HAPUS ANGGOTA ===== \\
    public function hapus_anggota($id_user) {
        $query = "DELETE FROM tb_user WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        return $stmt->execute();
    }

    // ===== AMBIL SATU DATA ANGGOTA (UNTUK FORM EDIT) ===== \\
    public function get_anggota_by_id($id_user) {
        $query = "SELECT * FROM tb_user WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ===== AMBIL TRANSAKSI AKTIF (BISA DIFILTER PENCARIAN) ===== \\
    public function get_transaksi_aktif($cari = '') {
        $query = "SELECT t.id_transaksi, t.tgl_pinjam, t.tgl_kembali,
                          u.nama_lengkap, u.nis, u.kelas,
                          b.judul_buku, b.kode_buku
                   FROM tb_transaksi t
                   JOIN tb_user u ON t.id_user = u.id_user
                   JOIN tb_data_buku b ON t.id_buku = b.id_buku";
        if ($cari !== '') {
            $kw = '%' . $cari . '%';
            $query .= " WHERE u.nama_lengkap LIKE ? OR b.judul_buku LIKE ?";
            $query .= " ORDER BY t.tgl_kembali ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $kw, $kw);
            $stmt->execute();
            return $stmt->get_result();
        }
        $query .= " ORDER BY t.tgl_kembali ASC";
        return $this->db->query($query);
    }

    // ===== HAPUS / BATALKAN TRANSAKSI (CRUD TRANSAKSI OLEH ADMIN) ===== \\
    public function hapus_transaksi($id_transaksi) {
        // Kembalikan dulu stok buku sebelum transaksi dihapus
        $query = "SELECT id_buku FROM tb_transaksi WHERE id_transaksi = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_transaksi);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if ($row) {
            $this->db->query("UPDATE tb_data_buku SET stok = stok + 1 WHERE id_buku = " . intval($row['id_buku']));
        }

        $query2 = "DELETE FROM tb_transaksi WHERE id_transaksi = ?";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param("i", $id_transaksi);
        return $stmt2->execute();
    }

    // ===== PROSES PENGEMBALIAN BUKU OLEH ADMIN (HITUNG DENDA, PINDAH KE RIWAYAT) ===== \\
    public function proses_pengembalian($id_transaksi) {
        $query = "SELECT * FROM tb_transaksi WHERE id_transaksi = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_transaksi);
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

    // ===== AMBIL RIWAYAT TRANSAKSI YANG SUDAH SELESAI ===== \\
    public function get_riwayat() {
        $query = "SELECT r.*, u.nama_lengkap, u.nis, b.judul_buku
                   FROM tb_riwayat r
                   JOIN tb_user u ON r.id_user = u.id_user
                   JOIN tb_data_buku b ON r.id_buku = b.id_buku
                   ORDER BY r.tgl_dikembalikan DESC";
        return $this->db->query($query);
    }
}
?>
