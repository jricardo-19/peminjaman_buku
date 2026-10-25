<!-- Dashboard Content -->
<div class="content-area">
    <div class="page-header" style="background-image: url('assets/images/backgrounds/bg-dashboard-hero.png'); background-size: cover; background-position: center; height: 200px; max-height: 250px">
        <div>
            <h2>Selamat Datang, Admin 👋</h2>
            <p>Kelola perpustakaan dengan lebih mudah dan efisien.</p>
        </div>
        <img src="assets/images/illustrations/illustration-dashboard-student.png" alt="illustration" class="header-illustration">
    </div>

    <!-- Stats Cards (Real Data) -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Total Buku</span>
                <h3 class="stat-number"><?= $data['total_buku'] ?></h3>
                <span class="stat-change" style="color: var(--gray-500);"><i class="ti ti-books"></i> Koleksi perpustakaan</span>
            </div>
            <div class="stat-icon blue">
                <i class="ti ti-books"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Anggota Aktif</span>
                <h3 class="stat-number"><?= $data['total_anggota'] ?></h3>
                <span class="stat-change" style="color: var(--gray-500);"><i class="ti ti-user-check"></i> Siswa terdaftar</span>
            </div>
            <div class="stat-icon green">
                <i class="ti ti-users"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Peminjaman Aktif</span>
                <h3 class="stat-number"><?= $data['peminjaman_aktif'] ?></h3>
                <span class="stat-change positive"><i class="ti ti-clock"></i> Sedang dipinjam</span>
            </div>
            <div class="stat-icon purple">
                <i class="ti ti-clipboard-list"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Terlambat</span>
                <h3 class="stat-number"><?= $data['terlambat'] ?></h3>
                <span class="stat-change negative"><i class="ti ti-alert-triangle"></i> Lewat tempo</span>
            </div>
            <div class="stat-icon red">
                <i class="ti ti-alert-triangle"></i>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="chart-card">
            <div class="chart-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <h4 style="margin: 0;">Statistik Peminjaman</h4>
                    <span id="chartTotalBadge" style="background: rgba(30, 88, 240, 0.1); color: var(--primary-500); padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;"></span>
                </div>
                <div class="chart-tabs">
                    <button type="button" class="tab active" id="btnMinggu" onclick="switchChartTab('minggu')">Minggu Ini</button>
                    <button type="button" class="tab" id="btnBulan" onclick="switchChartTab('bulan')">Bulan Ini</button>
                </div>
            </div>
            <div style="position: relative; height: 260px; width: 100%;">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>
        <div class="popular-books-card">
            <div class="popular-header">
                <h4>Buku Terpopuler</h4>
                <a href="index.php?page=kelola_buku" class="view-all">Lihat Semua <i class="ti ti-arrow-right"></i></a>
            </div>
            <div class="popular-list">
                <?php if (empty($data['buku_terpopuler'])): ?>
                    <div style="text-align: center; padding: 40px 0; color: var(--gray-400);">
                        <i class="ti ti-book-off" style="font-size: 36px; display: block; margin-bottom: 8px;"></i>
                        <p style="margin: 0; font-size: 14px;">Belum ada data peminjaman buku.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($data['buku_terpopuler'] as $buku): ?>
                        <div class="popular-item">
                            <img src="assets/images/covers/<?= $buku['cover'] ?>" alt="<?= htmlspecialchars($buku['judul']) ?>" onerror="this.src='assets/images/covers/default.svg'">
                            <div class="popular-info">
                                <h5><?= htmlspecialchars($buku['judul']) ?></h5>
                                <p><?= htmlspecialchars($buku['penulis']) ?></p>
                            </div>
                            <span class="popular-count"><i class="ti ti-eye"></i> <?= $buku['jumlah_dipinjam'] ?> kali dipinjam</span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Data mingguan: Senin - Minggu
$days_keys = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$weekly_labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
$weekly_data = [];
$total_minggu = 0;
foreach ($days_keys as $day) {
    $val = isset($data['statistik_mingguan'][$day]) ? intval($data['statistik_mingguan'][$day]) : 0;
    $weekly_data[] = $val;
    $total_minggu += $val;
}

// Data bulanan: Hari 1 sampai t
$days_in_month = intval(date('t'));
$bulan_nama = [
    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
];
$current_month_name = $bulan_nama[intval(date('n'))];
$monthly_labels = [];
$monthly_data = [];
$total_bulan = 0;
for ($i = 1; $i <= $days_in_month; $i++) {
    $monthly_labels[] = $i . ' ' . $current_month_name;
    $val = isset($data['statistik_bulanan'][$i]) ? intval($data['statistik_bulanan'][$i]) : 0;
    $monthly_data[] = $val;
    $total_bulan += $val;
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js library is not loaded');
        return;
    }

    const weeklyLabels = <?= json_encode($weekly_labels) ?>;
    const weeklyData = <?= json_encode($weekly_data) ?>;
    const totalMinggu = <?= $total_minggu ?>;

    const monthlyLabels = <?= json_encode($monthly_labels) ?>;
    const monthlyData = <?= json_encode($monthly_data) ?>;
    const totalBulan = <?= $total_bulan ?>;

    const badge = document.getElementById('chartTotalBadge');
    if (badge) {
        badge.textContent = totalMinggu + ' Peminjaman';
    }

    const canvas = document.getElementById('peminjamanChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0, '#1E58F0');
    gradient.addColorStop(1, '#8FAFCC');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: weeklyData,
                backgroundColor: gradient,
                hoverBackgroundColor: '#054386',
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 32,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 500
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#054386',
                    titleFont: { family: 'Inter', size: 13, weight: '600' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' transaksi peminjaman';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1,
                        color: '#9CA3AF',
                        font: { family: 'Inter', size: 12 }
                    },
                    grid: {
                        color: '#F3F4F6',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#6B7280',
                        font: { family: 'Inter', size: 12, weight: '500' }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    window.switchChartTab = function(type) {
        document.querySelectorAll('.chart-tabs .tab').forEach(t => t.classList.remove('active'));
        if (type === 'minggu') {
            document.getElementById('btnMinggu').classList.add('active');
            if (badge) badge.textContent = totalMinggu + ' Peminjaman';
            chart.data.labels = weeklyLabels;
            chart.data.datasets[0].data = weeklyData;
            chart.data.datasets[0].barThickness = 32;
            chart.options.scales.x.ticks.maxTicksLimit = 7;
            chart.update();
        } else {
            document.getElementById('btnBulan').classList.add('active');
            if (badge) badge.textContent = totalBulan + ' Peminjaman';
            chart.data.labels = monthlyLabels;
            chart.data.datasets[0].data = monthlyData;
            chart.data.datasets[0].barThickness = 12;
            chart.options.scales.x.ticks.maxTicksLimit = 16;
            chart.update();
        }
    };
});
</script>
