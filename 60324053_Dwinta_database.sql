-- =========================================
-- DATABASE PERPUSTAKAAN LENGKAP
-- =========================================

-- 1. CREATE DATABASE
CREATE DATABASE perpustakaan_lengkap;
USE perpustakaan_lengkap;


-- =========================================
-- 2. TABEL KATEGORI
-- =========================================
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- 3. TABEL PENERBIT
-- =========================================
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- 4. TABEL BUKU (RELASI)
-- =========================================
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100),
    pengarang VARCHAR(100),
    tahun_terbit INT,
    harga DECIMAL(10,2),
    stok INT,
    id_kategori INT,
    id_penerbit INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
);


-- =========================================
-- 5. INSERT DATA KATEGORI
-- =========================================
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Programming', 'Buku pemrograman'),
('Database', 'Buku database'),
('Jaringan', 'Buku jaringan komputer'),
('Web Design', 'Desain web'),
('AI', 'Artificial Intelligence');


-- =========================================
-- 6. INSERT DATA PENERBIT
-- =========================================
INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Informatika', 'Bandung', '0811111111', 'info@informatika.com'),
('Erlangga', 'Jakarta', '0822222222', 'info@erlangga.com'),
('Graha Ilmu', 'Yogyakarta', '0833333333', 'info@graha.com'),
('Andi Offset', 'Yogyakarta', '0844444444', 'info@andi.com'),
('Gramedia', 'Jakarta', '0855555555', 'info@gramedia.com');


-- =========================================
-- 7. INSERT DATA BUKU (15 DATA)
-- =========================================
INSERT INTO buku (judul, pengarang, tahun_terbit, harga, stok, id_kategori, id_penerbit) VALUES
('Belajar PHP', 'Budi Raharjo', 2023, 90000, 10, 1, 1),
('Mastering MySQL', 'Andi Nugroho', 2022, 100000, 8, 2, 3),
('Jaringan Komputer', 'Rina Wijaya', 2023, 120000, 5, 3, 2),
('Web Design Modern', 'Dedi Santoso', 2024, 95000, 7, 4, 4),
('AI Dasar', 'Siti Aminah', 2024, 150000, 6, 5, 5),
('Laravel Advanced', 'Ahmad Yani', 2024, 130000, 9, 1, 1),
('Python AI', 'Siti Aminah', 2023, 140000, 4, 5, 5),
('CSS Mastery', 'Dedi Santoso', 2022, 85000, 12, 4, 4),
('SQL Advanced', 'Andi Nugroho', 2023, 110000, 6, 2, 3),
('Networking Pro', 'Rina Wijaya', 2024, 125000, 3, 3, 2),
('JavaScript Modern', 'Budi Raharjo', 2023, 95000, 10, 1, 1),
('Data Mining', 'Siti Aminah', 2022, 135000, 5, 5, 5),
('HTML & CSS', 'Dedi Santoso', 2021, 80000, 11, 4, 4),
('Database Design', 'Andi Nugroho', 2024, 120000, 7, 2, 3),
('Cyber Security', 'Rina Wijaya', 2023, 130000, 4, 3, 2);


-- =========================================
-- 8. QUERY JOIN
-- =========================================

-- 1. Tampilkan buku + kategori + penerbit
SELECT b.judul, b.pengarang, k.nama_kategori, p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;


-- 2. Jumlah buku per kategori
SELECT k.nama_kategori, COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
GROUP BY k.nama_kategori;


-- 3. Jumlah buku per penerbit
SELECT p.nama_penerbit, COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
GROUP BY p.nama_penerbit;


-- 4. Detail lengkap buku
SELECT b.*, k.nama_kategori, p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;