CREATE DATABASE manajemen_perpustakaan;
USE manajemen_perpustakaan;

-- drop database manajemen_perpustakaan;

CREATE TABLE ANGGOTA (
    id_anggota VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    nama_anggota VARCHAR(225) NOT NULL,
    alamat VARCHAR (50) NOT NULL,
    nomor_telp VARCHAR(12) NOT NULL,
    email VARCHAR(89) NOT NULL UNIQUE,
    password VARCHAR(225) NOT NULL,
    CONSTRAINT CheckTabelAnggota1 CHECK (LENGTH(id_anggota) = 5),
    CONSTRAINT CheckTabelAnggota2 CHECK (id_anggota REGEXP "^AG[0-9]{3}$")
);

desc ANGGOTA;

CREATE TABLE PETUGAS (
    id_petugas VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    nama_petugas VARCHAR(225) NOT NULL,
    nomor_telp VARCHAR(12) NOT NULL,
    email VARCHAR(89) NOT NULL UNIQUE,
    password VARCHAR(225) NOT NULL,
    CONSTRAINT CheckTabelPetugas1 CHECK (LENGTH(id_petugas) = 5),
    CONSTRAINT CheckTabelPetugas2 CHECK (id_petugas REGEXP "^PG[0-9]{3}$")

);

ALTER TABLE PETUGAS
ADD id_jabatan VARCHAR(6);

desc PETUGAS;

CREATE TABLE JABATAN (	
    id_jabatan VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    nama_jabatan VARCHAR(225) NOT NULL,
    CONSTRAINT CheckTabelJabatan1 CHECK (LENGTH(id_jabatan) = 5),
    CONSTRAINT CheckTabelJabatan2 CHECK (id_jabatan REGEXP "^JB[0-9]{3}$")
);

ALTER TABLE PETUGAS
ADD CONSTRAINT id_jabatan 
FOREIGN KEY (id_jabatan)
REFERENCES JABATAN(id_jabatan)
ON DELETE CASCADE;

ALTER TABLE PETUGAS
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE PETUGAS
ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

desc JABATAN;

CREATE TABLE BUKU  (
    id_buku VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    nama_buku VARCHAR(225) NOT NULL,
    tahun_terbit DATE,
    stok INT,
    CONSTRAINT CheckTabelBuku1 CHECK (LENGTH(id_buku) = 5),
    CONSTRAINT CheckTabelBuku2 CHECK (id_buku REGEXP "^BK[0-9]{3}$")
);

ALTER TABLE BUKU
ADD id_kategori VARCHAR(6);

ALTER TABLE BUKU
ADD kode_rak VARCHAR(6);

ALTER TABLE BUKU
ADD nama_penulis VARCHAR(100);

ALTER TABLE BUKU
ADD nama_penerbit VARCHAR(100);

desc BUKU;

CREATE TABLE KATEGORI_BUKU
(
    id_kategori VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    nama_kategori VARCHAR(50),
    CONSTRAINT CheckTabelKategoriBuku1 CHECK (LENGTH(id_kategori) = 5),
    CONSTRAINT CheckTabelKategoriBuku2 CHECK (id_kategori REGEXP "^KB[0-9]{3}$")
);

ALTER TABLE BUKU
ADD CONSTRAINT FK_Buku 
FOREIGN KEY (id_kategori)
REFERENCES KATEGORI_BUKU(id_kategori)
ON DELETE CASCADE;

desc KATEGORI_BUKU;

CREATE TABLE RAK_BUKU
(
    kode_rak VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    nama_rak VARCHAR(30),
    CONSTRAINT CheckTabelRakBuku1 CHECK (LENGTH(kode_rak) = 5),
    CONSTRAINT CheckTabelRakBuku2 CHECK (kode_rak REGEXP "^RB[0-9]{3}$")
);

ALTER TABLE BUKU
ADD CONSTRAINT FK_rakBuku 
FOREIGN KEY (kode_rak)
REFERENCES RAK_BUKU(kode_rak)
ON DELETE CASCADE;

ALTER TABLE RAK_BUKU 
ADD lokasi VARCHAR(50);

