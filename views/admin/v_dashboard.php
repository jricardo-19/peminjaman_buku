        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="ti ti-books fs-1 text-primary"></i>
                        <h6 class="text-uppercase small text-muted mt-2 mb-1">Total Buku</h6>
                        <h3 class="fw-bold mb-0"><?= $stats['total_buku']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="ti ti-users fs-1 text-success"></i>
                        <h6 class="text-uppercase small text-muted mt-2 mb-1">Total Anggota</h6>
                        <h3 class="fw-bold mb-0"><?= $stats['total_anggota']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="ti ti-arrows-exchange fs-1 text-info"></i>
                        <h6 class="text-uppercase small text-muted mt-2 mb-1">Sedang Dipinjam</h6>
                        <h3 class="fw-bold mb-0"><?= $stats['dipinjam']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="ti ti-alert-triangle fs-1 text-danger"></i>
                        <h6 class="text-uppercase small text-muted mt-2 mb-1">Telat Kembali</h6>
                        <h3 class="fw-bold mb-0"><?= $stats['telat']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-2">Selamat datang, <?= htmlspecialchars($_SESSION['nama_lengkap']); ?> 👋</h5>
                <p class="text-muted mb-0">Gunakan menu di samping untuk mengelola buku, anggota, dan transaksi peminjaman.</p>
            </div>
        </div>
