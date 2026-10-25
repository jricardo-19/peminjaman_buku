<!-- Global Search Results (Admin) -->
<div class="content-area">
    <div class="page-header-simple" style="margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 700; color: var(--gray-900); margin: 0 0 4px 0;">Hasil Pencarian</h2>
            <p style="color: var(--gray-500); margin: 0; font-size: 14px;">
                Menampilkan hasil pencarian untuk kata kunci: <strong style="color: var(--primary-500);">"<?= htmlspecialchars($data['keyword']) ?>"</strong>
            </p>
        </div>
    </div>

    <?php
    $total_buku = count($data['results']['buku']);
    $total_anggota = count($data['results']['anggota']);
    $total_transaksi = count($data['results']['transaksi']);
    $total_semua = $total_buku + $total_anggota + $total_transaksi;
    ?>

    <!-- Stats Summary Badges -->
    <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-search" style="color: var(--primary-500); margin-right: 4px;"></i> Total Ditemukan: <?= $total_semua ?>
        </span>
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-book" style="color: #3B82F6; margin-right: 4px;"></i> Buku: <?= $total_buku ?>
        </span>
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-users" style="color: #10B981; margin-right: 4px;"></i> Anggota: <?= $total_anggota ?>
        </span>
        <span style="background: var(--white); border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--gray-700);">
            <i class="ti ti-arrows-exchange" style="color: #8B5CF6; margin-right: 4px;"></i> Transaksi: <?= $total_transaksi ?>
        </span>
    </div>

    <?php if ($total_semua === 0): ?>
        <div class="table-card" style="padding: 60px 20px; text-align: center; color: var(--gray-400);">
            <i class="ti ti-file-search" style="font-size: 48px; display: block; margin-bottom: 12px; color: var(--gray-300);"></i>
            <h4 style="font-size: 18px; color: var(--gray-700); margin-bottom: 6px;">Tidak ada data yang cocok</h4>
            <p style="font-size: 14px; margin: 0;">Silakan coba dengan kata kunci lain (judul buku, pengarang, nama siswa, atau kode).</p>
        </div>
    <?php else: ?>

        <!-- 1. DATA BUKU -->
        <?php if ($total_buku > 0): ?>
        <div class="table-card" style="margin-bottom: 28px;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: 8px;">
                    <i class="ti ti-book" style="color: var(--primary-500);"></i> Data Buku (<?= $total_buku ?>)
                </h4>
                <a href="index.php?page=kelola_buku" style="font-size: 13px; color: var(--primary-500); text-decoration: none; font-weight: 600;">Lihat di Kelola Buku &rarr;</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="35%">JUDUL & COVER</th>
                            <th width="25%">PENGARANG</th>
                            <th width="20%">PENERBIT</th>
                            <th width="15%">STOK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['results']['buku'] as $b): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="assets/images/covers/<?= $b['cover'] ?>" class="table-cover-sm" alt="" onerror="this.src='assets/images/covers/default.svg'">
                                    <div>
                                        <div style="font-weight: 600; color: var(--gray-900);"><?= htmlspecialchars($b['judul_buku']) ?></div>
                                        <small style="color: var(--gray-400);">Kode: <?= htmlspecialchars($b['kode_buku']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($b['pengarang']) ?></td>
                            <td><?= htmlspecialchars($b['penerbit']) ?></td>
                            <td>
                                <span class="badge" style="background: var(--primary-100); color: var(--primary-500); font-weight: 600;">
                                    <?= $b['stok'] ?> buku
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- 2. DATA ANGGOTA -->
        <?php if ($total_anggota > 0): ?>
        <div class="table-card" style="margin-bottom: 28px;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: 8px;">
                    <i class="ti ti-users" style="color: #10B981;"></i> Data Anggota / Siswa (<?= $total_anggota ?>)
                </h4>
                <a href="index.php?page=kelola_anggota" style="font-size: 13px; color: var(--primary-500); text-decoration: none; font-weight: 600;">Lihat di Kelola Anggota &rarr;</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="30%">NAMA SISWA</th>
                            <th width="20%">NIS</th>
                            <th width="25%">USERNAME</th>
                            <th width="20%">KELAS / NO. HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['results']['anggota'] as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10B981; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 13px;">
                                        <?= strtoupper(substr($a['nama_lengkap'], 0, 1)) ?>
                                    </div>
                                    <div style="font-weight: 600; color: var(--gray-900);"><?= htmlspecialchars($a['nama_lengkap']) ?></div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($a['nis']) ?></td>
                            <td><?= htmlspecialchars($a['username']) ?></td>
                            <td><?= htmlspecialchars($a['kelas']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- 3. DATA TRANSAKSI -->
        <?php if ($total_transaksi > 0): ?>
        <div class="table-card" style="margin-bottom: 28px;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: 8px;">
                    <i class="ti ti-arrows-exchange" style="color: #8B5CF6;"></i> Data Transaksi Peminjaman (<?= $total_transaksi ?>)
                </h4>
                <a href="index.php?page=transaksi" style="font-size: 13px; color: var(--primary-500); text-decoration: none; font-weight: 600;">Lihat di Transaksi &rarr;</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="25%">NAMA PEMINJAM</th>
                            <th width="30%">BUKU</th>
                            <th width="15%">TGL PINJAM</th>
                            <th width="15%">JATUH TEMPO</th>
                            <th width="10%">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['results']['transaksi'] as $t): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="font-weight: 600; color: var(--gray-900);"><?= htmlspecialchars($t['nama_lengkap']) ?></div>
                                <small style="color: var(--gray-400);">NIS: <?= htmlspecialchars($t['nis'] ?? '-') ?></small>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="assets/images/covers/<?= $t['cover'] ?>" class="table-cover-sm" alt="" onerror="this.src='assets/images/covers/default.svg'">
                                    <span style="font-weight: 500; color: var(--gray-800);"><?= htmlspecialchars($t['judul_buku']) ?></span>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($t['tgl_pinjam'])) ?></td>
                            <td><?= date('d M Y', strtotime($t['tgl_kembali'])) ?></td>
                            <td>
                                <span class="status-badge status-warning">Dipinjam</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
