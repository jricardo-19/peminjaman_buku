<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Peminjaman Buku</title>
    
    <!-- Memanggil CSS utama Mantis Dashboard dari folder assets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Memanggil Icon Bootstrap / FontAwesome jika tersedia di assets -->
    <link rel="stylesheet" href="assets/fonts/fontawesome.css">
</head>
<body class="bg-light">

    <!-- Container Utama Form Login -->
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5 shadow-sm">
                    <div class="card-body">
                        
                        <!-- Header / Logo Aplikasi -->
                        <div class="text-center mb-4">
                            <h3 class="text-primary font-weight-bold">Peminjaman Buku</h3>
                            <p class="text-muted">Masukkan username & password untuk mengakses akun Anda</p>
                        </div>

                        <!-- Menampilkan Pesan Sukses Setelah Registrasi -->
                        <?php if (isset($_GET['status']) && $_GET['status'] === 'success_register'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Registrasi Berhasil!</strong> Silakan login dengan akun yang telah dibuat.
                            </div>
                        <?php endif; ?>

                        <!-- Menampilkan Pesan Error Jika Login Gagal -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Login Gagal!</strong> <?= htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form Utama Login -->
                        <form action="index.php?page=auth&action=login" method="POST">
                            
                            <!-- Input Username -->
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autofocus>
                            </div>

                            <!-- Input Password -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                            </div>

                            <!-- Tombol Submit Login -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-block">Masuk Ke Sistem</button>
                            </div>

                        </form>

                        <!-- Navigasi Ke Halaman Register dan Landing Page -->
                        <div class="text-center mt-4">
                            <p class="mb-1 text-muted">Belum memiliki akun siswa?</p>
                            <a href="index.php?page=auth&action=register" class="fw-bold text-primary">Daftar Akun Siswa Baru</a>
                            <div class="mt-3">
                                <a href="index.php?page=landing" class="text-secondary small">&larr; Kembali ke Landing Page</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Memanggil JS Utama dari Mantis Dashboard -->
    <script src="assets/js/plugins/bootstrap.min.js"></script>
</body>
</html>