<!-- Global Search Results (Siswa) -->
<div class="siswa-content" style="padding: 30px 40px;">
    <div class="page-header-simple" style="margin-bottom: 24px;">
        <div>
            <h2>Hasil Pencarian</h2>
            <p>
                Menampilkan hasil pencarian untuk kata kunci: <strong style="color: var(--primary-500);">"<?= htmlspecialchars($data['keyword']) ?>"</strong>
            </p>
        </div>
    </div>

    <?php
    $total_buku = count($data['results']['buku']);
    $total_peminjaman = count($data['results']['peminjaman']);
    $total_riwayat = count($data['results']['riwayat']);
    $total_semua = $total_buku + $total_peminjaman + $total_riwayat;
    ?>

    <!-- Stats Summary Badges -->
    <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-search" style="color: var(--primary-500); margin-right: 4px;"></i> Total Ditemukan: <?= $total_semua ?>
        </span>
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-books" style="color: #3B82F6; margin-right: 4px;"></i> Buku Perpustakaan: <?= $total_buku ?>
        </span>
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-book" style="color: #F59E0B; margin-right: 4px;"></i> Sedang Dipinjam: <?= $total_peminjaman ?>
        </span>
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-rotate-clockwise" style="color: #10B981; margin-right: 4px;"></i> Riwayat: <?= $total_riwayat ?>
        </span>
    </div>

    <?php if ($total_semua === 0): ?>
        <div class="table-card" style="padding: 60px 20px; text-align: center; color: var(--gray-400);">
            <i class="ti ti-file-search" style="font-size: 48px; display: block; margin-bottom: 12px; color: var(--gray-300);"></i>
            <h4 style="font-size: 18px; color: var(--gray-700); margin-bottom: 6px;">Tidak ada hasil ditemukan</h4>
            <p style="font-size: 14px; margin: 0;">Coba gunakan kata kunci judul buku, pengarang, atau penerbit yang lain.</p>
        </div>
    <?php else: ?>

        <!-- 1. BUKU DI KATALOG PERPUSTAKAAN -->
        <?php if ($total_buku > 0): ?>
        <div style="margin-bottom: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--gray-900); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="ti ti-books" style="color: var(--primary-500);"></i> Buku Perpustakaan (<?= $total_buku ?>)
                </h3>
                <a href="index.php?page=katalog" style="color: var(--primary-500); text-decoration: none; font-size: 13px; font-weight: 600;">Lihat Katalog Lengkap &rarr;</a>
            </div>

            <div class="books-grid">
                <?php foreach ($data['results']['buku'] as $b): ?>
                    <div class="book-card">
                        <a href="index.php?page=detail_buku&id=<?= $b['id_buku'] ?>" class="book-cover" style="text-decoration: none;">
                            <img src="assets/images/covers/<?= $b['cover'] ?>" alt="<?= htmlspecialchars($b['judul_buku']) ?>" onerror="this.src='assets/images/covers/default.svg'">
                        </a>
                        <div class="book-info">
                            <a href="index.php?page=detail_buku&id=<?= $b['id_buku'] ?>" style="text-decoration: none; color: inherit;">
                                <h5><?= htmlspecialchars($b['judul_buku']) ?></h5>
                            </a>
                            <p class="book-author"><?= htmlspecialchars($b['pengarang']) ?></p>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                                <span class="book-category" style="margin: 0;">Stok: <?= $b['stok'] ?></span>
                                <a href="index.php?page=detail_buku&id=<?= $b['id_buku'] ?>" class="btn btn-primary btn-sm" style="padding: 4px 12px; font-size: 12px;">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- 2. PEMINJAMAN SAYA AKTIF -->
        <?php if ($total_peminjaman > 0): ?>
        <div class="table-card" style="margin-bottom: 32px;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: 8px;">
                    <i class="ti ti-book" style="color: #F59E0B;"></i> Buku Yang Sedang Saya Pinjam (<?= $total_peminjaman ?>)
                </h4>
                <a href="index.php?page=peminjaman" style="font-size: 13px; color: var(--primary-500); text-decoration: none; font-weight: 600;">Lihat Peminjaman &rarr;</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="45%">JUDUL BUKU</th>
                            <th width="25%">TANGGAL PINJAM</th>
                            <th width="25%">JATUH TEMPO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['results']['peminjaman'] as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="assets/images/covers/<?= $p['cover'] ?>" class="table-cover-sm" alt="" onerror="this.src='assets/images/covers/default.svg'">
                                    <span style="font-weight: 600; color: var(--gray-900);"><?= htmlspecialchars($p['judul_buku']) ?></span>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($p['tgl_pinjam'])) ?></td>
                            <td><?= date('d M Y', strtotime($p['tgl_kembali'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- 3. RIWAYAT SAYA -->
        <?php if ($total_riwayat > 0): ?>
        <div class="table-card">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: 8px;">
                    <i class="ti ti-rotate-clockwise" style="color: #10B981;"></i> Riwayat Buku Selesai Dikembalikan (<?= $total_riwayat ?>)
                </h4>
                <a href="index.php?page=profil" style="font-size: 13px; color: var(--primary-500); text-decoration: none; font-weight: 600;">Lihat Riwayat &rarr;</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="45%">JUDUL BUKU</th>
                            <th width="25%">TANGGAL PINJAM</th>
                            <th width="25%">TANGGAL DIKEMBALIKAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['results']['riwayat'] as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="assets/images/covers/<?= $r['cover'] ?>" class="table-cover-sm" alt="" onerror="this.src='assets/images/covers/default.svg'">
                                    <span style="font-weight: 600; color: var(--gray-900);"><?= htmlspecialchars($r['judul_buku']) ?></span>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($r['tgl_pinjam'])) ?></td>
                            <td><?= date('d M Y', strtotime($r['tgl_dikembalikan'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
