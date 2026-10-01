        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Tambah Buku Baru</h5></div>
            <div class="card-body">
                <form method="POST" action="index.php?page=admin&action=kelola_buku">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Kode Buku</label>
                            <input type="text" name="kode_buku" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul_buku" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Pengarang</label>
                            <input type="text" name="pengarang" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun_terbit" class="form-control" min="1900" max="<?= date('Y'); ?>" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" min="0" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="ti ti-plus me-1"></i>Tambah Buku</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">Daftar Buku</h5>
                <form method="GET" action="index.php" class="d-flex gap-2">
                    <input type="hidden" name="page" value="admin">
                    <input type="hidden" name="action" value="kelola_buku">
                    <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul / kode / pengarang..." value="<?= htmlspecialchars($cari); ?>">
                    <button type="submit" class="btn btn-sm btn-outline-primary"><i class="ti ti-search"></i></button>
                    <?php if ($cari !== ''): ?>
                        <a href="index.php?page=admin&action=kelola_buku" class="btn btn-sm btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Tahun</th><th>Stok</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ada = false; while ($row = $data_buku->fetch_assoc()): $ada = true; ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_buku']); ?></td>
                            <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                            <td><?= htmlspecialchars($row['pengarang']); ?></td>
                            <td><?= htmlspecialchars($row['penerbit']); ?></td>
                            <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                            <td><?= htmlspecialchars($row['stok']); ?></td>
                            <td>
                                <a href="index.php?page=admin&action=edit_buku&id=<?= $row['id_buku']; ?>" class="btn btn-sm btn-warning"><i class="ti ti-edit"></i></a>
                                <a href="index.php?page=admin&action=hapus_buku&id=<?= $row['id_buku']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?');"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; if (!$ada): ?>
                        <tr><td colspan="7" class="text-center text-muted py-3">Tidak ada data buku ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
