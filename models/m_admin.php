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
    public function tambah_buku($id_admin, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $cover) {
        $query = "INSERT INTO tb_data_buku (id_admin, kode_buku, judul_buku, pengarang, penerbit, tahun_terbit, stok, cover) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("issssiis", $id_admin, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $cover);
        return $stmt->execute();
    }

    // ===== EDIT DATA BUKU ===== \\
    public function edit_buku($id_buku, $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $cover = null) {
        if ($cover) {
            $query = "UPDATE tb_data_buku SET kode_buku=?, judul_buku=?, pengarang=?, penerbit=?, tahun_terbit=?, stok=?, cover=? WHERE id_buku=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssiisi", $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $cover, $id_buku);
        } else {
            $query = "UPDATE tb_data_buku SET kode_buku=?, judul_buku=?, pengarang=?, penerbit=?, tahun_terbit=?, stok=? WHERE id_buku=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssiii", $kode_buku, $judul_buku, $pengarang, $penerbit, $tahun_terbit, $stok, $id_buku);
        }
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
                          b.judul_buku, b.cover, b.kode_buku
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
        $query = "SELECT r.*, u.nama_lengkap, u.nis, b.judul_buku, b.cover
                   FROM tb_riwayat r
                   JOIN tb_user u ON r.id_user = u.id_user
                   JOIN tb_data_buku b ON r.id_buku = b.id_buku
                   ORDER BY r.tgl_dikembalikan DESC";
        return $this->db->query($query);
    }

    // ===== STATISTIK PEMINJAMAN PER HARI DALAM MINGGU INI ===== \\
    public function get_statistik_mingguan() {
        $query = "SELECT DAYNAME(tgl_pinjam) AS hari, COUNT(*) AS total
                  FROM tb_transaksi
                  WHERE YEARWEEK(tgl_pinjam, 1) = YEARWEEK(CURDATE(), 1)
                  GROUP BY DAYNAME(tgl_pinjam), DAYOFWEEK(tgl_pinjam)
                  ORDER BY DAYOFWEEK(tgl_pinjam)";
        $result = $this->db->query($query);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['hari']] = intval($row['total']);
            }
        }
        // Also include riwayat (completed) this week
        $query2 = "SELECT DAYNAME(tgl_pinjam) AS hari, COUNT(*) AS total
                   FROM tb_riwayat
                   WHERE YEARWEEK(tgl_pinjam, 1) = YEARWEEK(CURDATE(), 1)
                   GROUP BY DAYNAME(tgl_pinjam), DAYOFWEEK(tgl_pinjam)
                   ORDER BY DAYOFWEEK(tgl_pinjam)";
        $result2 = $this->db->query($query2);
        if ($result2) {
            while ($row = $result2->fetch_assoc()) {
                $day = $row['hari'];
                if (isset($data[$day])) {
                    $data[$day] += intval($row['total']);
                } else {
                    $data[$day] = intval($row['total']);
                }
            }
        }
        return $data;
    }

    // ===== STATISTIK PEMINJAMAN PER HARI DALAM BULAN INI ===== \\
    public function get_statistik_bulanan() {
        $query = "SELECT DAY(tgl_pinjam) AS tanggal, COUNT(*) AS total
                  FROM tb_transaksi
                  WHERE MONTH(tgl_pinjam) = MONTH(CURDATE()) AND YEAR(tgl_pinjam) = YEAR(CURDATE())
                  GROUP BY DAY(tgl_pinjam)
                  ORDER BY DAY(tgl_pinjam)";
        $result = $this->db->query($query);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[intval($row['tanggal'])] = intval($row['total']);
            }
        }
        $query2 = "SELECT DAY(tgl_pinjam) AS tanggal, COUNT(*) AS total
                   FROM tb_riwayat
                   WHERE MONTH(tgl_pinjam) = MONTH(CURDATE()) AND YEAR(tgl_pinjam) = YEAR(CURDATE())
                   GROUP BY DAY(tgl_pinjam)
                   ORDER BY DAY(tgl_pinjam)";
        $result2 = $this->db->query($query2);
        if ($result2) {
            while ($row = $result2->fetch_assoc()) {
                $day = intval($row['tanggal']);
                if (isset($data[$day])) {
                    $data[$day] += intval($row['total']);
                } else {
                    $data[$day] = intval($row['total']);
                }
            }
        }
        return $data;
    }

    // ===== BUKU TERPOPULER BERDASARKAN JUMLAH DIPINJAM ===== \\
    public function get_buku_terpopuler($limit = 5) {
        $query = "SELECT b.id_buku, b.judul_buku, b.pengarang, b.cover,
                         (SELECT COUNT(*) FROM tb_transaksi t WHERE t.id_buku = b.id_buku) +
                         (SELECT COUNT(*) FROM tb_riwayat r WHERE r.id_buku = b.id_buku) AS jumlah_dipinjam
                  FROM tb_data_buku b
                  HAVING jumlah_dipinjam > 0
                  ORDER BY jumlah_dipinjam DESC
                  LIMIT " . intval($limit);
        $result = $this->db->query($query);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    'judul' => $row['judul_buku'],
                    'penulis' => $row['pengarang'],
                    'cover' => !empty($row['cover']) ? $row['cover'] : 'default.svg',
                    'jumlah_dipinjam' => intval($row['jumlah_dipinjam'])
                ];
            }
        }
        return $data;
    }

    // ===== PEMINJAMAN HARI INI (REAL) ===== \\
    public function get_peminjaman_hari_ini() {
        $result = $this->db->query("SELECT COUNT(*) AS jml FROM tb_transaksi WHERE DATE(tgl_pinjam) = CURDATE()");
        return $result->fetch_assoc()['jml'];
    }

    // ===== DATA PROFIL ADMIN ===== \\
    public function get_admin_by_id($id_admin) {
        $query = "SELECT * FROM tb_admin WHERE id_admin = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_admin);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ===== UPDATE PROFIL ADMIN ===== \\
    public function update_admin_profil($id_admin, $nama_lengkap, $password = null) {
        if (!empty($password)) {
            $pass_hash = md5($password);
            $query = "UPDATE tb_admin SET nama_lengkap = ?, password = ? WHERE id_admin = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssi", $nama_lengkap, $pass_hash, $id_admin);
        } else {
            $query = "UPDATE tb_admin SET nama_lengkap = ? WHERE id_admin = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $nama_lengkap, $id_admin);
        }
        return $stmt->execute();
    }

    // ===== PENCARIAN GLOBAL SEMUA HAL DALAM SISTEM (ROLE ADMIN) ===== \\
    public function search_all($keyword) {
        $kw = '%' . $keyword . '%';

        // 1. Buku
        $stmt1 = $this->db->prepare("SELECT id_buku, judul_buku, pengarang, penerbit, kode_buku, cover, stok FROM tb_data_buku WHERE judul_buku LIKE ? OR pengarang LIKE ? OR penerbit LIKE ? OR kode_buku LIKE ? ORDER BY judul_buku ASC LIMIT 20");
        $stmt1->bind_param("ssss", $kw, $kw, $kw, $kw);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
        $buku = [];
        while ($r = $res1->fetch_assoc()) {
            $r['cover'] = !empty($r['cover']) ? $r['cover'] : 'default.svg';
            $buku[] = $r;
        }

        // 2. Anggota
        $stmt2 = $this->db->prepare("SELECT id_user, nis, username, nama_lengkap, kelas FROM tb_user WHERE nama_lengkap LIKE ? OR nis LIKE ? OR username LIKE ? OR kelas LIKE ? ORDER BY nama_lengkap ASC LIMIT 20");
        $stmt2->bind_param("ssss", $kw, $kw, $kw, $kw);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        $anggota = [];
        while ($r = $res2->fetch_assoc()) {
            $anggota[] = $r;
        }

        // 3. Transaksi
        $stmt3 = $this->db->prepare("SELECT t.id_transaksi, t.tgl_pinjam, t.tgl_kembali, u.nama_lengkap, u.nis, b.judul_buku, b.cover, 'dipinjam' AS status
                                     FROM tb_transaksi t
                                     JOIN tb_user u ON t.id_user = u.id_user
                                     JOIN tb_data_buku b ON t.id_buku = b.id_buku
                                     WHERE u.nama_lengkap LIKE ? OR b.judul_buku LIKE ? OR u.nis LIKE ?
                                     ORDER BY t.tgl_kembali ASC LIMIT 20");
        $stmt3->bind_param("sss", $kw, $kw, $kw);
        $stmt3->execute();
        $res3 = $stmt3->get_result();
        $transaksi = [];
        while ($r = $res3->fetch_assoc()) {
            $r['cover'] = !empty($r['cover']) ? $r['cover'] : 'default.svg';
            $transaksi[] = $r;
        }

        return [
            'buku' => $buku,
            'anggota' => $anggota,
            'transaksi' => $transaksi
        ];
    }
}
?>