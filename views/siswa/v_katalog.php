<!-- Katalog Buku Content -->
<div class="siswa-content">
    <div class="katalog-layout">
        <!-- Sidebar Kategori -->
        <div class="katalog-sidebar">
            <h4>Kategori</h4>
            <div class="kategori-list">
                <button class="kategori-item active" onclick="filterKategori('semua', this)">
                    <i class="ti ti-apps"></i> Semua
                </button>
                <?php foreach ($data['kategori'] as $kat): ?>
                    <button class="kategori-item" onclick="filterKategori('<?= $kat['nama_kategori'] ?>', this)">
                        <i class="ti ti-<?= $kat['icon'] ?>"></i> <?= $kat['nama_kategori'] ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Main Katalog -->
        <div class="katalog-main">
            <div class="katalog-header">
                <div>
                    <h3>Katalog Buku</h3>
                    <p>Jelajahi koleksi buku terbaik kami.</p>
                </div>
                <div class="katalog-actions">
                    <select class="katalog-sort">
                        <option>Terbaru</option>
                        <option>Judul A-Z</option>
                        <option>Paling Populer</option>
                    </select>
                    <div class="katalog-view-toggle">
                        <button class="active"><i class="ti ti-layout-grid"></i></button>
                        <button><i class="ti ti-list"></i></button>
                    </div>
                </div>
            </div>

            <div class="katalog-books">
                <?php foreach ($data['buku'] as $buku): ?>
                    <div class="book-card" data-kategori="<?= $buku['nama_kategori'] ?>">
                        <a href="index.php?page=detail_buku&id=<?= $buku['id'] ?>" class="book-cover" style="text-decoration: none;">
                            <img src="assets/images/covers/<?= $buku['cover'] ?>" alt="<?= htmlspecialchars($buku['judul']) ?>" onerror="this.src='assets/images/covers/default.svg'">
                        </a>
                        <div class="book-info">
                            <a href="index.php?page=detail_buku&id=<?= $buku['id'] ?>" style="text-decoration: none; color: inherit;">
                                <h5><?= $buku['judul'] ?></h5>
                            </a>
                            <p class="book-author"><?= $buku['penulis'] ?></p>
                            <span class="book-category"><?= $buku['nama_kategori'] ?></span>
                            <?php if ($buku['stok'] > 0): ?>
                                <form action="index.php?page=peminjaman&action=pinjam" method="POST" style="margin-top: 8px;">
                                    <input type="hidden" name="buku_id" value="<?= $buku['id'] ?>"><input type="hidden" name="redirect" value="katalog">
                                    <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;" onclick="return confirm('Pinjam buku ini?')">
                                        <i class="ti ti-book-download"></i> Pinjam
                                    </button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" style="width: 100%; margin-top: 8px;" disabled>
                                    Stok Habis
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function filterKategori(kategori, btn) {
        // Update active button
        document.querySelectorAll('.kategori-item').forEach(function(item) {
            item.classList.remove('active');
        });
        btn.classList.add('active');

        // Filter books
        document.querySelectorAll('.katalog-books .book-card').forEach(function(card) {
            if (kategori === 'semua' || card.dataset.kategori === kategori) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
