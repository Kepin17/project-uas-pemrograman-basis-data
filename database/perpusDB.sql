-- Active: 1736158449543@@127.0.0.1@3306@manajemen_perpustakaan
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
-- DROP TABLE IF EXISTS DETAIL_PEMINJAMAN;
-- DROP TRIGGER IF EXISTS after_detail_pinjam_insert;
-- DROP TRIGGER IF EXISTS before_detail_pinjam_insert;

-- Modify PEMINJAMAN table to include id_buku
-- DROP TABLE IF EXISTS PEMINJAMAN;
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

-- drop table detail_peminjaman;

CREATE TABLE DETAIL_PEMINJAMAN (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_pinjam VARCHAR(6),
    id_buku VARCHAR(6),
    kondisi_buku_pinjam ENUM('bagus', 'rusak') NOT NULL DEFAULT 'bagus',
    jumlah INT NOT NULL DEFAULT 1,
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


