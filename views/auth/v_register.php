<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - E-Perpus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="auth-body">
    <div class="auth-container">
        <div class="auth-left" style="background-image: url('assets/images/backgrounds/bg-login-navy.png'); background-size: cover; background-position: center;">
            <div class="auth-brand">
                <img src="assets/images/logo-icon.svg" alt="E-Perpus" style="height: 32px;">
                <div>
                    <h4>E-Perpus</h4>
                    <small>Sistem Peminjaman Buku</small>
                </div>
            </div>
            <div class="auth-content">
                <h1>Membaca adalah investasi terbaik untuk masa depan.</h1>
                <p>Pinjam buku, perluas wawasan, raih mimpi.</p>
                <img src="assets/images/illustrations/illustration-book-stack.png" alt="Register Illustration" class="auth-illustration">
            </div>
        </div>
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <h2>Daftar Akun</h2>
                <p>Lengkapi data diri Anda untuk mendaftar.</p>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="index.php?page=register&action=proses" method="POST">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="input-icon">
                            <i class="ti ti-user"></i>
                            <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-icon">
                            <i class="ti ti-user"></i>
                            <input type="text" class="form-control" name="email" placeholder="AndiCobra" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>NIS</label>
                        <div class="input-icon">
                            <i class="ti ti-id"></i>
                            <input type="text" class="form-control" name="nis" placeholder="Masukkan NIS" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-icon">
                            <i class="ti ti-lock"></i>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                            <button type="button" class="toggle-password">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </form>
                <p class="auth-footer-text">Sudah punya akun? <a href="index.php?page=login">Masuk di sini</a></p>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = this.closest('.input-icon').querySelector('input');
                var icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'ti ti-eye-off';
                } else {
                    input.type = 'password';
                    icon.className = 'ti ti-eye';
                }
            });
        });
    </script>
</body>

</html>