desc RAK_BUKU;

-- Drop existing DETAIL_PEMINJAMAN table and its triggers
DROP TABLE IF EXISTS DETAIL_PEMINJAMAN;
DROP TRIGGER IF EXISTS after_detail_pinjam_insert;
DROP TRIGGER IF EXISTS before_detail_pinjam_insert;

-- Modify PEMINJAMAN table to include id_buku
DROP TABLE IF EXISTS PEMINJAMAN;
CREATE TABLE PEMINJAMAN (
    kode_pinjam VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    id_anggota VARCHAR(6),
    id_petugas VARCHAR(6),
    id_buku VARCHAR(6),
    tanggal_pinjam DATETIME DEFAULT CURRENT_TIMESTAMP,
    estimasi_pinjam DATETIME,
    status ENUM('DIPINJAM', 'TERLAMBAT', 'DIKEMBALIKAN') NOT NULL DEFAULT 'DIPINJAM',
    CONSTRAINT CheckTabelPeminjaman1 CHECK (LENGTH(kode_pinjam) = 5),
    CONSTRAINT CheckTabelPeminjaman2 CHECK (kode_pinjam REGEXP "^PJ[0-9]{3}$"),
    FOREIGN KEY (id_anggota) REFERENCES ANGGOTA(id_anggota) ON DELETE CASCADE,
    FOREIGN KEY (id_petugas) REFERENCES PETUGAS(id_petugas) ON DELETE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES BUKU(id_buku) ON DELETE CASCADE
);

desc PEMINJAMAN;

-- DROP TABLE IF EXISTS PENGEMBALIAN;

CREATE TABLE PENGEMBALIAN (
    kode_pengembalian VARCHAR(6) UNIQUE NOT NULL PRIMARY KEY,
    tanggal_pengembalian DATETIME,
    kode_pinjam VARCHAR(6),
    kondisi_buku ENUM('bagus', 'rusak', 'hilang') NOT NULL DEFAULT 'bagus',
    denda double(10,2),
    CONSTRAINT CheckTabelPengembalian1 CHECK (LENGTH(kode_pengembalian) = 5),
    CONSTRAINT CheckTabelPengembalian2 CHECK (kode_pengembalian REGEXP "^PB[0-9]{3}$"),
    CONSTRAINT FK_peminjaman FOREIGN KEY (kode_pinjam) REFERENCES PEMINJAMAN(kode_pinjam) ON DELETE CASCADE
);

desc PENGEMBALIAN;

ALTER TABLE anggota
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE anggota
ADD COLUMN jenis_anggota varchar(10);

ALTER TABLE anggota
ADD COLUMN status varchar(10);


CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    otp VARCHAR(6),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expired_at TIMESTAMP,
    is_used BOOLEAN DEFAULT FALSE
);


ALTER TABLE peminjaman MODIFY COLUMN status ENUM('DIPINJAM', 'TERLAMBAT', 'DIKEMBALIKAN') NOT NULL DEFAULT 'DIPINJAM';

-- Update existing records
UPDATE peminjaman SET status = 'TERLAMBAT' 
WHERE estimasi_pinjam < CURRENT_DATE AND status = 'DIPINJAM';

-- Add status column to buku table
ALTER TABLE buku ADD COLUMN status ENUM('TERSEDIA', 'DIPINJAM') NOT NULL DEFAULT 'TERSEDIA';

-- Update existing records based on stok
UPDATE buku SET status = CASE 
    WHEN stok > 0 THEN 'TERSEDIA'
    ELSE 'DIPINJAM'
END;

-- Add index for status column
ALTER TABLE buku ADD INDEX idx_buku_status (status);

-- Create or replace trigger for auto-updating status
DELIMITER //
DROP TRIGGER IF EXISTS update_buku_status//
CREATE TRIGGER update_buku_status BEFORE UPDATE ON buku
FOR EACH ROW
BEGIN
    IF NEW.stok <= 0 THEN
        SET NEW.status = 'DIPINJAM';
    ELSE
        SET NEW.status = 'TERSEDIA';
    END IF;
END//
DELIMITER ;


