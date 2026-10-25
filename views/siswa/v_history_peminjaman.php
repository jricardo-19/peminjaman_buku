<!-- History Peminjaman Content -->
<div class="siswa-content">
    <div class="page-header-simple">
        <div>
            <h2>History Peminjaman</h2>
            <p>Riwayat seluruh buku yang pernah kamu pinjam dan kembalikan.</p>
        </div>
        <a href="index.php?page=peminjaman" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i class="ti ti-book"></i> Lihat Peminjaman Aktif
        </a>
    </div>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Judul Buku</th>
                    <th width="18%">Tanggal Pinjam</th>
                    <th width="18%">Tanggal Kembali</th>
                    <th width="12%">Denda</th>
                    <th width="12%">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['history'])): ?>
                    <?php $no = 1;
                    foreach ($data['history'] as $h): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div class="book-cell">
                                    <img src="assets/images/covers/<?= $h['cover'] ?>" class="table-cover-sm" alt="" onerror="this.src='assets/images/covers/default.svg'">
                                    <span style="font-weight: 500; color: var(--gray-800);"><?= htmlspecialchars($h['judul_buku']) ?></span>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($h['tanggal_pinjam'])) ?></td>
                            <td><?= date('d M Y', strtotime($h['tanggal_kembali'])) ?></td>
                            <td>
                                <?php if ($h['denda'] > 0): ?>
                                    <span style="color: #DC2626; font-weight: 600;">Rp <?= number_format($h['denda'], 0, ',', '.') ?></span>
                                <?php else: ?>
                                    <span style="color: #10B981; font-weight: 500;">Rp 0</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge" style="background: rgba(16, 185, 129, 0.1); color: #10B981; font-weight: 600; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                    Selesai
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 40px 20px; color: var(--gray-400);">
                            <i class="ti ti-history" style="font-size: 36px; display: block; margin-bottom: 8px;"></i>
                            Belum ada riwayat peminjaman buku yang selesai.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
