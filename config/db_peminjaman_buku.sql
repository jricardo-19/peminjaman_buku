CREATE DATABASE IF NOT EXISTS db_peminjaman_buku;
USE db_peminjaman_buku;

-- ==========================================
-- 1. TABEL ADMIN
-- ==========================================
CREATE TABLE tb_admin (
    id_admin INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL
);

-- ==========================================
-- 2. TABEL USER (SISWA/ANGGOTA)
-- ==========================================
CREATE TABLE tb_user (
    id_user INT(11) AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    kelas VARCHAR(50) NOT NULL
);

-- ==========================================
-- 3. TABEL DATA BUKU
-- ==========================================
CREATE TABLE tb_data_buku (
    id_buku INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_admin INT(11) NOT NULL, -- Relasi ke tb_admin
    kode_buku VARCHAR(50) NOT NULL UNIQUE,
    judul_buku VARCHAR(200) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    stok INT(11) NOT NULL,
    FOREIGN KEY (id_admin) REFERENCES tb_admin(id_admin) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ==========================================
-- 4. TABEL TRANSAKSI (PEMINJAMAN AKTIF)
-- ==========================================
CREATE TABLE tb_transaksi (
    id_transaksi INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_admin INT(11) NOT NULL, -- Relasi ke tb_admin
    id_user INT(11) NOT NULL,
    id_buku INT(11) NOT NULL,
    tgl_pinjam DATE NOT NULL,
    tgl_kembali DATE NOT NULL, -- Tenggat waktu pengembalian
    status ENUM('Dipinjam') DEFAULT 'Dipinjam',
    FOREIGN KEY (id_admin) REFERENCES tb_admin(id_admin) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_user) REFERENCES tb_user(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES tb_data_buku(id_buku) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ==========================================
-- 5. TABEL RIWAYAT (TRANSAKSI SELESAI)
-- ==========================================
CREATE TABLE tb_riwayat (
    id_riwayat INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT(11) NOT NULL, 
    id_admin INT(11) NOT NULL, -- Relasi ke tb_admin
    id_user INT(11) NOT NULL,
    id_buku INT(11) NOT NULL,
    tgl_pinjam DATE NOT NULL,
    tgl_dikembalikan DATE NOT NULL, -- Tanggal aktual saat siswa mengembalikan buku
    denda INT(11) DEFAULT 0, -- Menyimpan total denda jika lewat dari 1 hari
    status ENUM('Selesai') DEFAULT 'Selesai',
    FOREIGN KEY (id_admin) REFERENCES tb_admin(id_admin) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_user) REFERENCES tb_user(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES tb_data_buku(id_buku) ON DELETE CASCADE ON UPDATE CASCADE
);


INSERT INTO tb_admin (username, password, nama_lengkap) 
VALUES ('admin', MD5('admin123'), 'Administrator Perpustakaan');