<!-- Content Area -->
<div class="content-area">
    <!-- Page Header -->
    <div class="page-header-simple" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 700; color: var(--gray-900); margin: 0 0 4px 0;">Laporan Perpustakaan</h2>
            <p style="color: var(--gray-500); margin: 0; font-size: 14px;">Rekapitulasi data transaksi peminjaman dan pengembalian buku.</p>
        </div>
        <div>
            <button class="btn btn-primary" onclick="window.print()" style="display: flex; align-items: center; gap: 8px;">
                <i class="ti ti-printer"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filter & Summary Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;" class="laporan-top-row">
        <!-- Filter Card -->
        <div class="table-card" style="padding: 24px; flex: 1;">
            <h5 style="margin-top: 0; margin-bottom: 16px; font-size: 16px; color: var(--gray-800);">Filter Laporan</h5>
            <form method="GET" action="index.php" style="display: flex; gap: 16px; align-items: flex-end;">
                <input type="hidden" name="page" value="laporan">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 13px; font-weight: 500; color: var(--gray-600); margin-bottom: 8px;">Bulan</label>
                    <select name="bulan" class="form-control" style="width: 100%; padding: 10px 14px; border: 1px solid var(--gray-300); border-radius: var(--border-radius-sm); outline: none;">
                        <?php
                        $bulans = [
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ];
                        foreach ($bulans as $val => $nama) {
                            $sel = ($data['bulan_aktif'] == $val) ? 'selected' : '';
                            echo "<option value=\"$val\" $sel>$nama</option>";
                        }
                        ?>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 13px; font-weight: 500; color: var(--gray-600); margin-bottom: 8px;">Tahun</label>
                    <select name="tahun" class="form-control" style="width: 100%; padding: 10px 14px; border: 1px solid var(--gray-300); border-radius: var(--border-radius-sm); outline: none;">
                        <?php
                        $tahun_sekarang = date('Y');
                        for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 3; $i--) {
                            $sel = ($data['tahun_aktif'] == $i) ? 'selected' : '';
                            echo "<option value=\"$i\" $sel>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Terapkan</button>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div style="display: flex; gap: 16px; flex: 1;">
            <div class="stat-card" style="flex: 1; margin: 0;">
                <div class="stat-info">
                    <span class="stat-label">Total Transaksi Selesai</span>
                    <span class="stat-number"><?= count($data['laporan']) ?></span>
                </div>
                <div class="stat-icon" style="background: rgba(30, 88, 240, 0.1); color: var(--primary-500);">
                    <i class="ti ti-clipboard-check"></i>
                </div>
            </div>
            <?php
            // Calculate total denda
            $total_denda = 0;
            foreach ($data['laporan'] as $l) {
                $total_denda += intval($l['denda']);
            }
            ?>
            <div class="stat-card" style="flex: 1; margin: 0;">
                <div class="stat-info">
                    <span class="stat-label">Total Denda Terkumpul</span>
                    <span class="stat-number">Rp <?= number_format($total_denda, 0, ',', '.') ?></span>
                </div>
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                    <i class="ti ti-coin"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-card" id="printableArea">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; font-size: 16px; color: var(--gray-800);">Data Riwayat Transaksi Bulan <?= $bulans[$data['bulan_aktif']] ?> <?= $data['tahun_aktif'] ?></h4>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th width="20%">NAMA PEMINJAM</th>
                        <th width="25%">JUDUL BUKU</th>
                        <th width="15%">TANGGAL PINJAM</th>
                        <th width="15%">TANGGAL KEMBALI</th>
                        <th width="10%">DENDA</th>
                        <th width="10%">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['laporan'])): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: var(--gray-500);">Tidak ada data riwayat pada bulan dan tahun ini.</td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($data['laporan'] as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="font-weight: 500; color: var(--gray-800);"><?= $row['nama_lengkap'] ?></div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 42px; background: var(--gray-100); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                                        <i class="ti ti-book" style="font-size: 16px;"></i>
                                    </div>
                                    <span style="font-weight: 500; color: var(--gray-800);"><?= $row['judul_buku'] ?></span>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal_kembali'])) ?></td>
                            <td>Rp <?= number_format($row['denda'], 0, ',', '.') ?></td>
                            <td>
                                <span class="status-badge status-success">Selesai</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Print Styles */
@media print {
    body * {
        visibility: hidden;
    }
    #printableArea, #printableArea * {
        visibility: visible;
    }
    #printableArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }
    .sidebar, .topbar, .laporan-top-row, .page-header-simple button {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
}
</style>
