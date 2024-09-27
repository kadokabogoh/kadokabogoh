CREATE DATABASE transaksi_pacar;

USE transaksi_pacar;

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pacar VARCHAR(100) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga DECIMAL(10, 2) NOT NULL,
    tanggal_transaksi DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('memberi', 'diberi') NOT NULL
);
