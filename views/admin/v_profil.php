<!-- Profil Admin Content -->
<div class="content-area">
    <div class="page-header-simple" style="margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 700; color: var(--gray-900); margin: 0 0 4px 0;">Profil Administrator</h2>
            <p style="color: var(--gray-500); margin: 0; font-size: 14px;">Kelola informasi profil dan keamanan akun administrator.</p>
        </div>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            <i class="ti ti-circle-check" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
            <strong>Berhasil!</strong> Informasi profil berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            <i class="ti ti-alert-circle" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
            <strong>Gagal!</strong> Terjadi kesalahan saat memperbarui profil.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 320px 1fr; gap: 28px;">
        <!-- Left: Card Overview -->
        <div class="table-card" style="padding: 32px 24px; text-align: center; height: fit-content;">
            <div style="position: relative; width: 100px; height: 100px; margin: 0 auto 16px;">
                <img src="assets/images/profiles/<?= $_SESSION['foto'] ?? 'default.svg' ?>" alt="Admin Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-100);" onerror="this.src='assets/images/profiles/default.svg'">
            </div>
            <h4 style="font-size: 18px; font-weight: 700; color: var(--gray-900); margin: 0 0 6px 0;"><?= htmlspecialchars($data['admin']['nama_lengkap'] ?? $_SESSION['nama'] ?? 'Administrator') ?></h4>
            <span style="display: inline-block; background: var(--primary-100); color: var(--primary-500); font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; margin-bottom: 20px;">
                Administrator
            </span>
            <div style="border-top: 1px solid var(--gray-200); padding-top: 16px; text-align: left;">
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--gray-400); font-weight: 600;">Username</div>
                    <div style="font-size: 14px; font-weight: 600; color: var(--gray-800);"><?= htmlspecialchars($data['admin']['username'] ?? 'admin') ?></div>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--gray-400); font-weight: 600;">Role Sistem</div>
                    <div style="font-size: 14px; font-weight: 600; color: var(--gray-800);">Super Administrator</div>
                </div>
            </div>
        </div>

        <!-- Right: Form Edit Profil -->
        <div class="table-card" style="padding: 32px;">
            <h4 style="font-size: 18px; font-weight: 700; color: var(--gray-900); margin: 0 0 20px 0;">Ubah Data Akun</h4>
            <form action="index.php?page=profil_admin" method="POST">
                <div class="mb-3">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: var(--gray-700);">Username</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['admin']['username'] ?? 'admin') ?>" disabled style="background: var(--gray-100); cursor: not-allowed;">
                    <small style="color: var(--gray-400); font-size: 12px;">Username akun administrator tidak dapat diubah.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: var(--gray-700);">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['admin']['nama_lengkap'] ?? $_SESSION['nama'] ?? 'Administrator') ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: var(--gray-700);">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                        <i class="ti ti-device-floppy"></i> Simpan Perubahan
                    </button>
                    <a href="index.php?page=admin_dashboard" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
