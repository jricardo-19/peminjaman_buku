<!-- Kelola Anggota Content -->
<div class="content-area">
    <div class="page-header-simple">
        <div>
            <h2>Kelola Anggota</h2>
            <p>Kelola data anggota perpustakaan.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAnggotaModal">
            <i class="ti ti-plus"></i> Tambah Anggota
        </button>
    </div>

    <!-- Member Table -->
    <div class="table-card">
        <div class="table-header">
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" placeholder="Cari anggota..." id="searchAnggota">
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Lengkap</th>
                    <th>NIS</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data['anggota'] as $anggota): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><img src="assets/images/profiles/<?= $anggota['foto_profil'] ?>" class="table-avatar" alt=""></td>
                        <td><?= $anggota['nama_lengkap'] ?></td>
                        <td><?= $anggota['nis'] ?></td>
                        <td><?= $anggota['email'] ?></td>
                        <td><?= $anggota['no_telepon'] ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="index.php?page=kelola_anggota&action=edit&id=<?= $anggota['id'] ?>" class="btn-action edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="index.php?page=kelola_anggota&action=hapus&id=<?= $anggota['id'] ?>" class="btn-action delete" onclick="return confirm('Yakin hapus anggota ini?')">
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

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="tambahAnggotaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Anggota Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=kelola_anggota&action=tambah" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control" name="nis" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="no_telepon">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="2"></textarea>
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
