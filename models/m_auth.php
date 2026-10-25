<?php

require_once 'config/cn_database.php';

class m_auth {
    private $db;
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // ===== VERIFIKASI LOGIN ADMIN ===== \\
    public function cek_login_admin($username, $password) {
        $pass_hash = md5($password);

        // Query Cek Data Admin \\
        $query = "SELECT * FROM tb_admin WHERE username = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username, $pass_hash);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    // ===== VERIFIKASI LOGIN SISWA ===== \\
    public function cek_login_user($username, $password) {
        $pass_hash = md5($password);

        // Query Cek Data Siswa \\
        $query = "SELECT * FROM tb_user WHERE username = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username, $pass_hash);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    // ===== REGISTRASI USER ====== \\
    public function registrasi_user($nis, $username, $password, $nama_lengkap, $kelas) {
        $pass_hash = md5($password);

        // Query Memasukan Data Siswa \\
        $query = "INSERT INTO tb_user (nis, username, password, nama_lengkap, kelas) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssss", $nis, $username, $pass_hash, $nama_lengkap, $kelas);

        return $stmt->execute();
    }
}
?>