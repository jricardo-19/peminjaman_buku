<!-- Kelola Buku Content -->
<div class="content-area">
    <div class="page-header-simple">
        <div>
            <h2>Kelola Buku</h2>
            <p>Kelola semua data buku perpustakaan.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBukuModal">
            <i class="ti ti-plus"></i> Tambah Buku
        </button>
    </div>

    <!-- Book Table -->
    <div class="table-card">
        <div class="table-header">
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" placeholder="Cari buku..." id="searchBuku">
            </div>
            <div class="table-filters">
                <select class="form-select" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($data['kategori'] as $kat): ?>
                        <option value="<?= $kat['nama_kategori'] ?>"><?= $kat['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data['buku'] as $buku): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><img src="assets/images/covers/<?= $buku['cover'] ?>" class="table-cover" alt=""></td>
                        <td><?= $buku['judul'] ?></td>
                        <td><?= $buku['penulis'] ?></td>
                        <td><span class="badge-category"><?= $buku['nama_kategori'] ?></span></td>
                        <td><span class="badge-stock <?= $buku['stok'] > 0 ? 'in-stock' : 'out-stock' ?>"><?= $buku['stok'] ?></span></td>
                        <td>
                            <div class="action-buttons">
                                <a href="index.php?page=kelola_buku&action=edit&id=<?= $buku['id'] ?>" class="btn-action edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="index.php?page=kelola_buku&action=hapus&id=<?= $buku['id'] ?>" class="btn-action delete" onclick="return confirm('Yakin hapus buku ini?')">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="tambahBukuModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=kelola_buku&action=tambah" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="kategori_id" required>
                                <?php foreach ($data['kategori'] as $kat): ?>
                                    <option value="<?= $kat['id'] ?>"><?= $kat['nama_kategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" name="tahun_terbit">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control" name="isbn">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" value="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Cover Buku</label>
                            <input type="file" class="form-control" name="cover" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
