<?php
// Detect siswa pages by the current URL page parameter
$siswa_pages = ['siswa_dashboard', 'katalog', 'detail_buku', 'peminjaman', 'history_peminjaman', 'pengembalian', 'profil'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_siswa_page = in_array($current_page, $siswa_pages) || ($current_page === 'search' && isset($_SESSION['role']) && $_SESSION['role'] === 'siswa');
?>
<!-- Main Content -->
<div class="main-content <?= $is_siswa_page ? 'no-sidebar' : '' ?>">
    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left" style="display: flex; align-items: center; gap: 20px; flex: 1;">
            <div class="topbar-brand">
                <img src="assets/images/logo-icon.svg" alt="E-Perpus" style="height: 28px;">
                <h5>E-Perpus</h5>
            </div>
            
            <?php if ($is_siswa_page): ?>
            <div class="topbar-nav" style="display: flex; gap: 20px; font-weight: 500;">
                <a href="index.php?page=siswa_dashboard" style="color: <?= ($current_page == 'siswa_dashboard') ? 'var(--primary-500)' : 'var(--gray-600)' ?>; text-decoration: none;">Beranda</a>
                <a href="index.php?page=katalog" style="color: <?= ($current_page == 'katalog') ? 'var(--primary-500)' : 'var(--gray-600)' ?>; text-decoration: none;">Katalog Buku</a>
                <a href="index.php?page=peminjaman" style="color: <?= ($current_page == 'peminjaman') ? 'var(--primary-500)' : 'var(--gray-600)' ?>; text-decoration: none;">Peminjaman</a>
                <a href="index.php?page=history_peminjaman" style="color: <?= in_array($current_page, ['history_peminjaman', 'pengembalian']) ? 'var(--primary-500)' : 'var(--gray-600)' ?>; text-decoration: none;">History Peminjaman</a>
            </div>
            <!-- Search Bar Siswa -->
            <form action="index.php" method="GET" class="topbar-search-form" style="position: relative; flex: 1; max-width: 260px; margin-left: auto;">
                <input type="hidden" name="page" value="search">
                <div class="topbar-search" style="position: relative; width: 100%;">
                    <i class="ti ti-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 16px;"></i>
                    <input type="text" name="q" class="live-search-input" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Cari buku atau pinjaman..." autocomplete="off" style="width: 100%; padding-left: 38px;">
                    <div class="live-search-results" style="display: none;"></div>
                </div>
            </form>
            <?php else: ?>
            <!-- Search Bar Admin -->
            <form action="index.php" method="GET" class="topbar-search-form" style="position: relative; flex: 1; max-width: 440px;">
                <input type="hidden" name="page" value="search">
                <div class="topbar-search" style="position: relative; width: 100%;">
                    <i class="ti ti-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 18px;"></i>
                    <input type="text" name="q" class="live-search-input" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Cari buku, anggota, atau transaksi..." autocomplete="off" style="width: 100%; padding-left: 42px;">
                    <div class="live-search-results" style="display: none;"></div>
                </div>
            </form>
            <?php endif; ?>
        </div>

        <div class="topbar-right" style="display: flex; align-items: center; gap: 16px;">
            <!-- User Dropdown (Profil & Logout) -->
            <div class="topbar-user-dropdown" style="position: relative;">
                <div class="topbar-user" id="topbarUserMenu" onclick="toggleUserDropdown(event)" style="cursor: pointer; user-select: none;">
                    <img src="assets/images/profiles/<?= $_SESSION['foto'] ?? 'default.svg' ?>" alt="User" onerror="this.src='assets/images/profiles/default.svg'">
                    <div class="topbar-user-info">
                        <span class="name"><?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?></span>
                        <span class="role"><?= $is_siswa_page ? 'Siswa' : 'Administrator' ?></span>
                    </div>
                    <i class="ti ti-chevron-down" id="userMenuChevron" style="transition: transform 0.2s ease;"></i>
                </div>
                <div id="userDropdownMenu" class="user-dropdown-menu">
                    <div style="padding: 10px 14px; border-bottom: 1px solid var(--gray-100); margin-bottom: 6px;">
                        <div style="font-weight: 600; font-size: 14px; color: var(--gray-900);"><?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?></div>
                        <div style="font-size: 12px; color: var(--gray-500);"><?= $is_siswa_page ? 'Siswa Perpustakaan' : 'Administrator Perpustakaan' ?></div>
                    </div>
                    <a href="<?= $is_siswa_page ? 'index.php?page=profil' : 'index.php?page=profil_admin' ?>" class="dropdown-item-custom">
                        <i class="ti ti-user" style="font-size: 17px; color: var(--primary-500);"></i>
                        <span>Profil Saya</span>
                    </a>
                    <div style="height: 1px; background: var(--gray-100); margin: 6px 0;"></div>
                    <a href="index.php?page=logout" class="dropdown-item-custom text-danger">
                        <i class="ti ti-logout" style="font-size: 17px;"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

<style>
/* User Dropdown */
.topbar-user-dropdown {
    position: relative;
}
.user-dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    width: 230px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    border: 1px solid var(--gray-200);
    padding: 8px;
    z-index: 9999;
}
.dropdown-item-custom {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    color: var(--gray-700);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.15s ease;
}
.dropdown-item-custom:hover {
    background: var(--gray-100);
    color: var(--primary-500);
}
.dropdown-item-custom.text-danger {
    color: #DC2626;
}
.dropdown-item-custom.text-danger:hover {
    background: #FEE2E2;
    color: #B91C1C;
}

