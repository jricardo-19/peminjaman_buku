<div class="pc-container">
    <div class="pc-content">

        <div class="card">
            <div class="card-header"><h5 class="mb-0">Edit Data Anggota</h5></div>
            <div class="card-body">
                <form method="POST" action="index.php?page=admin&action=edit_anggota">
                    <input type="hidden" name="id_user" value="<?= $anggota['id_user']; ?>">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" value="<?= htmlspecialchars($anggota['nis']); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($anggota['username']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($anggota['nama_lengkap']); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="<?= htmlspecialchars($anggota['kelas']); ?>" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i>Simpan Perubahan</button>
                        <a href="index.php?page=admin&action=kelola_anggota" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
