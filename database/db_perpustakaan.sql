-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Inang: localhost
-- Waktu pembuatan: 26 Mei 2015 pada 18.46
-- Versi Server: 5.5.43-0ubuntu0.14.04.1
-- Versi PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE IF NOT EXISTS `anggota` (
  `nis` varchar(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jk` varchar(2) DEFAULT NULL,
  `ttl` date DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `kode_barang` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `jumlah_tmp` int(11) NOT NULL,
  `dibuat` int(11) NOT NULL,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kode_barang`, `jenis`, `merk`, `type`, `jumlah`, `jumlah_tmp`, `dibuat`) VALUES
('BR001', 'Jenis', 'Merk', 3, 75000, 74999, 1432529735),
('BR002', 'Mark02', 'Merk01', 2, 233, 233, 1432545964);

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `kode_buku` varchar(5) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `pengarang` varchar(50) DEFAULT NULL,
  `klasifikasi` varchar(25) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`kode_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `pengarang`, `klasifikasi`, `image`) VALUES
('MM001', 'Meniup Awan', 'Ada', '<p>sss</p>', 'Baju_Muslim_Setelan_Chocoberry.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabang`
--

CREATE TABLE IF NOT EXISTS `cabang` (
  `kode` varchar(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `uker` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `dibuat` int(11) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cabang`
--

INSERT INTO `cabang` (`kode`, `nama`, `uker`, `pic`, `dibuat`) VALUES
('BR001', 'endah', 'sfsdf', 'sdfsdf', 0),
('BR002', 'trisul', 'sfsdf', 'sdfsdf', 1432534916);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE IF NOT EXISTS `pengembalian` (
  `id_transaksi` varchar(12) DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `denda` varchar(2) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE IF NOT EXISTS `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) DEFAULT NULL,
  `password` text,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `user`, `password`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp`
--

CREATE TABLE IF NOT EXISTS `tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_detail`
--

CREATE TABLE IF NOT EXISTS `tmp_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tmp_id` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `tmp_detail`
--

INSERT INTO `tmp_detail` (`id`, `tmp_id`, `kode_barang`, `jenis`, `merk`, `type`, `jumlah`) VALUES
(3, 1, 'BR001', 'Jenis', 'Merk', 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` varchar(12) NOT NULL DEFAULT '',
  `id_cabang` varchar(255) DEFAULT NULL,
  `tanggal_pinjam` int(11) NOT NULL,
  `tanggal_kembali` int(11) NOT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_cabang`, `tanggal_pinjam`, `tanggal_kembali`, `id_petugas`, `created`) VALUES
('20150526001', 'BR001', 1432573200, 1432637281, 3, 1432611461),
('20150526002', 'BR002', 1432573200, 1432637627, 3, 1432637418),
('20150526003', 'BR001', 1432573200, 0, 3, 1432640661),
('20150526004', 'BR002', 1432573200, 0, 3, 1432640724);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE IF NOT EXISTS `transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` varchar(50) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `id_transaksi`, `kode_barang`, `jumlah`) VALUES
(1, '20150526001', 'BR001', 1),
(2, '20150526001', 'BR002', 3),
(3, '20150526002', 'BR002', 10),
(4, '20150526002', 'BR001', 10),
(5, '20150526003', 'BR001', 1),
(6, '20150526004', 'BR001', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `dibuat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `type`
--

INSERT INTO `type` (`id`, `nama`, `dibuat`) VALUES
(2, 'ciki', 1432528934),
(3, 'ahai', 1432528939);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
