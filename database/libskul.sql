CREATE DATABASE IF NOT EXISTS libskul;
USE libskul;

-- Tabel Admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert admin default (password: admin123)
INSERT INTO admin (username, password)
VALUES ('admin', '$2y$10$W2JvyHTFn9Ul4MPXnQWZsOZfsM0HxdKZypUPq/RUTnx57Q69IMvSG');

-- Tabel Siswa
CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nis VARCHAR(20) NOT NULL UNIQUE,
    kelas VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Dummy siswa
INSERT INTO siswa (nama, nis, kelas, password)
VALUES ('Budi Santoso', '12345', 'XII IPA 1', '$2y$10$abc123abc123abc123abcOjS8E99luhVm9a1vxHR5rZ1eQOVBv6Eu');

-- Tabel Buku
CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(100),
    penerbit VARCHAR(100),
    tahun INT,
    stok INT DEFAULT 0,
    gambar VARCHAR(255)
);

-- Dummy buku
INSERT INTO buku (judul, penulis, penerbit, tahun, stok, gambar)
VALUES 
('Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 5, 'laskar.jpg'),
('Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 3, 'negeri5.jpg');

-- Tabel Peminjaman
CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT,
    buku_id INT,
    tanggal_pinjam DATE,
    tanggal_kembali DATE,
    status ENUM('dipinjam', 'dikembalikan') DEFAULT 'dipinjam',
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (buku_id) REFERENCES buku(id) ON DELETE CASCADE
);

-- Dummy peminjaman
INSERT INTO peminjaman (siswa_id, buku_id, tanggal_pinjam, tanggal_kembali, status)
VALUES (1, 1, '2025-06-01', '2025-06-08', 'dipinjam');