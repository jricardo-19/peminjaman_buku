<!-- Profil Content -->
<div class="siswa-content">
    <div class="page-header-simple">
        <div>
            <h2>Profil Saya</h2>
            <p>Kelola informasi akun Anda.</p>
        </div>
    </div>

    <div class="profil-layout">
        <!-- Profile Card -->
        <div class="profil-card">
            <img src="assets/images/profiles/<?= $data['user']['foto_profil'] ?>" alt="Profile" class="profil-avatar">
            <h4><?= $data['user']['nama_lengkap'] ?></h4>
            <span class="profil-role">Siswa</span>

            <div class="profil-details">
                <div class="profil-detail-item">
                    <span class="label">NIS</span>
                    <span class="value"><?= $data['user']['nis'] ?></span>
                </div>
                <div class="profil-detail-item">
                    <span class="label">Email</span>
                    <span class="value"><?= $data['user']['email'] ?></span>
                </div>
                <div class="profil-detail-item">
                    <span class="label">No. Telepon</span>
                    <span class="value"><?= $data['user']['no_telepon'] ?? '-' ?></span>
                </div>
                <div class="profil-detail-item">
                    <span class="label">Alamat</span>
                    <span class="value"><?= $data['user']['alamat'] ?? '-' ?></span>
                </div>
            </div>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfilModal">
                <i class="ti ti-edit"></i> Ubah Profil
            </button>
        </div>

        <!-- Riwayat Peminjaman -->
        <div class="riwayat-card">
            <div class="riwayat-header">
                <h4>Riwayat Peminjaman</h4>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['riwayat'])): ?>
                        <?php $no = 1;
                        foreach ($data['riwayat'] as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="book-cell">
                                        <img src="assets/images/covers/<?= $r['cover'] ?>" class="table-cover-sm" alt="" onerror="this.src='assets/images/covers/default.svg'">
                                        <span><?= $r['judul_buku'] ?></span>
                                    </div>
                                </td>
                                <td><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></td>
                                <td>
                                    <span class="status-badge <?= $r['status'] ?>">
                                        <?= ucfirst($r['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada riwayat peminjaman.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfilModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=profil&action=update" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $data['user']['nama_lengkap'] ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $data['user']['email'] ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" value="<?= $data['user']['no_telepon'] ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3"><?= $data['user']['alamat'] ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" name="foto_profil" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