/* Live Search Results Dropdown */
.live-search-results {
    position: absolute;
    left: 0;
    top: calc(100% + 6px);
    width: 100%;
    min-width: 340px;
    max-height: 420px;
    overflow-y: auto;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    border: 1px solid var(--gray-200);
    padding: 8px 0;
    z-index: 9998;
}
.search-group-title {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
    color: var(--gray-400);
    padding: 8px 16px 4px;
}
.search-result-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 16px;
    text-decoration: none;
    color: var(--gray-800);
    transition: background 0.15s ease;
}
.search-result-item:hover {
    background: var(--gray-100);
    color: var(--primary-500);
}
.search-view-all {
    display: block;
    padding: 10px 16px;
    text-align: center;
    font-size: 12px;
    font-weight: 600;
    color: var(--primary-500);
    border-top: 1px solid var(--gray-100);
    text-decoration: none;
    margin-top: 4px;
}
.search-view-all:hover {
    background: var(--primary-100);
}
</style>

<script>
// Toggle Dropdown Profil & Logout
function toggleUserDropdown(e) {
    e.stopPropagation();
    const menu = document.getElementById('userDropdownMenu');
    const chevron = document.getElementById('userMenuChevron');
    if (!menu) return;
    
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        if (chevron) chevron.style.transform = 'rotate(180deg)';
    } else {
        menu.style.display = 'none';
        if (chevron) chevron.style.transform = 'rotate(0deg)';
    }
}

// Close Dropdown and Live Search when clicking outside
document.addEventListener('click', function(e) {
    const userDropdown = document.querySelector('.topbar-user-dropdown');
    const userMenu = document.getElementById('userDropdownMenu');
    const chevron = document.getElementById('userMenuChevron');
    if (userDropdown && !userDropdown.contains(e.target)) {
        if (userMenu) userMenu.style.display = 'none';
        if (chevron) chevron.style.transform = 'rotate(0deg)';
    }

    // Close live search
    document.querySelectorAll('.topbar-search-form').forEach(form => {
        if (!form.contains(e.target)) {
            const results = form.querySelector('.live-search-results');
            if (results) results.style.display = 'none';
        }
    });
});

