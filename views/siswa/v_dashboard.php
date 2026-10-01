<div class="card mb-4">
    <div class="card-body">
        <h4 class="fw-bold mb-2">Selamat datang, <?= htmlspecialchars($_SESSION['nama_lengkap']); ?> 👋</h4>
        <p class="text-muted mb-0">Kelas <?= htmlspecialchars($_SESSION['kelas']); ?> — gunakan menu di atas untuk meminjam atau mengembalikan buku.</p>
    </div>
</div>

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
