-- Active: 1736158449543@@127.0.0.1@3306@manajemen_perpustakaan

CREATE DATABASE IF NOT EXISTS manajemen_perpustakaan;

USE manajemen_perpustakaan;

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
ALTER TABLE PETUGAS ADD COLUMN remember_token VARCHAR(64) NULL;

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

CREATE TABLE PEMINJAMAN (
    kode_pinjam VARCHAR(6) NOT NULL PRIMARY KEY,
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

DELIMITER //
CREATE TRIGGER after_pengembalian_insert
AFTER INSERT ON PENGEMBALIAN
FOR EACH ROW
BEGIN
    DECLARE buku_id VARCHAR(6);
    DECLARE jumlah_pinjam INT;

    -- Get the id_buku and jumlah from the corresponding detail_peminjaman record
    SELECT id_buku, jumlah INTO buku_id, jumlah_pinjam
    FROM DETAIL_PEMINJAMAN
    WHERE kode_pinjam = NEW.kode_pinjam;

    -- Update the stok in the BUKU table
    UPDATE BUKU
    SET stok = stok + jumlah_pinjam
    WHERE id_buku = buku_id;
END//
DELIMITER ;

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
    expired_at TIMESTAMP NULL,
    is_used BOOLEAN DEFAULT FALSE
);


ALTER TABLE peminjaman MODIFY COLUMN status ENUM('DIPINJAM', 'TERLAMBAT', 'DIKEMBALIKAN') NOT NULL DEFAULT 'DIPINJAM';

UPDATE peminjaman SET status = 'TERLAMBAT' 
WHERE estimasi_pinjam < CURRENT_DATE AND status = 'DIPINJAM';

ALTER TABLE buku ADD COLUMN status ENUM('TERSEDIA', 'DIPINJAM') NOT NULL DEFAULT 'TERSEDIA';

UPDATE buku SET status = CASE 
    WHEN stok > 0 THEN 'TERSEDIA'
    ELSE 'DIPINJAM'
END;

ALTER TABLE buku ADD INDEX idx_buku_status (status);

DELIMITER //
-- DROP TRIGGER IF EXISTS update_buku_status//
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
    jumlah INT NOT NULL DEFAULT 1,
    FOREIGN KEY (kode_pinjam) REFERENCES PEMINJAMAN(kode_pinjam) ON DELETE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES BUKU(id_buku) ON DELETE CASCADE
);

DELIMITER //
CREATE TRIGGER before_detail_pinjam_insert
BEFORE INSERT ON DETAIL_PEMINJAMAN
FOR EACH ROW
BEGIN
    UPDATE BUKU SET stok = stok - 1 WHERE id_buku = NEW.id_buku;
END//
DELIMITER ;

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


CREATE TABLE otp_login (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    otp VARCHAR(6),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    is_used BOOLEAN DEFAULT FALSE
);


-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table manajemen_perpustakaan.anggota: ~3 rows (approximately)
INSERT INTO `anggota` (`id_anggota`, `nama_anggota`, `alamat`, `nomor_telp`, `email`, `created_at`, `updated_at`) VALUES
	('AG001', 'Adela', 'Jl Peta Selatan', '081225984467', 'adel@gmail.com', '2025-01-09 06:53:35', '2025-01-09 19:30:20'),
	('AG003', 'Ridwan ', 'disini\r\n', '087829467141', 'ridwan@gmail.com', '2025-01-09 06:55:58', '2025-01-09 13:55:58'),
	('AG004', 'Kevien', 'Jl Peta Selatan', '085284838833', 'test@gmail.com', '2025-01-10 00:57:20', '2025-01-10 07:57:20'),
	('AG005', 'Ahmad Faisal', 'cemani', '9786788676', 'faisal3107@gmail.com', '2025-01-10 01:43:19', '2025-01-10 08:43:19');

-- Dumping data for table manajemen_perpustakaan.buku: ~3 rows (approximately)

-- Dumping data for table manajemen_perpustakaan.jabatan: ~2 rows (approximately)
INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
	('JB001', 'Kepala Perpustakaan'),
	('JB003', 'Staff Admin'),
	('JB007', 'Staff Pelayanan'),
	('JB008', 'Staff perpustakaan');


    
-- Dumping data for table manajemen_perpustakaan.petugas: ~4 rows (approximately)
INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `nomor_telp`, `email`, `password`, `id_jabatan`, `created_at`, `updated_at`, `remember_token`) VALUES
	('PG001', 'Olyzano', '081289389380', 'kevien.oj@gmail.com', '$2y$10$oevaQ0fSsIC9ZflXUq2fh.gPjAlVttb8u3g2xAZlO6gl21BrE9x2G', 'JB001', '2025-01-09 06:43:18', '2025-01-09 23:23:46', NULL),
	('PG002', 'Roihan Arrafli', '089289190', 'roihanabcd@gmail.com', '$2y$10$G7.OLDuyRoXEr2Hd1tGnnejFLgLtFwddokl6JM1qdWo0pTLFK0Pia', 'JB003', '2025-01-09 06:45:27', '2025-01-10 08:04:00', NULL),
	('PG003', 'Prima Ganteng', '0812778389', 'prima.sandhika01@gmail.com', '$2y$10$W/TV9NK2QVd9cHnNIUnlqu.4RQU5YdZNu2TzozaXY56vwosOoi1Uy', 'JB007', '2025-01-09 06:48:04', '2025-01-21 15:02:27', NULL);