CREATE TABLE DETAIL_PEMINJAMAN (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_pinjam VARCHAR(6),
    id_buku VARCHAR(6),
    kondisi_buku_pinjam ENUM('bagus', 'rusak') NOT NULL DEFAULT 'bagus',
    FOREIGN KEY (kode_pinjam) REFERENCES PEMINJAMAN(kode_pinjam) ON DELETE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES BUKU(id_buku) ON DELETE CASCADE
);

-- Create trigger to decrease book stock when loan detail is added
DELIMITER //
CREATE TRIGGER before_detail_pinjam_insert
BEFORE INSERT ON DETAIL_PEMINJAMAN
FOR EACH ROW
BEGIN
    UPDATE BUKU SET stok = stok - 1 WHERE id_buku = NEW.id_buku;
END//
DELIMITER ;

-- Create trigger to track book status
DELIMITER //
CREATE TRIGGER after_detail_pinjam_insert 
AFTER INSERT ON DETAIL_PEMINJAMAN
FOR EACH ROW 
BEGIN
    DECLARE current_stok INT;
    SELECT stok INTO current_stok FROM BUKU WHERE id_buku = NEW.id_buku;
    
    IF current_stok <= 0 THEN
        UPDATE BUKU SET status = 'DIPINJAM' WHERE id_buku = NEW.id_buku;
    END IF;
END//
DELIMITER ;


-- Insert data into JABATAN
INSERT INTO JABATAN (id_jabatan, nama_jabatan) VALUES
('JB001', 'Kepala Perpustakaan'),
('JB002', 'Wakil Kepala Perpustakaan'),
('JB003', 'Staff Administrasi'),
('JB004', 'Staff IT'),
('JB005', 'Staff Kebersihan'),
('JB006', 'Staff Keamanan'),
('JB007', 'Staff Pelayanan'),
('JB008', 'Staff Pengadaan'),
('JB009', 'Staff Keuangan'),
('JB010', 'Staff Humas');

-- Insert data into ANGGOTA
INSERT INTO ANGGOTA (id_anggota, nama_anggota, alamat, nomor_telp, email) VALUES
('AG001', 'John Doe', 'Jl. Merdeka No. 1', '081234567890', 'john.doe@example.com'),
('AG002', 'Jane Smith', 'Jl. Sudirman No. 2', '081234567891', 'jane.smith@example.com'),
('AG003', 'Alice Johnson', 'Jl. Thamrin No. 3', '081234567892', 'alice.johnson@example.com'),
('AG004', 'Bob Brown', 'Jl. Gatot Subroto No. 4', '081234567893', 'bob.brown@example.com'),
('AG005', 'Charlie Davis', 'Jl. Ahmad Yani No. 5', '081234567894', 'charlie.davis@example.com'),
('AG006', 'David Evans', 'Jl. Diponegoro No. 6', '081234567895', 'david.evans@example.com'),
('AG007', 'Eve Foster', 'Jl. Imam Bonjol No. 7', '081234567896', 'eve.foster@example.com'),
('AG008', 'Frank Green', 'Jl. HOS Cokroaminoto No. 8', '081234567897', 'frank.green@example.com'),
('AG009', 'Grace Harris', 'Jl. RA Kartini No. 9', '081234567898', 'grace.harris@example.com'),
('AG010', 'Hank Irving', 'Jl. MH Thamrin No. 10', '081234567899', 'hank.irving@example.com');

