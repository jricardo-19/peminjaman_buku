# E-Perpus — UI Visual Update

Project ini adalah versi UI yang sudah diselaraskan dengan desain visual Sistem Peminjaman Buku:

- Font utama: **Inter** (local asset)
- Primary: **#2563EB**
- Sidebar: **#082B52 / #0D3766**
- Background: **#F5F8FC**
- Card: putih dengan border halus dan shadow ringan
- Icon: **Tabler Icons**
- Layout: sidebar dark, content cards, rounded controls, responsive desktop/tablet/mobile
- Katalog siswa: grid kartu buku dengan cover
- Login/register: split layout navy + white form

## Menjalankan

1. Extract folder project ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Buat database MySQL bernama `db_peminjaman_buku`.
3. Import `config/db_peminjaman_buku.sql`.
4. Jika nama folder berbeda, sesuaikan `BASE_URL` di `index.php`.
5. Pastikan Apache dan MySQL aktif.
6. Buka `index.php?page=landing`.

## Catatan

Fungsi controller/model/database asli dipertahankan. Perubahan utama berada pada layer tampilan, template, CSS, dan view katalog/dashboard/login/register.

### File UI utama

- `assets/css/app-polish.css`
- `assets/css/auth-polish.css`
- `views/template/header.php`
- `views/template/sidebar.php`
- `views/siswa/v_dashboard.php`
- `views/siswa/v_peminjaman.php`
- `views/auth/v_login.php`
- `views/auth/v_register.php`

PHP sudah dicek dengan `php -l` pada seluruh file PHP project tanpa syntax error.