-- Dumping data for table manajemen_perpustakaan.rak_buku: ~3 rows (approximately)
INSERT INTO `rak_buku` (`kode_rak`, `nama_rak`, `lokasi`) VALUES
	('RB001', 'Rak Komik', 'Lantai 1'),
	('RB002', 'Rak Novel', 'Lantai 1'),
	('RB003', 'Rak Music', 'Lantai 1'),
	('RB004', 'Rak Jawa', 'Lantai 5');


-- Dumping data for table manajemen_perpustakaan.kategori_buku: ~3 rows (approximately)
INSERT INTO `kategori_buku` (`id_kategori`, `nama_kategori`) VALUES
	('KB001', 'Komik'),
	('KB002', 'Novel'),
	('KB003', 'Music'),
	('KB004', 'Pendidikan');

INSERT INTO `buku` (`id_buku`, `nama_buku`, `tahun_terbit`, `stok`, `id_kategori`, `kode_rak`, `nama_penulis`, `nama_penerbit`, `status`) VALUES
	('BK001', 'Buku Music 1', '2010-02-20', 10, 'KB003', 'RB003', 'aksan', 'aksan company', 'TERSEDIA'),
	('BK002', 'Popopo', '1999-02-20', 33, 'KB001', 'RB001', 'Popo', 'Popo', 'TERSEDIA'),
	('BK003', 'Hujan', '2025-01-01', 7, 'KB002', 'RB002', 'Tere Liye', 'tes', 'TERSEDIA');

-- Dumping data for table manajemen_perpustakaan.detail_peminjaman: ~9 rows (approximately)


-- Dumping data for table manajemen_perpustakaan.otp_login: ~1 rows (approximately)
INSERT INTO `otp_login` (`id`, `email`, `otp`, `created_at`, `expires_at`) VALUES
	(8, 'kevien.oj@gmail.com', '652470', '2025-01-09 16:51:36', '2025-01-09 10:06:36');

-- Dumping data for table manajemen_perpustakaan.password_resets: ~4 rows (approximately)
INSERT INTO `password_resets` (`id`, `email`, `otp`, `created_at`, `expired_at`, `is_used`) VALUES
	(6, 'servicenya4@gmail.com', '891515', '2025-01-09 08:16:52', '2025-01-09 01:31:52', 0),
	(10, NULL, '703840', '2025-01-09 17:33:48', '2025-01-09 10:48:48', 0),
	(12, 'kevien.oj@gmail.com', '250690', '2025-01-09 17:41:51', '2025-01-09 10:56:51', 0),
	(13, 'roihanabcd@gmail.com', '876655', '2025-01-10 01:03:12', '2025-01-09 18:18:12', 0),
	(14, 'iwan.setiawan@example.com', '686843', '2025-01-20 06:47:28', '2025-01-20 00:02:28', 0),
	(15, 'prima.sandhika01@gmail.com', '979815', '2025-01-21 07:01:56', '2025-01-21 00:16:56', 0);

-- Dumping data for table manajemen_perpustakaan.peminjaman: ~7 rows (approximately)
INSERT INTO `peminjaman` (`kode_pinjam`, `id_anggota`, `id_petugas`, `id_buku`, `tanggal_pinjam`, `estimasi_pinjam`, `status`) VALUES
	('PJ001', 'AG004', 'PG003', NULL, '2025-01-10 00:00:00', '2025-01-17 00:00:00', 'DIKEMBALIKAN'),
	('PJ002', 'AG001', 'PG003', NULL, '2025-01-10 00:00:00', '2025-01-17 00:00:00', 'DIKEMBALIKAN'),
	('PJ003', 'AG005', 'PG003', NULL, '2025-01-10 00:00:00', '2025-01-20 00:00:00', 'DIKEMBALIKAN'),
	('PJ004', 'AG004', 'PG003', NULL, '2024-12-30 00:00:00', '2025-01-09 00:00:00', 'DIKEMBALIKAN'),
	('PJ005', 'AG001', 'PG003', NULL, '2023-01-09 00:00:00', '2025-01-09 00:00:00', 'DIKEMBALIKAN')


INSERT INTO `detail_peminjaman` (`id`, `kode_pinjam`, `id_buku`, `kondisi_buku_pinjam`, `jumlah`) VALUES
	(20, 'PJ001', 'BK002', 'bagus', 1),
	(21, 'PJ002', 'BK001', 'rusak', 1),
	(22, 'PJ002', 'BK002', 'bagus', 1),
	(23, 'PJ003', 'BK003', 'bagus', 4),
	(24, 'PJ003', 'BK001', 'bagus', 1),
	(25, 'PJ004', 'BK001', 'bagus', 1),
	(26, 'PJ005', 'BK001', 'bagus', 1)



/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
