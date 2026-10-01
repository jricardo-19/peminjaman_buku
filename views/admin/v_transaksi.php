<div class="pc-container">
    <div class="pc-content">

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">Transaksi Aktif (Sedang Dipinjam)</h5>
                <form method="GET" action="index.php" class="d-flex gap-2">
                    <input type="hidden" name="page" value="admin">
                    <input type="hidden" name="action" value="transaksi">
                    <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari nama siswa / judul buku..." value="<?= htmlspecialchars($cari); ?>">
                    <button type="submit" class="btn btn-sm btn-outline-primary"><i class="ti ti-search"></i></button>
                    <?php if ($cari !== ''): ?>
                        <a href="index.php?page=admin&action=transaksi" class="btn btn-sm btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr><th>Peminjam</th><th>Kelas</th><th>Buku</th><th>Tgl Pinjam</th><th>Batas Kembali</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php $ada = false; while ($row = $data_transaksi->fetch_assoc()): $ada = true;
                            $telat = (strtotime(date('Y-m-d')) - strtotime($row['tgl_kembali'])) / 86400;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_lengkap']); ?> (<?= htmlspecialchars($row['nis']); ?>)</td>
                            <td><?= htmlspecialchars($row['kelas']); ?></td>
                            <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                            <td><?= $row['tgl_pinjam']; ?></td>
                            <td><?= $row['tgl_kembali']; ?></td>
                            <td>
                                <?php if ($telat > 1): ?>
                                    <span class="badge bg-danger">Telat <?= floor($telat); ?> hari</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Tepat waktu</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?page=admin&action=proses_pengembalian&id=<?= $row['id_transaksi']; ?>" class="btn btn-sm btn-primary" onclick="return confirm('Tandai buku ini sudah dikembalikan?');">
                                    <i class="ti ti-check"></i>
                                </a>
                                <a href="index.php?page=admin&action=hapus_transaksi&id=<?= $row['id_transaksi']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Batalkan transaksi ini? Stok buku akan dikembalikan tanpa tercatat di riwayat.');">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; if (!$ada): ?>
                        <tr><td colspan="7" class="text-center text-muted py-3">Tidak ada transaksi aktif.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0">Riwayat Peminjaman Selesai</h5></div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr><th>Peminjam</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Dikembalikan</th><th>Denda</th></tr>
                    </thead>
                    <tbody>
                        <?php $ada2 = false; while ($row = $data_riwayat->fetch_assoc()): $ada2 = true; ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_lengkap']); ?> (<?= htmlspecialchars($row['nis']); ?>)</td>
                            <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                            <td><?= $row['tgl_pinjam']; ?></td>
                            <td><?= $row['tgl_dikembalikan']; ?></td>
                            <td>
                                <?php if ($row['denda'] > 0): ?>
                                    <span class="badge bg-danger">Rp <?= number_format($row['denda'], 0, ',', '.'); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-success">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; if (!$ada2): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada riwayat.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
