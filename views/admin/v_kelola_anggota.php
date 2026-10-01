<div class="pc-container">
    <div class="pc-content">

        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Tambah Anggota Baru</h5></div>
            <div class="card-body">
                <form method="POST" action="index.php?page=admin&action=kelola_anggota">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="ti ti-plus me-1"></i>Tambah Anggota</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">Daftar Anggota</h5>
                <form method="GET" action="index.php" class="d-flex gap-2">
                    <input type="hidden" name="page" value="admin">
                    <input type="hidden" name="action" value="kelola_anggota">
                    <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari nama / NIS / kelas..." value="<?= htmlspecialchars($cari); ?>">
                    <button type="submit" class="btn btn-sm btn-outline-primary"><i class="ti ti-search"></i></button>
                    <?php if ($cari !== ''): ?>
                        <a href="index.php?page=admin&action=kelola_anggota" class="btn btn-sm btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr><th>NIS</th><th>Username</th><th>Nama Lengkap</th><th>Kelas</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php $ada = false; while ($row = $data_anggota->fetch_assoc()): $ada = true; ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nis']); ?></td>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                            <td><?= htmlspecialchars($row['kelas']); ?></td>
                            <td>
                                <a href="index.php?page=admin&action=edit_anggota&id=<?= $row['id_user']; ?>" class="btn btn-sm btn-warning"><i class="ti ti-edit"></i></a>
                                <a href="index.php?page=admin&action=hapus_anggota&id=<?= $row['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?');"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; if (!$ada): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada anggota ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
