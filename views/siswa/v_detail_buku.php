<!-- Detail Buku -->
<div class="siswa-content" style="padding: 30px 40px;">
    
    <!-- Back Button -->
    <a href="index.php?page=katalog" class="detail-back-btn">
        <i class="ti ti-arrow-left"></i> Kembali ke Katalog
    </a>

    <!-- Detail Content -->
    <div class="detail-buku-container">
        <!-- Left: Book Cover -->
        <div class="detail-buku-cover">
            <img src="assets/images/covers/<?= $data['buku']['cover'] ?>" alt="<?= htmlspecialchars($data['buku']['judul']) ?>" onerror="this.src='assets/images/covers/default.svg'">
        </div>

        <!-- Right: Book Info -->
        <div class="detail-buku-info">
            
            <!-- Alert Notifikasi Sukses / Gagal (Server-side fallback) -->
            <div id="alertContainer">
                <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                        <i class="ti ti-circle-check" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
                        <strong>Berhasil!</strong> Buku telah otomatis dipinjam. Tenggat pengembalian: <strong><?= date('d M Y', strtotime('+7 days')) ?></strong>. Silakan ambil buku di perpustakaan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                        <i class="ti ti-alert-circle" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
                        <strong>Gagal!</strong> Tidak dapat meminjam buku (stok habis atau terjadi kesalahan).
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>

            <h1 class="detail-buku-title"><?= htmlspecialchars($data['buku']['judul']) ?></h1>
            <p class="detail-buku-author"><?= htmlspecialchars($data['buku']['penulis']) ?></p>
            <span class="detail-buku-category"><?= htmlspecialchars($data['buku']['nama_kategori']) ?></span>

            <!-- Rating -->
            <div class="detail-buku-rating">
                <div class="stars">
                    <i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-half-filled"></i>
                </div>
                <span class="rating-value"><?= $data['buku']['rating'] ?></span>
                <span class="rating-count">(<?= $data['buku']['ulasan'] ?> ulasan)</span>
            </div>

            <!-- Book Details Grid -->
            <div class="detail-buku-meta">
                <div class="meta-item">
                    <span class="meta-label">Stok Tersedia</span>
                    <span class="meta-value" id="stokVal"><?= $data['buku']['stok'] ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Jumlah Dipinjam</span>
                    <span class="meta-value" id="dipinjamVal"><?= $data['buku']['jumlah_dipinjam'] ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Tahun Terbit</span>
                    <span class="meta-value"><?= htmlspecialchars($data['buku']['tahun_terbit']) ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Penerbit</span>
                    <span class="meta-value"><?= htmlspecialchars($data['buku']['penerbit']) ?></span>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="detail-buku-deskripsi">
                <h3>Deskripsi</h3>
                <p><?= htmlspecialchars($data['buku']['deskripsi']) ?></p>
            </div>

            <!-- Pinjam Button (Otomatis Meminjam Langsung di Halaman Ini) -->
            <form id="formPinjamBuku" action="index.php?page=detail_buku&action=pinjam&id=<?= $data['buku']['id'] ?>" method="POST">
                <input type="hidden" name="action" value="pinjam">
                <input type="hidden" name="id_buku" value="<?= $data['buku']['id'] ?>">
                <input type="hidden" name="ajax" value="1">
                <?php if ($data['buku']['stok'] > 0): ?>
                    <button type="submit" id="btnPinjamBuku" class="detail-pinjam-btn">
                        <i class="ti ti-book"></i> Pinjam Buku
                    </button>
                <?php else: ?>
                    <button type="button" class="detail-pinjam-btn" style="background: var(--gray-400); cursor: not-allowed;" disabled>
                        <i class="ti ti-ban"></i> Stok Buku Habis
                    </button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPinjamBuku');
    const btn = document.getElementById('btnPinjamBuku');
    const alertContainer = document.getElementById('alertContainer');
    const stokVal = document.getElementById('stokVal');
    const dipinjamVal = document.getElementById('dipinjamVal');

    if (!form || !btn) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!confirm('Apakah kamu yakin ingin meminjam buku ini sekarang?')) {
            return;
        }

        const originalBtnHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="ti ti-loader" style="animation: spin 1s infinite linear;"></i> Memproses Peminjaman...';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'sukses') {
                // Update stock and borrowed count in UI immediately
                if (stokVal) stokVal.textContent = res.stok;
                if (dipinjamVal) {
                    const currentDipinjam = parseInt(dipinjamVal.textContent) || 0;
                    dipinjamVal.textContent = currentDipinjam + 1;
                }

                // Show success message
                alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                        <i class="ti ti-circle-check" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
                        <strong>Berhasil!</strong> ${res.message} Tenggat pengembalian: <strong>${res.tgl_kembali}</strong>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Button state
                btn.style.background = '#10B981';
                btn.innerHTML = '<i class="ti ti-check"></i> Buku Berhasil Dipinjam!';

                setTimeout(() => {
                    if (res.stok > 0) {
                        btn.disabled = false;
                        btn.style.background = '';
                        btn.innerHTML = '<i class="ti ti-book"></i> Pinjam Buku Lagi';
                    } else {
                        btn.disabled = true;
                        btn.style.background = 'var(--gray-400)';
                        btn.style.cursor = 'not-allowed';
                        btn.innerHTML = '<i class="ti ti-ban"></i> Stok Buku Habis';
                    }
                }, 2000);
            } else {
                alertContainer.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                        <i class="ti ti-alert-circle" style="font-size: 18px; vertical-align: middle; margin-right: 6px;"></i>
                        <strong>Gagal!</strong> ${res.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
            }
        })
        .catch(err => {
            console.error(err);
            // Fallback: standard form submit if fetch fails
            form.submit();
        });
    });
});
</script>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
