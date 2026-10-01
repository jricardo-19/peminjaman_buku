<?php if (isset($_GET['status']) && $_GET['status'] === 'sukses'): ?>
    <div class="alert alert-success">Buku berhasil dikembalikan!</div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Buku yang Sedang Kamu Pinjam</h5>
        <form method="GET" action="index.php" class="d-flex gap-2">
            <input type="hidden" name="page" value="siswa">
            <input type="hidden" name="action" value="pengembalian">
            <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul buku..." value="<?= htmlspecialchars($cari); ?>">
            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="ti ti-search"></i></button>
            <?php if ($cari !== ''): ?>
                <a href="index.php?page=siswa&action=pengembalian" class="btn btn-sm btn-outline-secondary">Reset</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Buku</th><th>Tgl Pinjam</th><th>Batas Kembali</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php $ada = false; while ($row = $data_transaksi->fetch_assoc()): $ada = true;
                    $telat = (strtotime(date('Y-m-d')) - strtotime($row['tgl_kembali'])) / 86400;
                    $estimasi_denda = ($telat > 1) ? floor($telat) * 1000 : 0;
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                    <td><?= $row['tgl_pinjam']; ?></td>
                    <td><?= $row['tgl_kembali']; ?></td>
                    <td>
                        <?php if ($telat > 1): ?>
                            <span class="badge bg-danger">Telat <?= floor($telat); ?> hari (denda Rp <?= number_format($estimasi_denda, 0, ',', '.'); ?>)</span>
                        <?php else: ?>
                            <span class="badge bg-success">Tepat waktu</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" action="index.php?page=siswa&action=pengembalian" onsubmit="return confirm('Kembalikan buku ini sekarang?');">
                            <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-arrow-back-up me-1"></i>Kembalikan</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; if (!$ada): ?>
                <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada buku yang sedang dipinjam.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
