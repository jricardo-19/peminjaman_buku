<!-- Edit Anggota Content -->
<div class="content-area">
    <div class="page-header-simple">
        <div>
            <h2>Edit Anggota</h2>
            <p>Perbarui informasi anggota.</p>
        </div>
        <a href="index.php?page=kelola_anggota" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-card">
        <form action="index.php?page=kelola_anggota&action=update" method="POST">
            <input type="hidden" name="id" value="<?= $data['anggota']['id'] ?>">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" value="<?= $data['anggota']['nama_lengkap'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= $data['anggota']['email'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIS</label>
                    <input type="text" class="form-control" name="nis" value="<?= $data['anggota']['nis'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" name="no_telepon" value="<?= $data['anggota']['no_telepon'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="2"><?= $data['anggota']['alamat'] ?></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