// Live Search Autocomplete Functionality
document.addEventListener('DOMContentLoaded', function() {
    let searchDebounceTimer = null;

    document.querySelectorAll('.live-search-input').forEach(input => {
        const form = input.closest('.topbar-search-form');
        const resultsBox = form ? form.querySelector('.live-search-results') : null;
        if (!resultsBox) return;

        input.addEventListener('input', function() {
            clearTimeout(searchDebounceTimer);
            const query = this.value.trim();

            if (query.length === 0) {
                resultsBox.style.display = 'none';
                resultsBox.innerHTML = '';
                return;
            }

            searchDebounceTimer = setTimeout(() => {
                fetch('index.php?page=api_search&q=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        let hasResults = false;

                        // 1. Buku
                        if (data.buku && data.buku.length > 0) {
                            hasResults = true;
                            html += '<div class="search-group-title"><i class="ti ti-books"></i> Buku</div>';
                            data.buku.slice(0, 4).forEach(b => {
                                const url = <?= $is_siswa_page ? '`index.php?page=detail_buku&id=${b.id_buku}`' : '`index.php?page=kelola_buku`' ?>;
                                html += `
                                    <a href="${url}" class="search-result-item">
                                        <img src="assets/images/covers/${b.cover}" style="width: 28px; height: 38px; border-radius: 4px; object-fit: cover;" onerror="this.src='assets/images/covers/default.svg'">
                                        <div style="flex: 1; overflow: hidden;">
                                            <div style="font-weight: 600; font-size: 13px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">${b.judul_buku}</div>
                                            <div style="font-size: 11px; color: var(--gray-400);">${b.pengarang || 'Penulis'}</div>
                                        </div>
                                    </a>
                                `;
                            });
                        }

                        // 2. Anggota (Admin)
                        if (data.anggota && data.anggota.length > 0) {
                            hasResults = true;
                            html += '<div class="search-group-title"><i class="ti ti-users"></i> Anggota / Siswa</div>';
                            data.anggota.slice(0, 3).forEach(a => {
                                html += `
                                    <a href="index.php?page=kelola_anggota" class="search-result-item">
                                        <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10B981; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 12px;">
                                            ${a.nama_lengkap.charAt(0).toUpperCase()}
                                        </div>
                                        <div style="flex: 1; overflow: hidden;">
                                            <div style="font-weight: 600; font-size: 13px;">${a.nama_lengkap}</div>
                                            <div style="font-size: 11px; color: var(--gray-400);">NIS: ${a.nis} | ${a.kelas}</div>
                                        </div>
                                    </a>
                                `;
                            });
                        }

                        // 3. Peminjaman Aktif (Siswa)
                        if (data.peminjaman && data.peminjaman.length > 0) {
                            hasResults = true;
                            html += '<div class="search-group-title"><i class="ti ti-book"></i> Peminjaman Saya</div>';
                            data.peminjaman.slice(0, 3).forEach(p => {
                                html += `
                                    <a href="index.php?page=peminjaman" class="search-result-item">
                                        <i class="ti ti-clock" style="color: #F59E0B; font-size: 18px;"></i>
                                        <div style="flex: 1; overflow: hidden;">
                                            <div style="font-weight: 600; font-size: 13px;">${p.judul_buku}</div>
                                            <div style="font-size: 11px; color: var(--gray-400);">Kembali: ${p.tgl_kembali}</div>
                                        </div>
                                    </a>
                                `;
                            });
                        }

                        // 4. Riwayat (Siswa)
                        if (data.riwayat && data.riwayat.length > 0) {
                            hasResults = true;
                            html += '<div class="search-group-title"><i class="ti ti-rotate-clockwise"></i> Riwayat Pengembalian</div>';
                            data.riwayat.slice(0, 3).forEach(r => {
                                html += `
                                    <a href="index.php?page=profil" class="search-result-item">
                                        <i class="ti ti-circle-check" style="color: #10B981; font-size: 18px;"></i>
                                        <div style="flex: 1; overflow: hidden;">
                                            <div style="font-weight: 600; font-size: 13px;">${r.judul_buku}</div>
                                            <div style="font-size: 11px; color: var(--gray-400);">Selesai Dikembalikan</div>
                                        </div>
                                    </a>
                                `;
                            });
                        }

                        // 5. Transaksi (Admin)
                        if (data.transaksi && data.transaksi.length > 0) {
                            hasResults = true;
                            html += '<div class="search-group-title"><i class="ti ti-arrows-exchange"></i> Transaksi Peminjaman</div>';
                            data.transaksi.slice(0, 3).forEach(t => {
                                html += `
                                    <a href="index.php?page=transaksi" class="search-result-item">
                                        <i class="ti ti-exchange" style="color: #8B5CF6; font-size: 18px;"></i>
                                        <div style="flex: 1; overflow: hidden;">
                                            <div style="font-weight: 600; font-size: 13px;">${t.nama_lengkap} &bull; ${t.judul_buku}</div>
                                            <div style="font-size: 11px; color: var(--gray-400);">Jatuh Tempo: ${t.tgl_kembali}</div>
                                        </div>
                                    </a>
                                `;
                            });
                        }

                        if (!hasResults) {
                            html = '<div style="padding: 16px; text-align: center; color: var(--gray-400); font-size: 13px;">Tidak ada hasil ditemukan</div>';
                        } else {
                            html += `<a href="index.php?page=search&q=${encodeURIComponent(query)}" class="search-view-all">Lihat Semua Hasil Pencarian &rarr;</a>`;
                        }

                        resultsBox.innerHTML = html;
                        resultsBox.style.display = 'block';
                    })
                    .catch(err => {
                        console.error(err);
                        resultsBox.style.display = 'none';
                    });
            }, 250);
        });

        input.addEventListener('focus', function() {
            if (this.value.trim().length > 0 && resultsBox.innerHTML.trim().length > 0) {
                resultsBox.style.display = 'block';
            }
        });
    });
});
</script>
