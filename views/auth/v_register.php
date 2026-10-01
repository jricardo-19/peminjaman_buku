<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Siswa - Aplikasi Peminjaman Buku</title>
    
    <!-- Memanggil CSS utama Mantis Dashboard dari folder assets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Memanggil Icon FontAwesome dari assets -->
    <link rel="stylesheet" href="assets/fonts/fontawesome.css">
</head>
<body class="bg-light">

    <!-- Container Utama Form Register -->
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5 shadow-sm">
                    <div class="card-body">
                        
                        <!-- Header Form Register -->
                        <div class="text-center mb-4">
                            <h3 class="text-primary font-weight-bold">Registrasi Siswa</h3>
                            <p class="text-muted">Isi formulir di bawah ini untuk membuat akun anggota perpustakaan</p>
                        </div>

                        <!-- Menampilkan Pesan Error Jika Registrasi Gagal -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Registrasi Gagal!</strong> <?= htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form Utama Register Siswa -->
                        <form action="index.php?page=auth&action=register" method="POST">
                            
                            <!-- Input Nomor Induk Siswa (NIS) -->
                            <div class="form-group mb-3">
                                <label for="nis" class="form-label">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis" id="nis" class="form-control" placeholder="Contoh: 202510001" required autofocus>
                            </div>

                            <!-- Input Nama Lengkap Siswa -->
                            <div class="form-group mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <!-- Input Kelas -->
                            <div class="form-group mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Contoh: XII RPL 1" required>
                            </div>

                            <!-- Input Username Baru -->
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Buat username unik" required>
                            </div>

                            <!-- Input Password -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Buat password aman" required>
                            </div>

                            <!-- Tombol Submit Register -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-block">Daftar Akun</button>
                            </div>

                        </form>

                        <!-- Navigasi Kembali ke Login -->
                        <div class="text-center mt-4">
                            <p class="mb-1 text-muted">Sudah memiliki akun?</p>
                            <a href="index.php?page=auth&action=login" class="fw-bold text-primary">Login Di Sini</a>
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