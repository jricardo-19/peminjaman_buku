<div class="ep-page-heading"><div><span class="ep-eyebrow">DASHBOARD SISWA</span><h2>Selamat datang, <?= htmlspecialchars($_SESSION['nama_lengkap']); ?> 👋</h2><p>Kelas <?= htmlspecialchars($_SESSION['kelas']); ?> &mdash; kelola peminjaman dan pengembalian buku dari sini.</p></div></div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="ti ti-books fs-1 text-primary"></i>
                <h6 class="text-uppercase small text-muted mt-2 mb-1">Sedang Dipinjam</h6>
                <h3 class="fw-bold mb-0"><?= $stats['sedang_dipinjam']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="ti ti-history fs-1 text-success"></i>
                <h6 class="text-uppercase small text-muted mt-2 mb-1">Total Riwayat Peminjaman</h6>
                <h3 class="fw-bold mb-0"><?= $stats['total_riwayat']; ?></h3>
            </div>
        </div>
    </div>
</div>
