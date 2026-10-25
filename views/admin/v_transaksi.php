<!-- Transaksi Content -->
<div class="content-area">
    <div class="page-header-simple">
        <div>
            <h2>Transaksi Peminjaman</h2>
            <p>Kelola semua transaksi peminjaman dan pengembalian buku.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pinjamModal">
            <i class="ti ti-plus"></i> Pinjam Buku Baru
        </button>
    </div>

    <!-- Transaction Table -->
    <div class="table-card">
        <div class="table-header">
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" placeholder="Cari transaksi..." id="searchTransaksi">
            </div>
            <div class="table-filters">
                <select class="form-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="dikembalikan">Dikembalikan</option>
                    <option value="terlambat">Terlambat</option>
                </select>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data['transaksi'] as $tr): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $tr['nama_lengkap'] ?></td>
                        <td>
                            <div class="book-cell">
                                <img src="assets/images/covers/<?= $tr['cover'] ?>" class="table-cover-sm" alt="">
                                <span><?= $tr['judul_buku'] ?></span>
                            </div>
                        </td>
                        <td><?= date('d M Y', strtotime($tr['tanggal_pinjam'])) ?></td>
                        <td><?= date('d M Y', strtotime($tr['jatuh_tempo'])) ?></td>
                        <td><?= $tr['tanggal_kembali'] ? date('d M Y', strtotime($tr['tanggal_kembali'])) : '-' ?></td>
                        <td>
                            <span class="status-badge <?= $tr['status'] ?>">
                                <?= ucfirst($tr['status']) ?>
                            </span>
                        </td>
                        <td>Rp <?= number_format($tr['denda'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($tr['status'] == 'dipinjam'): ?>
                                <a href="index.php?page=transaksi&action=kembali&id=<?= $tr['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pengembalian?')">
                                    <i class="ti ti-check"></i> Kembalikan
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Pinjam Buku -->
<div class="modal fade" id="pinjamModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pinjam Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=transaksi&action=pinjam" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Anggota</label>
                            <select class="form-select" name="user_id" required>
                                <option value="">Pilih Anggota</option>
                                <?php foreach ($data['anggota'] as $anggota): ?>
                                    <option value="<?= $anggota['id'] ?>"><?= $anggota['nama_lengkap'] ?> (<?= $anggota['nis'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Buku</label>
                            <select class="form-select" name="buku_id" required>
                                <option value="">Pilih Buku</option>
                                <?php foreach ($data['buku'] as $buku): ?>
                                    <?php if ($buku['stok'] > 0): ?>
                                        <option value="<?= $buku['id'] ?>"><?= $buku['judul'] ?> (Stok: <?= $buku['stok'] ?>)</option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jatuh Tempo</label>
                            <input type="date" class="form-control" name="jatuh_tempo" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Proses Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>
