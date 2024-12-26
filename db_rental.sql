-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jun 2024 pada 06.03
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rental`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_bayar` (IN `id_booked` INT)   SELECT * FROM pembayaran WHERE id_booking = id_booked$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_booked` (IN `kode_booked` INT)   SELECT * FROM booking WHERE kode_booking = kode_booked$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_mobil` (IN `p_id_mobil` INT)   BEGIN
    SELECT * FROM mobil WHERE id_mobil = p_id_mobil;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HitungDenda` ()   BEGIN
    DECLARE selesai INT DEFAULT FALSE;
    DECLARE id_booking INT;
    DECLARE tanggal_booking DATE;
    DECLARE lama_sewa INT;
    DECLARE tanggal_pengembalian DATE;
    DECLARE denda INT;
    DECLARE cur CURSOR FOR 
        SELECT id_booking, tanggal, lama_sewa 
        FROM booking 
        WHERE pengembalian = 'ya';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET selesai = TRUE;

    OPEN cur;

    loop_baca: LOOP
        FETCH cur INTO id_booking, tanggal_booking, lama_sewa;
        IF selesai THEN
            LEAVE loop_baca;
        END IF;
        
        -- Cari tanggal pengembalian
        SELECT tanggal INTO tanggal_pengembalian 
        FROM pengembalian 
        WHERE kode_booking = (SELECT kode_booking FROM booking WHERE id_booking = id_booking);
        
        -- Hitung denda berdasarkan selisih antara tanggal pengembalian dan tanggal booking
        SET denda = DATEDIFF(tanggal_pengembalian, tanggal_booking) - lama_sewa;
        IF denda < 0 THEN
            SET denda = 0;
        END IF;
        
        -- Perbarui tabel booking dengan denda yang dihitung
        UPDATE booking 
        SET total_harga = total_harga + denda
        WHERE id_booking = id_booking;
    END LOOP;

    CLOSE cur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HitungDendaPengembalian` ()   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE cur_id_booking INT;
    DECLARE cur_kode_booking VARCHAR(50);
    DECLARE cur_tanggal DATE;
    DECLARE cur_lama_sewa INT;
    DECLARE cur_tanggal_pengembalian DATE;
    DECLARE cur_jumlah_hari_terlambat INT;
    DECLARE cur_total_denda INT;
    DECLARE daily_penalty INT DEFAULT 50000; -- contoh denda harian, misal 50,000

    -- Declare a cursor for selecting overdue bookings
    DECLARE booking_cursor CURSOR FOR
        SELECT id_booking, kode_booking, tanggal, lama_sewa
        FROM booking
        WHERE DATE_ADD(tanggal, INTERVAL lama_sewa DAY) < CURDATE()
        AND id_booking NOT IN (SELECT id_booking FROM pengembalian WHERE tanggal = CURDATE());

    -- Declare a NOT FOUND handler to set done to TRUE when there are no more rows
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Open the cursor
    OPEN booking_cursor;

    -- Loop through all overdue bookings
    read_loop: LOOP
        FETCH booking_cursor INTO cur_id_booking, cur_kode_booking, cur_tanggal, cur_lama_sewa;

        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Calculate the return date and overdue days
        SET cur_tanggal_pengembalian = DATE_ADD(cur_tanggal, INTERVAL cur_lama_sewa DAY);
        SET cur_jumlah_hari_terlambat = DATEDIFF(CURDATE(), cur_tanggal_pengembalian);

        IF cur_jumlah_hari_terlambat > 0 THEN
            -- Calculate the total penalty
            SET cur_total_denda = cur_jumlah_hari_terlambat * daily_penalty;

            -- Insert into pengembalian table
            INSERT INTO pengembalian (
                kode_booking,
                tanggal,
                denda
            ) VALUES (
                cur_kode_booking,
                CURDATE(),
                cur_total_denda
            );
        END IF;
    END LOOP;

    -- Close the cursor
    CLOSE booking_cursor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_booking` (IN `p_kode_booking` VARCHAR(50), IN `p_id_login` INT, IN `p_id_mobil` INT, IN `p_ktp` VARCHAR(50), IN `p_nama` VARCHAR(100), IN `p_alamat` TEXT, IN `p_no_tlp` VARCHAR(20), IN `p_tanggal` DATE, IN `p_lama_sewa` INT, IN `p_total_harga` INT, IN `p_konfirmasi_pembayaran` VARCHAR(50), IN `p_tgl_input` DATE, IN `p_pengembalian` VARCHAR(255))   BEGIN
    INSERT INTO booking (
        kode_booking, 
        id_login, 
        id_mobil, 
        ktp, 
        nama, 
        alamat, 
        no_tlp, 
        tanggal, 
        lama_sewa, 
        total_harga, 
        konfirmasi_pembayaran, 
        tgl_input,
        pengembalian
    ) VALUES (
        p_kode_booking, 
        p_id_login, 
        p_id_mobil, 
        p_ktp, 
        p_nama, 
        p_alamat, 
        p_no_tlp, 
        p_tanggal, 
        p_lama_sewa, 
        p_total_harga, 
        p_konfirmasi_pembayaran, 
        p_tgl_input,
        p_pengembalian
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_pembayaran` (IN `p_id_booking` INT, IN `p_no_rekening` INT, IN `p_nama_rekening` VARCHAR(100), IN `p_nominal` INT, IN `p_tanggal` DATE)   BEGIN
    INSERT INTO pembayaran (
        id_booking, 
        no_rekening, 
        nama_rekening, 
        nominal, 
        tanggal
    ) VALUES (
        p_id_booking, 
        p_no_rekening, 
        p_nama_rekening, 
        p_nominal, 
        p_tanggal
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_booking` (IN `p_id_booking` INT, IN `p_konfir_bayar` VARCHAR(50), IN `p_pengembalian` VARCHAR(50))   BEGIN
    UPDATE booking 
    SET konfirmasi_pembayaran = p_konfir_bayar, 
        pengembalian = p_pengembalian 
    WHERE id_booking = p_id_booking;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `kode_booking` varchar(255) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `lama_sewa` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `konfirmasi_pembayaran` varchar(255) NOT NULL,
  `tgl_input` varchar(255) NOT NULL,
  `pengembalian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id_booking`, `kode_booking`, `id_login`, `id_mobil`, `ktp`, `nama`, `alamat`, `no_tlp`, `tanggal`, `lama_sewa`, `total_harga`, `konfirmasi_pembayaran`, `tgl_input`, `pengembalian`) VALUES
(1, '1718098159', 4, 11, '3537153282312', 'Paijo', 'jl baru', '08972817821', '2024-06-11', 1, 300971, 'Sedang di proses', '2024-06-11', 'ya'),
(2, '1718104288', 4, 11, '3537153282312', 'budi leksmana', 'jl baru', '08972817821', '2024-06-09', 1, 300225, 'Pembayaran di terima', '2024-06-11', 'ya'),
(3, '1718104401', 4, 11, '3537153282312', 'Paijo', 'jl baru', '08972817821', '2024-06-11', 1, 300306, 'Sedang di proses', '2024-06-11', 'ya'),
(4, '1718104497', 4, 6, '3537153282312', 'aryo', 'jl kedung sugo', '08972817821', '2024-06-08', 1, 500859, 'Pembayaran di terima', '2024-06-11', 'ya'),
(5, '1718104706', 4, 6, '3537153282312', 'aryo', 'jl baru', '08972817821', '2024-06-10', 1, 500460, 'Pembayaran di terima', '2024-06-11', 'ya'),
(6, '1718104743', 4, 6, '3537153282312', 'aryo', 'jl baru', '08972817821', '2024-06-11', 1, 500521, 'Pembayaran di terima', '2024-06-11', 'ya'),
(7, '1718216216', 4, 7, '3537153282312', 'aryo', 'jl kedung sugo', '08972817821', '2024-06-13', 1, 500733, 'Pembayaran di terima', '2024-06-12', 'ya');

--
-- Trigger `booking`
--
DELIMITER $$
CREATE TRIGGER `after_booking_insert` AFTER INSERT ON `booking` FOR EACH ROW BEGIN
    UPDATE mobil
    SET stok = stok - 1
    WHERE id_mobil = NEW.id_mobil;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_delete_booking` AFTER DELETE ON `booking` FOR EACH ROW BEGIN
    UPDATE mobil
    SET stok = stok + 1
    WHERE id_mobil = OLD.id_mobil;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `infoweb`
--

CREATE TABLE `infoweb` (
  `id` int(11) NOT NULL,
  `nama_rental` varchar(255) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_rek` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `infoweb`
--

INSERT INTO `infoweb` (`id`, `nama_rental`, `telp`, `alamat`, `email`, `no_rek`, `updated_at`) VALUES
(1, 'Rental Sinar Jaya', '081298777222', 'Jl. Telang Indah ', 'rentalsinarjaya@gmail.com', 'BNI A/N Rental Sinar Jaya 123123213123', '2022-01-24 04:57:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_login`, `nama_pengguna`, `username`, `password`, `level`) VALUES
(1, 'Rental Sinar jaya', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(3, 'Krisna Waskita', 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'pengguna'),
(4, 'pasep', 'pasep', 'e83732b0c0db16be2c5546701e1b8e97', 'pengguna');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `no_plat` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `harga` int(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `gambar` text NOT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `no_plat`, `merk`, `harga`, `deskripsi`, `status`, `gambar`, `stok`) VALUES
(5, 'N34234', 'Avanza', 200000, 'Apa aja', 'Tersedia', '1673593078toyota-all-new-avanza-2015-tangkapan-layar_169.jpeg', 2),
(6, 'N 1232 BKT', 'New Xenia', 500000, 'Baru', 'Tidak Tersedia', 'all-new-xenia-exterior-tampak-perspektif-depan---varian-1.5r-ads.jpg', 0),
(7, 'L 1332 AG', 'Pajero Sport', 500000, 'Mobil kelas sport', 'Tersedia', '1718120496.jpeg', 2),
(11, 'L 1333 SU', 'Xenia 2012', 300000, 'Mobil keluarga', 'Tidak Tersedia', '1717832287.jpg', 0),
(16, 'L 2333 SR', 'Toyota Kijang Inova', 500000, 'Mobil keluarga', 'Tidak Tersedia', '1718121009.jpeg', 0);

--
-- Trigger `mobil`
--
DELIMITER $$
CREATE TRIGGER `update_mobil_status_on_update` BEFORE UPDATE ON `mobil` FOR EACH ROW BEGIN
    IF NEW.stok = 0 THEN
        SET NEW.status = 'Tidak Tersedia';
    ELSE
        SET NEW.status = 'Tersedia';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_booking` int(255) NOT NULL,
  `no_rekening` int(255) NOT NULL,
  `nama_rekening` varchar(255) NOT NULL,
  `nominal` int(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_booking`, `no_rekening`, `nama_rekening`, `nominal`, `tanggal`) VALUES
(1, 2, 2147483647, 'chendy', 2000000, '2024-06-11'),
(2, 3, 2147483647, 'Paijo', 1000000, '2024-06-11'),
(3, 1, 2147483647, 'Paijo', 310000, '2024-06-11'),
(4, 2, 2147483647, 'Paijo', 1000000, '2024-06-09'),
(5, 3, 2147483647, 'chendy', 1000000, '2024-06-11'),
(6, 4, 2147483647, 'aryo', 1000000, '2024-06-10'),
(7, 5, 2147483647, 'aryo', 2000000, '2024-06-11'),
(8, 6, 2147483647, 'aryo', 2000000, '2024-06-11'),
(9, 7, 2147483647, 'chendy', 2000000, '2024-06-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `kode_booking` varchar(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `denda` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `kode_booking`, `tanggal`, `denda`) VALUES
(2, '1718104288', '2024-06-11', 50000),
(3, '1718104497', '2024-06-11', 100000);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_booking`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_booking` (
`id_booking` int(11)
,`kode_booking` varchar(255)
,`id_login` int(11)
,`id_mobil` int(11)
,`ktp` varchar(255)
,`nama` varchar(255)
,`alamat` varchar(255)
,`no_tlp` varchar(15)
,`tanggal` varchar(255)
,`lama_sewa` int(11)
,`total_harga` int(11)
,`konfirmasi_pembayaran` varchar(255)
,`tgl_input` varchar(255)
,`pengembalian` varchar(255)
,`merk` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_history`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_history` (
`merk` varchar(255)
,`id_booking` int(11)
,`kode_booking` varchar(255)
,`id_login` int(11)
,`id_mobil` int(11)
,`ktp` varchar(255)
,`nama` varchar(255)
,`alamat` varchar(255)
,`no_tlp` varchar(15)
,`tanggal` varchar(255)
,`lama_sewa` int(11)
,`total_harga` int(11)
,`konfirmasi_pembayaran` varchar(255)
,`tgl_input` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_mobil`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_mobil` (
`id_mobil` int(11)
,`no_plat` varchar(255)
,`merk` varchar(255)
,`harga` int(255)
,`deskripsi` varchar(255)
,`status` varchar(255)
,`gambar` text
,`stok` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_pelanggan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_pelanggan` (
`id_login` int(11)
,`nama_pengguna` varchar(255)
,`username` varchar(255)
,`password` varchar(255)
,`level` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_riwayat_bayar`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_riwayat_bayar` (
`nama` varchar(255)
,`nama_rekening` varchar(255)
,`nominal` int(255)
,`total_harga` int(11)
,`konfirmasi_pembayaran` varchar(255)
,`tanggal` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_booking`
--
DROP TABLE IF EXISTS `v_booking`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_booking`  AS SELECT `booking`.`id_booking` AS `id_booking`, `booking`.`kode_booking` AS `kode_booking`, `booking`.`id_login` AS `id_login`, `booking`.`id_mobil` AS `id_mobil`, `booking`.`ktp` AS `ktp`, `booking`.`nama` AS `nama`, `booking`.`alamat` AS `alamat`, `booking`.`no_tlp` AS `no_tlp`, `booking`.`tanggal` AS `tanggal`, `booking`.`lama_sewa` AS `lama_sewa`, `booking`.`total_harga` AS `total_harga`, `booking`.`konfirmasi_pembayaran` AS `konfirmasi_pembayaran`, `booking`.`tgl_input` AS `tgl_input`, `booking`.`pengembalian` AS `pengembalian`, `mobil`.`merk` AS `merk` FROM (`booking` join `mobil` on(`booking`.`id_mobil` = `mobil`.`id_mobil`))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_history`
--
DROP TABLE IF EXISTS `v_history`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_history`  AS SELECT `mobil`.`merk` AS `merk`, `booking`.`id_booking` AS `id_booking`, `booking`.`kode_booking` AS `kode_booking`, `booking`.`id_login` AS `id_login`, `booking`.`id_mobil` AS `id_mobil`, `booking`.`ktp` AS `ktp`, `booking`.`nama` AS `nama`, `booking`.`alamat` AS `alamat`, `booking`.`no_tlp` AS `no_tlp`, `booking`.`tanggal` AS `tanggal`, `booking`.`lama_sewa` AS `lama_sewa`, `booking`.`total_harga` AS `total_harga`, `booking`.`konfirmasi_pembayaran` AS `konfirmasi_pembayaran`, `booking`.`tgl_input` AS `tgl_input` FROM (`booking` join `mobil` on(`booking`.`id_mobil` = `mobil`.`id_mobil`)) ORDER BY `booking`.`id_booking` ASC;


-- --------------------------------------------------------

--
-- Struktur untuk view `v_mobil`
--
DROP TABLE IF EXISTS `v_mobil`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mobil`  AS SELECT `mobil`.`id_mobil` AS `id_mobil`, `mobil`.`no_plat` AS `no_plat`, `mobil`.`merk` AS `merk`, `mobil`.`harga` AS `harga`, `mobil`.`deskripsi` AS `deskripsi`, `mobil`.`status` AS `status`, `mobil`.`gambar` AS `gambar`, `mobil`.`stok` AS `stok` FROM `mobil` ORDER BY `mobil`.`id_mobil` AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_pelanggan`
--
DROP TABLE IF EXISTS `v_pelanggan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pelanggan`  AS SELECT `login`.`id_login` AS `id_login`, `login`.`nama_pengguna` AS `nama_pengguna`, `login`.`username` AS `username`, `login`.`password` AS `password`, `login`.`level` AS `level` FROM `login` WHERE `login`.`level` = 'Pengguna' ORDER BY `login`.`id_login` AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_riwayat_bayar`
--
DROP TABLE IF EXISTS `v_riwayat_bayar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_riwayat_bayar`  AS SELECT `booking`.`nama` AS `nama`, `pembayaran`.`nama_rekening` AS `nama_rekening`, `pembayaran`.`nominal` AS `nominal`, `booking`.`total_harga` AS `total_harga`, `booking`.`konfirmasi_pembayaran` AS `konfirmasi_pembayaran`, `pembayaran`.`tanggal` AS `tanggal` FROM (`booking` join `pembayaran` on(`booking`.`id_booking` = `pembayaran`.`id_booking`)) WHERE `booking`.`konfirmasi_pembayaran` = 'Pembayaran di terima''Pembayaran di terima'  ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

DELIMITER $$
--
-- Event
--
CREATE DEFINER=`root`@`localhost` EVENT `CalculatePenalties` ON SCHEDULE EVERY 1 DAY STARTS '2024-06-11 13:40:16' ON COMPLETION NOT PRESERVE ENABLE DO CALL HitungDendaPengembalian()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
