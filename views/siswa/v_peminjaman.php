<!-- Peminjaman Content -->
<div class="siswa-content">
    <div class="page-header-simple">
        <div>
            <h2>Peminjaman Buku</h2>
            <p>Daftar buku yang sedang kamu pinjam.</p>
        </div>
        <a href="index.php?page=katalog" class="btn btn-primary">
            <i class="ti ti-plus"></i> Pinjam Buku Baru
        </a>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
            <i class="ti ti-circle-check" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
            <strong>Berhasil!</strong> Buku telah dipinjam dan ditambahkan ke daftar peminjaman aktif kamu.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'kembali_sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
            <i class="ti ti-circle-check" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
            <strong>Berhasil!</strong> Buku telah berhasil dikembalikan. Riwayat peminjaman telah dipindahkan ke menu <a href="index.php?page=history_peminjaman" style="font-weight: 600; color: inherit; text-decoration: underline;">History Peminjaman</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
            <i class="ti ti-alert-circle" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
            <strong>Gagal!</strong> Terjadi kesalahan saat memproses data.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Judul Buku</th>
                    <th width="18%">Tanggal Pinjam</th>
                    <th width="18%">Jatuh Tempo</th>
                    <th width="12%">Status</th>
                    <th width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['peminjaman'])): ?>
                    <?php $no = 1;
                    foreach ($data['peminjaman'] as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div class="book-cell">
                                    <img src="assets/images/covers/<?= $p['cover'] ?>" class="table-cover-sm" alt="" onerror="this.src='assets/images/covers/default.svg'">
                                    <span style="font-weight: 500; color: var(--gray-800);"><?= htmlspecialchars($p['judul_buku']) ?></span>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?></td>
                            <td><?= date('d M Y', strtotime($p['jatuh_tempo'])) ?></td>
                            <td>
                                <span class="status-badge <?= $p['status'] ?>">
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?page=peminjaman&action=kembali&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 6px;" onclick="return confirm('Apakah kamu yakin ingin mengembalikan buku ini sekarang?')">
                                    <i class="ti ti-rotate"></i> Kembalikan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 40px 20px; color: var(--gray-400);">
                            <i class="ti ti-book-off" style="font-size: 36px; display: block; margin-bottom: 8px;"></i>
                            Tidak ada peminjaman aktif saat ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
