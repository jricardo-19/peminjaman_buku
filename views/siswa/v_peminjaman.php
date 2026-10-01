<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'sukses'): ?>
        <div class="alert alert-success">Peminjaman berhasil diajukan!</div>
    <?php elseif ($_GET['status'] === 'gagal'): ?>
        <div class="alert alert-danger">Peminjaman gagal. Stok buku mungkin sudah habis.</div>
    <?php endif; ?>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Buku Tersedia</h5>
        <form method="GET" action="index.php" class="d-flex gap-2">
            <input type="hidden" name="page" value="siswa">
            <input type="hidden" name="action" value="peminjaman">
            <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul / pengarang..." value="<?= htmlspecialchars($cari); ?>">
            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="ti ti-search"></i></button>
            <?php if ($cari !== ''): ?>
                <a href="index.php?page=siswa&action=peminjaman" class="btn btn-sm btn-outline-secondary">Reset</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Stok</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php $ada = false; while ($row = $data_buku->fetch_assoc()): $ada = true; ?>
                <tr>
                    <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                    <td><?= htmlspecialchars($row['pengarang']); ?></td>
                    <td><?= htmlspecialchars($row['penerbit']); ?></td>
                    <td><?= htmlspecialchars($row['stok']); ?></td>
                    <td>
                        <form method="POST" action="index.php?page=siswa&action=peminjaman" onsubmit="return confirm('Pinjam buku ini selama 7 hari?');">
                            <input type="hidden" name="id_buku" value="<?= $row['id_buku']; ?>">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-book-2 me-1"></i>Pinjam</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; if (!$ada): ?>
                <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada buku tersedia.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