-- Insert data into PETUGAS
INSERT INTO PETUGAS (id_petugas, nama_petugas, nomor_telp, email, password, id_jabatan, created_at, updated_at) VALUES
('PG001', 'Iwan Setiawan', '081234567800', 'iwan.setiawan@example.com',"pass123", 'JB001', '2023-01-01', '2023-01-01'),
('PG002', 'Rina Sari', '081234567801', 'rina.sari@example.com',"pass123" ,'JB002', '2023-01-01', '2023-01-01'),
('PG003', 'Budi Santoso', '081234567802', 'budi.santoso@example.com',"pass123", 'JB003', '2023-01-01', '2023-01-01'),
('PG004', 'Siti Aminah', '081234567803', 'siti.aminah@example.com',"pass123", 'JB004' , '2023-01-01', '2023-01-01'),
('PG005', 'Agus Prasetyo', '081234567804', 'agus.prasetyo@example.com',"pass123", 'JB005' , '2023-01-01', '2023-01-01'),
('PG006', 'Dewi Lestari', '081234567805', 'dewi.lestari@example.com',"pass123", 'JB006' , '2023-01-01', '2023-01-01'),
('PG007', 'Andi Wijaya', '081234567806', 'andi.wijaya@example.com', "pass123",'JB007' , '2023-01-01', '2023-01-01'),
('PG008', 'Maya Sari', '081234567807', 'maya.sari@example.com', "pass123",'JB008' , '2023-01-01', '2023-01-01'),
('PG009', 'Rudi Hartono', '081234567808', 'rudi.hartono@example.com', "pass123",'JB009' , '2023-01-01', '2023-01-01'),
('PG010', 'Tina Marlina', '081234567809', 'tina.marlina@example.com', "pass123",'JB010' , '2023-01-01', '2023-01-01');

INSERT INTO RAK_BUKU (kode_rak, nama_rak, lokasi) VALUES
('RB001', 'Rak Fiksi', 'Lantai 1'),
('RB002', 'Rak Non-Fiksi', 'Lantai 1'),
('RB003', 'Rak Ilmiah', 'Lantai 2'),
('RB004', 'Rak Sejarah', 'Lantai 2'),
('RB005', 'Rak Biografi', 'Lantai 3'),
('RB006', 'Rak Teknologi', 'Lantai 3'),
('RB007', 'Rak Seni', 'Lantai 4'),
('RB008', 'Rak Agama', 'Lantai 4'),
('RB009', 'Rak Pendidikan', 'Lantai 5'),
('RB010', 'Rak Kesehatan', 'Lantai 5');

-- Insert data into KATEGORI_BUKU
INSERT INTO KATEGORI_BUKU (id_kategori, nama_kategori) VALUES
('KB001', 'Fiksi'),
('KB002', 'Non-Fiksi'),
('KB003', 'Ilmiah'),
('KB004', 'Sejarah'),
('KB005', 'Biografi'),
('KB006', 'Teknologi'),
('KB007', 'Seni'),
('KB008', 'Agama'),
('KB009', 'Pendidikan'),
('KB010', 'Kesehatan');

INSERT INTO BUKU (id_buku, nama_buku, tahun_terbit, stok, id_kategori, kode_rak, nama_penulis, nama_penerbit) VALUES
('BK001', 'Laskar Pelangi', '2005-01-01', 10, 'KB001', 'RB001', 'Andrea Hirata', 'Bentang Pustaka'),
('BK002', 'Bumi Manusia', '1980-01-01', 10, 'KB004', 'RB004', 'Pramoedya Ananta Toer', 'Hasta Mitra'),
('BK003', 'Atomic Habits', '2018-01-01', 10, 'KB002', 'RB002', 'James Clear', 'Avery'),
('BK004', 'Sapiens', '2011-01-01', 10, 'KB003', 'RB003', 'Yuval Noah Harari', 'Harper'),
('BK005', 'Steve Jobs', '2011-01-01', 10, 'KB005', 'RB005', 'Walter Isaacson', 'Simon & Schuster'),
('BK006', 'Clean Code', '2008-01-01', 10, 'KB006', 'RB006', 'Robert C. Martin', 'Prentice Hall'),
('BK007', 'The Art of War', '2003-01-01', 10, 'KB007', 'RB007', 'Sun Tzu', 'Oxford University Press'),
('BK008', 'Al-Qur\'an', '0632-01-01', 10, 'KB008', 'RB008', 'Allah SWT', 'Madinah Press'),
('BK009', 'Pedagogy of the Oppressed', '1968-01-01', 10, 'KB009', 'RB009', 'Paulo Freire', 'Continuum'),
('BK010', 'The China Study', '2004-01-01', 10, 'KB010', 'RB010', 'T. Colin Campbell', 'BenBella Books');

