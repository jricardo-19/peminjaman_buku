<div class="pc-container">
    <div class="pc-content">

        <div class="card">
            <div class="card-header"><h5 class="mb-0">Edit Data Buku</h5></div>
            <div class="card-body">
                <form method="POST" action="index.php?page=admin&action=edit_buku">
                    <input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Kode Buku</label>
                            <input type="text" name="kode_buku" class="form-control" value="<?= htmlspecialchars($buku['kode_buku']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul_buku" class="form-control" value="<?= htmlspecialchars($buku['judul_buku']); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Pengarang</label>
                            <input type="text" name="pengarang" class="form-control" value="<?= htmlspecialchars($buku['pengarang']); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="<?= htmlspecialchars($buku['penerbit']); ?>" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun_terbit" class="form-control" value="<?= $buku['tahun_terbit']; ?>" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $buku['stok']; ?>" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i>Simpan Perubahan</button>
                        <a href="index.php?page=admin&action=kelola_buku" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
