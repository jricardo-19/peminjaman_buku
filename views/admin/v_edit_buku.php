<!-- Edit Buku Content -->
<div class="content-area">
    <div class="page-header-simple">
        <div>
            <h2>Edit Buku</h2>
            <p>Perbarui informasi buku.</p>
        </div>
        <a href="index.php?page=kelola_buku" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-card">
        <form action="index.php?page=kelola_buku&action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $data['buku']['id'] ?>">
            <input type="hidden" name="old_cover" value="<?= $data['buku']['cover'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" name="judul" value="<?= $data['buku']['judul'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penulis</label>
                    <input type="text" class="form-control" name="penulis" value="<?= $data['buku']['penulis'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="kategori_id" required>
                        <?php foreach ($data['kategori'] as $kat): ?>
                            <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $data['buku']['kategori_id'] ? 'selected' : '' ?>><?= $kat['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penerbit</label>
                    <input type="text" class="form-control" name="penerbit" value="<?= $data['buku']['penerbit'] ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" name="tahun_terbit" value="<?= $data['buku']['tahun_terbit'] ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">ISBN</label>
                    <input type="text" class="form-control" name="isbn" value="<?= $data['buku']['isbn'] ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stok" value="<?= $data['buku']['stok'] ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3"><?= $data['buku']['deskripsi'] ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Cover Buku</label>
                    <div class="mb-2">
                        <img src="assets/images/covers/<?= $data['buku']['cover'] ?>" alt="Current Cover" style="height: 100px; border-radius: 8px;">
                    </div>
                    <input type="file" class="form-control" name="cover" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah cover.</small>
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
