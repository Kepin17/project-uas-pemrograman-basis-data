CREATE TABLE otp_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_anggota VARCHAR(20) NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    is_used TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota)
);
