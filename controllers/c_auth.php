<?php

require_once 'models/m_auth.php';

class c_auth {
    private $model;

    public function __construct() {
        $this->model = new m_auth();
    }

    public function index() {
        $this->login();
    }

    // ===== ALUR TAMPILAN, DAN EKSKUSI LOGIN ===== \\
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Cek Tabel Admin \\
            $admin = $this->model->cek_login_admin($username, $password);
            if ($admin) {
                $_SESSION['id_admin']     = $admin['id_admin'];
                $_SESSION['username']     = $admin['username'];
                $_SESSION['nama_lengkap'] = $admin['nama_lengkap'];
                $_SESSION['role']         = 'admin';

                // Alihkan ke halaman dashboard admin \\
                header("Location: index.php?page=admin_dashboard");
                exit;
            }

            // Cek Tabel User \\
            $user = $this->model->cek_login_user($username, $password);
            if ($user) {
                $_SESSION['id_user']      = $user['id_user'];
                $_SESSION['nis']          = $user['nis'];
                $_SESSION['username']     = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['kelas']        = $user['kelas'];
                $_SESSION['role']         = 'siswa'; // use role for UI

                // Alihkan ke halaman dashboard siswa \\
                header("Location: index.php?page=siswa_dashboard");
                exit;
            }

            $_SESSION['error'] = "Username atau Password yang Anda masukkan salah!";
            header("Location: index.php?page=login");
            exit;
        } else {
            require_once 'views/auth/v_login.php';
        }
    }


    // ===== DAFTAR SISWA ===== \\
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis          = trim($_POST['nis']);
            $email        = trim($_POST['email']);
            $username     = explode('@', $email)[0]; // generate username from email
            $password     = trim($_POST['password']);
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $kelas        = 'Umum'; // default class

            // Memanggil fungsi registrasi pada model m_auth \\
            $simpan = $this->model->registrasi_user($nis, $username, $password, $nama_lengkap, $kelas);

            if ($simpan) {
                $_SESSION['success'] = "Berhasil mendaftar. Silakan masuk.";
                header("Location: index.php?page=login");
                exit;
            } else {
                $_SESSION['error'] = "Gagal mendaftar. Pastikan NIS yang dimasukkan belum terdaftar!";
                header("Location: index.php?page=register");
                exit;
            }
        } else {
            require_once 'views/auth/v_register.php';
        }
    }

    // ===== LOGOUT ===== \\
    public function logout() {
        session_unset();
        session_destroy();

        // Alihkan kembali ke halaman utama (Landing Page)
        header("Location: index.php?page=landing");
        exit;
    }
}
?>