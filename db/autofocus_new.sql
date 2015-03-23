-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03 Mar 2015 pada 11.38
-- Versi Server: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autofocus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
`car_id` int(11) NOT NULL,
  `car_nopol` varchar(100) NOT NULL,
  `car_model_id` int(11) NOT NULL,
  `car_no_machine` varchar(100) NOT NULL,
  `car_no_rangka` varchar(100) NOT NULL,
  `car_color` varchar(100) NOT NULL,
  `car_type` varchar(50) NOT NULL,
  `car_year` varchar(4) NOT NULL,
  `car_description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cars`
--

INSERT INTO `cars` (`car_id`, `car_nopol`, `car_model_id`, `car_no_machine`, `car_no_rangka`, `car_color`, `car_type`, `car_year`, `car_description`) VALUES
(1, 'W 6082 TZ', 1, '123', '456', 'Hitam', 'City Car', '', 'ok'),
(3, 'L 6973 TU', 1, '5745645', '34234234', 'Putih', 'City Car', '', ''),
(4, 'L 6004 TY', 1, '2143254', '2523523', 'Hitam', 'City car', '2000', ''),
(5, 'W 3534 WL', 2, '234rrr', '234234rrr', 'Putih', 'Sedang', '2003', ''),
(6, 'N 334 R', 3, 'GAFAC5314080', 'MJJJB5583CK002832', 'Hitam', 'Kia new rio', '2012', ''),
(7, 'L 6088 TU', 4, '1234', '1234', 'Hitam', '-', '2012', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `car_models`
--

CREATE TABLE IF NOT EXISTS `car_models` (
`car_model_id` int(11) NOT NULL,
  `car_model_merk` varchar(100) NOT NULL,
  `car_model_name` varchar(100) NOT NULL,
  `car_model_description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `car_models`
--

INSERT INTO `car_models` (`car_model_id`, `car_model_merk`, `car_model_name`, `car_model_description`) VALUES
(1, 'Daihatsu', 'Xenia', ''),
(2, 'Suzuki', 'Ertiga', ''),
(3, 'KIA', 'NEW RIO', ''),
(4, 'Toyota', 'Rush', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
`customer_id` int(11) NOT NULL,
  `customer_ktp_number` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_addres` varchar(100) NOT NULL,
  `customer_phone_number` varchar(100) NOT NULL,
  `customer_hp` varchar(50) NOT NULL,
  `customer_description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_ktp_number`, `customer_name`, `customer_addres`, `customer_phone_number`, `customer_hp`, `customer_description`) VALUES
(1, '666 777 999 ', 'Candra Dwi Prasetyo', '', '', '', ''),
(2, '35345345', 'Andri Febri', 'Mojokerto', '08534535', '0534634545345', ''),
(3, '-', 'Alifia Maharani', '-', '081333200300', '081333200300', ''),
(4, '-', 'Wawan Setiawan', 'Waru Sidoarjo', '08192313', '0814214124', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_registrations`
--

CREATE TABLE IF NOT EXISTS `detail_registrations` (
`detail_registration_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `detail_registration_type_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `product_price_id` int(11) NOT NULL,
  `detail_registration_ panel_damage` varchar(100) NOT NULL,
  `detail_registration_price` int(11) NOT NULL,
  `detail_registration_approved_price` int(11) NOT NULL,
  `detail_registration_start_date` date NOT NULL,
  `detail_registration_completed_date` date NOT NULL,
  `detail_registration_status` int(11) NOT NULL,
  `detail_registration_description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=600012 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_registrations`
--

INSERT INTO `detail_registrations` (`detail_registration_id`, `registration_id`, `detail_registration_type_id`, `employee_id`, `product_price_id`, `detail_registration_ panel_damage`, `detail_registration_price`, `detail_registration_approved_price`, `detail_registration_start_date`, `detail_registration_completed_date`, `detail_registration_status`, `detail_registration_description`) VALUES
(120000, 6, 1, 1, 11, '', 120000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(600000, 6, 1, 1, 3, '', 600000, 600000, '0000-00-00', '0000-00-00', 0, ''),
(400000, 7, 1, 1, 9, '', 400000, 400000, '0000-00-00', '0000-00-00', 0, ''),
(100000, 7, 1, 1, 13, '', 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(600003, 8, 1, 1, 11, '', 120000, 120000, '0000-00-00', '0000-00-00', 0, ''),
(600007, 9, 1, 1, 96, '', 400000, 265050, '0000-00-00', '0000-00-00', 0, ''),
(600006, 9, 1, 1, 95, '', 400000, 400000, '0000-00-00', '0000-00-00', 0, ''),
(600005, 9, 1, 1, 94, '', 350000, 350000, '0000-00-00', '0000-00-00', 0, ''),
(600004, 9, 1, 1, 93, '', 350000, 350000, '0000-00-00', '0000-00-00', 0, ''),
(600009, 10, 1, 1, 94, '', 350000, 350000, '0000-00-00', '0000-00-00', 0, ''),
(600008, 10, 1, 1, 93, '', 350000, 350000, '0000-00-00', '0000-00-00', 0, ''),
(600011, 11, 1, 1, 96, '', 400000, 400000, '0000-00-00', '0000-00-00', 0, ''),
(600010, 11, 1, 1, 94, '', 350000, 300000, '0000-00-00', '0000-00-00', 0, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
`employee_id` int(11) NOT NULL,
  `employee_nip` varchar(10) DEFAULT NULL,
  `employee_name` varchar(40) DEFAULT NULL,
  `employee_birth` date DEFAULT NULL,
  `employee_gender` int(11) DEFAULT NULL,
  `employee_position_id` int(11) DEFAULT NULL,
  `employee_ktp` varchar(30) DEFAULT NULL,
  `employee_address` varchar(100) DEFAULT NULL,
  `employee_phone` varchar(20) DEFAULT NULL,
  `employee_email` varchar(30) DEFAULT NULL,
  `employee_bank_number` varchar(30) DEFAULT NULL,
  `employee_bank_name` varchar(50) DEFAULT NULL,
  `employee_bank_beneficiary` varchar(50) DEFAULT NULL,
  `employee_active_status` varchar(1) DEFAULT NULL,
  `employee_pic` mediumtext
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_nip`, `employee_name`, `employee_birth`, `employee_gender`, `employee_position_id`, `employee_ktp`, `employee_address`, `employee_phone`, `employee_email`, `employee_bank_number`, `employee_bank_name`, `employee_bank_beneficiary`, `employee_active_status`, `employee_pic`) VALUES
(1, NULL, 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL),
(19, 'E0000001', 'Sangkan', '1974-01-23', 1, 2, '890910002', 'surabaya', '0876287181', 'sangkan@yahoo.com', '456787686', 'BCA', 'sangkan', '1', NULL),
(20, 'E0000002', 'paijo', '2014-12-01', 1, 2, '1212121', '-', '353535', 'paijo@gmail.com', '123456788', 'bca', 'paijo', '1', NULL),
(21, 'E0000003', 'supali', '2014-12-24', 2, 3, '575757', 'adoh', '53543545', 'supali@yahoo.co.id', '09876543', 'mandiri', 'supali', '1', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_groups`
--

CREATE TABLE IF NOT EXISTS `employee_groups` (
`employee_group_id` int(11) NOT NULL,
  `employee_group_name` varchar(100) NOT NULL,
  `employee_group_description` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employee_groups`
--

INSERT INTO `employee_groups` (`employee_group_id`, `employee_group_name`, `employee_group_description`) VALUES
(2, 'Group 2', 'sementara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_group_histories`
--

CREATE TABLE IF NOT EXISTS `employee_group_histories` (
`employee_group_history_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_group_items`
--

CREATE TABLE IF NOT EXISTS `employee_group_items` (
`employee_group_item_id` int(11) NOT NULL,
  `employee_group_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employee_group_items`
--

INSERT INTO `employee_group_items` (`employee_group_item_id`, `employee_group_id`, `employee_id`) VALUES
(4, 1, 19),
(2, 2, 20),
(3, 2, 21),
(5, 1, 21);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_positions`
--

CREATE TABLE IF NOT EXISTS `employee_positions` (
`employee_position_id` int(11) NOT NULL,
  `employee_position_name` varchar(100) NOT NULL,
  `employee_position_description` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employee_positions`
--

INSERT INTO `employee_positions` (`employee_position_id`, `employee_position_name`, `employee_position_description`) VALUES
(1, 'Sekretaris', ''),
(2, 'Otomotif', ''),
(3, 'Manager', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`group_id` int(11) NOT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `group_is_active` varchar(1) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_is_active`) VALUES
(1, 'Administrator', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `insurances`
--

CREATE TABLE IF NOT EXISTS `insurances` (
`insurance_id` int(11) NOT NULL,
  `insurance_name` varchar(100) NOT NULL,
  `insurance_pph` int(11) NOT NULL,
  `insurance_addres` varchar(100) NOT NULL,
  `insurance_phone` varchar(100) NOT NULL,
  `insurance_description` text NOT NULL,
  `insurance_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `insurance_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `insurances`
--

INSERT INTO `insurances` (`insurance_id`, `insurance_name`, `insurance_pph`, `insurance_addres`, `insurance_phone`, `insurance_description`, `insurance_active_status`, `created_by_id`, `insurance_date`, `inactive_by_id`) VALUES
(4, 'Autocillin', 10, 'Jl. Diponegoro No. 145 - 147,  Surabaya 60241', '-', '', 1, 1, '2014-11-24', 0),
(1, 'Pribadi', 0, '', '', '', 1, 1, '2014-11-24', 0),
(8, 'Jaya Proteks', 5, '-', '-', '3', 1, 1, '2015-02-04', 0),
(9, 'PT Asuransi Multi Artha Guna Tbk', 2, 'Jl. Raya Darmo no. 139 Surabaya Jawa Timur', '-', '', 1, 1, '2015-02-13', 0),
(10, 'Ramayana', 5, '-', '-', '-', 1, 1, '2015-02-17', 0),
(11, 'Jusufanio', 5, '-', '-', '', 1, 1, '2015-02-17', 0),
(12, 'Askrida', 5, '-', '-', '', 1, 1, '2015-02-17', 0),
(13, 'Jasindo', 5, '-', '-', '', 1, 1, '2015-02-17', 0),
(14, 'Bumida', 5, '-', '-', '', 1, 1, '2015-02-17', 0),
(15, 'Pan Pacific', 5, '-', '-', '', 1, 1, '2015-02-17', 0),
(16, 'Asoka Mas', 5, '-', '-', '', 1, 1, '2015-02-17', 0),
(17, 'MPM', 5, '-', '-', '', 1, 1, '2015-02-17', 0),
(18, 'BCA Insurance', 5, '-', '-', '', 1, 1, '2015-02-17', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_action_types`
--

CREATE TABLE IF NOT EXISTS `log_action_types` (
  `log_action_type_id` int(11) DEFAULT NULL,
  `log_action_type_name` varchar(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_data`
--

CREATE TABLE IF NOT EXISTS `log_data` (
`log_data_id` int(11) NOT NULL,
  `log_data_time` datetime DEFAULT NULL,
  `log_data_module_id` int(11) DEFAULT NULL,
  `log_data_ip` varchar(254) DEFAULT NULL,
  `log_data_user_id` int(11) DEFAULT NULL,
  `log_data_type` smallint(6) DEFAULT NULL,
  `log_data_data_id` int(11) DEFAULT NULL,
  `log_data_remark` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_data`
--

INSERT INTO `log_data` (`log_data_id`, `log_data_time`, `log_data_module_id`, `log_data_ip`, `log_data_user_id`, `log_data_type`, `log_data_data_id`, `log_data_remark`) VALUES
(1, '2014-11-03 12:11:01', 4, '::1', 1, 0, 3, 'Kategori Produk [spareparts]'),
(2, '2014-11-04 14:11:21', 4, '::1', 1, 2, 3, 'Produk Kategori'),
(3, '2014-11-10 11:11:00', 5, '::1', 1, 0, 1, 'produk [bemper]'),
(4, '2014-11-10 11:11:57', 5, '::1', 1, 1, 1, 'produk[bemper]'),
(5, '2014-11-12 10:11:53', 4, '::1', 1, 0, 1, 'Kategori Produk [cat]'),
(6, '2014-11-12 10:11:44', 5, '::1', 1, 0, 1, 'produk [bemper depan]'),
(7, '2014-11-12 10:11:02', 5, '::1', 1, 1, 1, 'produk[bemper belakang]'),
(8, '2014-11-12 11:11:30', 4, '::1', 1, 2, 1, 'Produk Kategori'),
(9, '2014-11-12 11:11:52', 4, '::1', 1, 1, 1, 'Produk Kategori'),
(10, '2014-11-12 12:11:00', 4, '::1', 1, 0, 2, 'Kategori Produk [jasa]'),
(11, '2014-11-12 12:11:10', 5, '::1', 1, 0, 2, 'produk [all body ringgan]'),
(12, '2014-11-14 13:11:33', 5, '::1', 1, 0, 3, 'produk [bemper]'),
(13, '2014-11-14 13:11:05', 5, '::1', 1, 0, 4, 'produk [1]'),
(14, '2014-11-14 13:11:04', 5, '::1', 1, 0, 1, 'produk [bemper]'),
(15, '2014-11-14 13:11:42', 5, '::1', 1, 0, 2, 'produk [bemper depan]'),
(16, '2014-11-24 02:11:36', 5, '::1', 1, 0, 1, 'produk [High Beam]'),
(17, '2014-11-24 03:11:30', 5, '::1', 1, 0, 2, 'produk [High beam]'),
(18, '2014-11-24 11:11:13', 5, '::1', 1, 0, 3, 'produk [Low Beam]'),
(19, '2014-11-24 12:11:21', 5, '::1', 1, 0, 4, 'produk [Bemper Depan]'),
(20, '2014-12-04 00:12:56', 5, '127.0.0.1', 1, 1, 4, 'produk[Bemper Depan]'),
(21, '2014-12-04 00:12:38', 5, '127.0.0.1', 1, 1, 3, 'produk[Low Beam]'),
(22, '2014-12-17 11:12:16', 4, '127.0.0.1', 1, 1, 1, 'Kategori Produk [sperpart]'),
(23, '2014-12-17 11:12:36', 5, '127.0.0.1', 1, 0, 5, 'produk [AC dalam]'),
(24, '2014-12-18 14:12:12', 23, '127.0.0.1', 1, 0, 20, 'Pegawai [paijo]'),
(25, '2014-12-18 14:12:12', 23, '127.0.0.1', 1, 0, 21, 'Pegawai [supali]'),
(26, '2014-12-26 18:12:28', 5, '127.0.0.1', 1, 0, 6, 'produk [1]'),
(27, '2015-01-05 15:01:38', 25, '127.0.0.1', 1, 0, 3, 'produk[P00001]'),
(28, '2015-01-05 15:01:47', 25, '127.0.0.1', 1, 0, 4, 'produk[P00001]'),
(29, '2015-01-05 15:01:21', 25, '127.0.0.1', 1, 2, 4, 'Produk'),
(30, '2015-01-05 15:01:32', 25, '127.0.0.1', 1, 1, 3, 'produk[P00001]'),
(31, '2015-01-05 15:01:50', 25, '127.0.0.1', 1, 0, 5, 'produk[P00002]'),
(32, '2015-01-05 15:01:59', 25, '127.0.0.1', 1, 2, 5, 'Produk'),
(33, '2015-01-05 15:01:03', 25, '127.0.0.1', 1, 2, 3, 'Produk'),
(34, '2015-01-16 15:01:51', 4, '::1', 1, 0, 3, 'Kategori Produk [Cat]'),
(35, '2015-01-16 16:01:47', 4, '::1', 1, 0, 4, 'Kategori Produk [Bahan]'),
(36, '2015-01-16 16:01:16', 4, '::1', 1, 1, 3, 'Kategori Produk [Cat]'),
(37, '2015-01-16 16:01:25', 4, '::1', 1, 0, 5, 'Kategori Produk [dddd]'),
(38, '2015-01-16 16:01:02', 4, '::1', 1, 1, 1, 'Kategori Produk [sperpart]'),
(39, '2015-01-16 16:01:07', 4, '::1', 1, 1, 2, 'Kategori Produk [jasa]'),
(40, '2015-01-16 16:01:13', 4, '::1', 1, 1, 3, 'Kategori Produk [Cat]'),
(41, '2015-01-16 16:01:30', 5, '::1', 1, 0, 7, 'produk [Bemper belakang]'),
(42, '2015-01-16 16:01:13', 5, '::1', 1, 0, 8, 'produk [Lampu Belakang]'),
(43, '2015-01-17 00:01:40', 5, '::1', 1, 0, 9, 'produk [Spion]'),
(44, '2015-01-22 05:01:16', 5, '::1', 1, 0, 10, 'produk [Pintu Depan]'),
(45, '2015-01-22 05:01:53', 25, '::1', 1, 1, 8, 'produk[]'),
(46, '2015-01-22 05:01:03', 25, '::1', 1, 1, 8, 'produk[]'),
(47, '2015-01-22 05:01:20', 25, '::1', 1, 1, 8, ''),
(48, '2015-01-22 05:01:33', 25, '::1', 1, 1, 9, ''),
(49, '2015-02-03 12:02:07', 5, '::1', 1, 0, 12, 'produk [Atap]'),
(50, '2015-02-03 12:02:25', 5, '::1', 1, 2, 12, 'Produk'),
(51, '2015-02-03 12:02:02', 5, '::1', 1, 1, 12, 'Produk'),
(52, '2015-02-03 12:02:07', 5, '::1', 1, 2, 12, 'Produk'),
(53, '2015-02-03 12:02:14', 5, '::1', 1, 1, 12, 'Produk'),
(54, '2015-02-13 15:02:24', 5, '::1', 1, 0, 13, 'produk [Bumper belakang]'),
(55, '2015-02-13 15:02:44', 5, '::1', 1, 0, 14, 'produk [Bumper Depan]'),
(56, '2015-02-13 15:02:07', 5, '::1', 1, 0, 15, 'produk [Pintu Bagasi]'),
(57, '2015-02-13 15:02:29', 5, '::1', 1, 0, 16, 'produk [Pintu Tengah/Belakang Kiri]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_sys`
--

CREATE TABLE IF NOT EXISTS `log_sys` (
  `log_sys_time` datetime DEFAULT NULL,
  `log_sys_type` int(11) DEFAULT NULL,
  `log_sys_ip` varchar(254) DEFAULT NULL,
  `log_sys_user_id` int(11) DEFAULT NULL,
  `log_sys_action` varchar(50) DEFAULT NULL,
  `log_sys_uri` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_sys`
--

INSERT INTO `log_sys` (`log_sys_time`, `log_sys_type`, `log_sys_ip`, `log_sys_user_id`, `log_sys_action`, `log_sys_uri`) VALUES
('2014-10-27 14:10:38', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-10-27 15:10:44', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-10-27 15:10:27', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-10-28 12:10:55', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-10-28 12:10:08', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-10-28 12:10:33', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-10-28 12:10:42', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-03 11:11:05', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-03 11:11:26', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-03 11:11:31', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-03 11:11:15', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-03 11:11:20', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-03 12:11:33', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-03 12:11:38', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-03 12:11:44', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-10 10:11:55', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-10 11:11:28', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-10 11:11:39', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-11 23:11:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-11 23:11:05', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-11 23:11:36', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-11 23:11:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-12 00:11:21', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-12 01:11:02', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-12 02:11:20', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-12 02:11:21', 0, '::1', 0, 'LOGOUT', 'login/logout/1'),
('2014-11-12 02:11:27', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-12 02:11:44', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-12 02:11:45', 0, '::1', 0, 'LOGOUT', 'login/logout/1'),
('2014-11-12 02:11:50', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-12 11:11:47', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-12 11:11:21', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-12 11:11:43', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-12 12:11:22', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-12 12:11:24', 0, '::1', 0, 'LOGOUT', 'login/logout/1'),
('2014-11-12 12:11:29', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-13 12:11:29', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-13 12:11:35', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-13 12:11:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-13 12:11:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-13 13:11:19', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-13 14:11:46', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-23 00:11:49', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-23 20:11:44', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-23 20:11:42', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-23 20:11:49', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-23 20:11:14', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-23 23:11:16', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-24 10:11:04', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-24 10:11:09', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-24 10:11:35', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-24 10:11:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-24 10:11:44', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-24 10:11:49', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-24 10:11:08', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-24 10:11:13', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-24 10:11:13', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-24 10:11:18', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-25 14:11:42', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 02:11:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 03:11:35', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 03:11:37', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 03:11:47', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 09:11:11', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-28 09:11:17', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 11:11:19', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 12:11:36', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-28 12:11:50', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-11-28 12:11:44', 0, '192.168.1.109', 1, 'LOGIN', 'login/submit'),
('2014-11-28 13:11:07', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-11-28 13:11:44', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-01 16:12:45', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-02 10:12:13', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-02 16:12:53', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-16 12:12:06', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-17 13:12:45', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-12-17 13:12:00', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-17 13:12:02', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-12-17 13:12:07', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-17 13:12:49', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-12-17 13:12:07', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-17 13:12:21', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-12-17 13:12:30', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-17 13:12:04', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-12-17 13:12:13', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-17 13:12:57', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-12-17 13:12:04', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-19 03:12:30', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-19 10:12:37', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-19 16:12:13', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-19 16:12:50', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-21 12:12:02', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-12-21 12:12:20', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-21 15:12:07', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-21 16:12:38', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-22 10:12:38', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-23 16:12:30', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-23 17:12:57', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-23 17:12:33', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 10:12:21', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 10:12:44', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 10:12:51', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 10:12:20', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 13:12:55', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 14:12:28', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 14:12:55', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 17:12:42', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 17:12:49', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 18:12:43', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-26 21:12:38', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-27 11:12:57', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-27 11:12:48', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-27 11:12:39', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-27 12:12:04', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-29 10:12:08', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-29 12:12:41', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-12-30 10:12:35', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2015-01-05 15:01:03', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2015-01-05 15:01:11', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2015-01-15 12:01:21', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-15 12:01:30', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-21 22:01:11', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-22 05:01:52', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-01-22 05:01:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-22 05:01:16', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-01-22 05:01:22', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-22 05:01:18', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-01-22 05:01:27', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-22 16:01:07', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-22 16:01:20', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-23 12:01:53', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-23 12:01:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-23 12:01:58', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-26 12:01:02', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-27 11:01:08', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-29 11:01:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-01-29 12:01:51', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-01-29 12:01:52', 0, '::1', 0, 'LOGOUT', 'login/logout/1'),
('2015-01-29 12:01:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-02 11:02:37', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-03 12:02:04', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-03 12:02:20', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-02-03 12:02:23', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-03 12:02:35', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-02-03 12:02:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-03 13:02:33', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-02-03 13:02:39', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-03 15:02:02', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-04 11:02:02', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-04 13:02:34', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-04 14:02:29', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-04 16:02:51', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-04 16:02:51', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-04 16:02:34', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-06 14:02:50', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-06 17:02:21', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-07 00:02:47', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-09 00:02:06', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-02-09 00:02:12', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-09 00:02:44', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-02-09 00:02:49', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-09 01:02:38', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-09 14:02:28', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2015-02-09 14:02:35', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-09 14:02:24', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-12 08:02:35', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-13 15:02:23', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-17 13:02:22', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-24 15:02:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-24 16:02:31', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-26 07:02:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-26 08:02:48', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-02-27 12:02:37', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-03-02 11:03:35', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2015-03-03 11:03:13', 0, '::1', 1, 'LOGIN', 'login/submit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `markets`
--

CREATE TABLE IF NOT EXISTS `markets` (
  `market_id` int(11) NOT NULL,
  `market_code` varchar(100) NOT NULL,
  `market_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `markets`
--

INSERT INTO `markets` (`market_id`, `market_code`, `market_name`) VALUES
(1, 'S0000001', 'Sidosermo'),
(3, 'S0000002', 'Kedungturi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
`module_id` int(11) NOT NULL,
  `module_code` varchar(50) DEFAULT NULL,
  `module_name` varchar(40) DEFAULT NULL,
  `module_approval_url` varchar(50) DEFAULT NULL,
  `module_group` varchar(50) DEFAULT NULL,
  `module_view_url` varchar(50) DEFAULT NULL,
  `module_cancel_url` varchar(50) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `modules`
--

INSERT INTO `modules` (`module_id`, `module_code`, `module_name`, `module_approval_url`, `module_group`, `module_view_url`, `module_cancel_url`) VALUES
(11, 'transaction.po_process', 'PO process ', '', 'transaction.po_process', NULL, NULL),
(10, 'transaction.po_retur', 'PO retur ', '', 'transaction.po_retur', NULL, NULL),
(9, 'transaction.po_reservation', 'PO reservation ', '', 'transaction.po_reservation', NULL, NULL),
(8, 'transaction.po_received', 'PO received ', '', 'transaction.po_received', NULL, NULL),
(7, 'master.uom', 'uom', '', 'master.uom', NULL, NULL),
(6, 'master.site', 'Site', '', 'master.site', NULL, NULL),
(5, 'master.product', 'Material list', '', 'master.product', NULL, NULL),
(4, 'master.product_category', 'Material type', '', 'master.product_category', NULL, NULL),
(3, 'master.project_name', 'Project name', '', 'master.project_name', NULL, NULL),
(1, 'master.dashboard', 'dashboard', '', 'master.dashboard', NULL, NULL),
(2, 'master.phase', 'phase', '', 'master.phase', NULL, NULL),
(12, 'report.project_report', 'Project report ', '', 'report.project_report', NULL, NULL),
(13, 'report.po_received_summary_report', 'PO Received Summary Report ', '', 'report.po_received_summary_report', NULL, NULL),
(14, 'report.po_received_report', 'PO Received Report ', '', 'report.po_received_report', NULL, NULL),
(15, 'report.po_reservation_summary_report', 'PO Reservation Summary Report ', '', 'report.po_reservation_summary_report', NULL, NULL),
(16, 'report.po_reservation_report', 'PO Reservation Report ', '', 'report.po_reservation_report', NULL, NULL),
(17, 'report.phase_report', 'PO Phase Report ', '', 'report.phase_report', NULL, NULL),
(18, 'report.material_report', 'Material Report ', '', 'report.material_report', NULL, NULL),
(19, 'tool.user', 'User', '', 'tool.user', NULL, NULL),
(20, 'tool.permit', 'Permission', '', 'tool.permit', NULL, NULL),
(21, 'tool.user_aproved', 'User aproved', '', 'tool.user_aproved', NULL, NULL),
(22, 'report.site_report', 'Site Report', NULL, 'report.site_report', NULL, NULL),
(23, 'master.employee', 'Employee', NULL, 'master.employee', NULL, NULL),
(24, 'master.employee_position', 'Posisi Pegawai', NULL, 'master.employee_position', NULL, NULL),
(25, 'master.stock_product', 'Stok Produk', NULL, 'master.stock_product', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
`payment_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `own_retention_dibayar` int(11) NOT NULL,
  `own_retention_sisa` int(11) NOT NULL,
  `pembayaran_dibayar` int(11) NOT NULL,
  `pembayaran_sisa` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`payment_id`, `registration_id`, `payment_date`, `own_retention_dibayar`, `own_retention_sisa`, `pembayaran_dibayar`, `pembayaran_sisa`) VALUES
(2, 6, '2015-02-09', 300000, 0, 1790000, 0),
(4, 7, '2015-02-09', 20000, 0, 750000, 0),
(5, 8, '2015-02-12', 200000, 0, 372000, 0),
(6, 9, '2015-02-13', 600000, 0, 3545331, 0),
(7, 11, '2015-03-02', 200000, 0, 2554000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `periods`
--

CREATE TABLE IF NOT EXISTS `periods` (
`period_id` int(11) NOT NULL,
  `period_code` varchar(100) NOT NULL,
  `period_name` varchar(100) NOT NULL,
  `period_month` varchar(2) NOT NULL,
  `period_year` varchar(4) NOT NULL,
  `period_closed` int(11) NOT NULL,
  `period_description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `periods`
--

INSERT INTO `periods` (`period_id`, `period_code`, `period_name`, `period_month`, `period_year`, `period_closed`, `period_description`) VALUES
(1, 'PR0000001', '1/2014', '1', '2014', 0, '     '),
(2, 'PR0000002', '2/2014', '2', '2014', 0, ''),
(3, 'PR0000003', '3/2014', '3', '2014', 0, ''),
(4, 'PR0000004', '4/2014', '4', '2014', 0, ''),
(5, 'PR0000005', '5/2014', '5', '2014', 0, ''),
(6, 'PR0000006', '6/2014', '6', '2014', 0, ''),
(7, 'PR0000007', '7/2014', '7', '2014', 0, ''),
(8, 'PR0000008', '8/2014', '8', '2014', 0, ''),
(9, 'PR0000009', '9/2014', '9', '2014', 0, ''),
(10, 'PR0000010', '10/2014', '10', '2014', 0, ''),
(11, 'PR0000011', '11/2014', '11', '2014', 1, ''),
(12, 'PR0000012', '12/2014', '12', '2014', 0, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permits`
--

CREATE TABLE IF NOT EXISTS `permits` (
  `permit_group_id` int(11) DEFAULT NULL,
  `permit_module_id` int(11) DEFAULT NULL,
  `permit_crud_mode` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permits`
--

INSERT INTO `permits` (`permit_group_id`, `permit_module_id`, `permit_crud_mode`) VALUES
(2, 7, 'crud'),
(2, 6, 'crud'),
(2, 5, 'crud'),
(2, 4, 'crud'),
(2, 3, 'crud'),
(2, 1, 'crud'),
(2, 2, 'crud'),
(2, 12, 'crud'),
(2, 21, 'crud'),
(4, 16, 'crud'),
(3, 18, 'crud'),
(3, 17, 'crud'),
(3, 16, 'crud'),
(3, 14, 'crud'),
(3, 12, 'crud'),
(3, 2, 'crud'),
(3, 1, 'crud'),
(3, 3, 'crud'),
(3, 4, 'crud'),
(3, 5, 'crud'),
(3, 6, 'crud'),
(3, 7, 'crud'),
(3, 8, 'crud'),
(3, 9, 'crud'),
(3, 10, 'crud'),
(3, 11, 'crud'),
(4, 14, 'crud'),
(4, 13, 'crud'),
(4, 12, 'crud'),
(4, 2, 'crud'),
(4, 1, 'crud'),
(4, 3, 'crud'),
(4, 4, 'crud'),
(4, 5, 'crud'),
(4, 6, 'crud'),
(4, 7, 'crud'),
(4, 8, 'crud'),
(4, 9, 'crud'),
(4, 10, 'crud'),
(4, 11, 'crud');

-- --------------------------------------------------------

--
-- Struktur dari tabel `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
`photo_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `photo_name` varchar(100) NOT NULL,
  `photo_file` varchar(200) NOT NULL,
  `photo_type_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `photos`
--

INSERT INTO `photos` (`photo_id`, `registration_id`, `photo_name`, `photo_file`, `photo_type_id`) VALUES
(1, 1, 'test', 'Street-Art-Paris-3D-Graffiti-Wallpaper.jpg', 1),
(2, 2, 'q', 'Street-Art-Paris-3D-Graffiti-Wallpaper1.jpg', 1),
(3, 3, '1', 'Street-Art-Paris-3D-Graffiti-Wallpaper2.jpg', 1),
(4, 4, 'High beam', 'char.png', 1),
(5, 4, 'Low Beam', 'ie11.png', 1),
(6, 5, 'Bemper belakang', '10.jpg', 1),
(7, 5, 'Bemper Depan', 'char1.png', 1),
(52, 6, 'perbandingan 1', '1_150209030244_4_17.jpg', 4),
(51, 6, 'mobil keluar 1', '1_150209030244_3_10.jpg', 3),
(65, 7, 'Foto mobil keluar', '1_150209050212_3_91.jpg', 3),
(68, 8, 'High beam baru', '1_150212080249_3_91.jpg', 3),
(76, 11, 'Bumper Depan', '1_150302120350_3_elevenia.png', 3),
(73, 9, 'bumper depan', '1_150213030248_3_download.jpg', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `photo_types`
--

CREATE TABLE IF NOT EXISTS `photo_types` (
`photo_type_id` int(11) NOT NULL,
  `photo_type_name` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `photo_types`
--

INSERT INTO `photo_types` (`photo_type_id`, `photo_type_name`) VALUES
(1, 'foto mobil masuk'),
(2, 'foto pengerjaan'),
(3, 'foto mobil keluar'),
(4, 'foto perbandingan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE IF NOT EXISTS `products` (
`product_id` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `product_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `product_category_id`, `insurance_id`, `product_name`, `product_qty`, `product_description`, `product_active_status`, `created_by_id`, `product_date`, `inactive_by_id`) VALUES
(2, '0', 2, 4, 'High beam', 0, '', 1, 1, '2014-11-24', 0),
(3, 'A00004', 1, 4, 'Low Beam', 0, '', 1, 1, '2014-11-24', 0),
(4, 'A00005', 1, 1, 'Bemper Depan', 0, '', 1, 1, '2014-11-24', 0),
(5, 'AC0003', 1, 4, 'AC dalam', 0, '-', 1, 1, '2014-12-17', 0),
(6, '1', 1, 4, '1', 0, '', 1, 1, '2014-12-26', 0),
(7, 'P0000001', 1, 4, 'Bemper belakang', 0, '', 1, 1, '2015-01-16', 0),
(8, 'P0000002', 2, 4, 'Lampu Belakang', 0, '', 1, 1, '2015-01-16', 0),
(9, 'P0000003', 1, 4, 'Spion', 0, '', 1, 1, '2015-01-17', 0),
(10, 'P0000004', 1, 4, 'Pintu Depan', 0, '', 1, 1, '2015-01-22', 0),
(11, 'P0000005', 0, 4, 'Atap', 0, '', 1, 1, '2015-02-03', 0),
(12, 'P0000006', 0, 4, 'Atap', 0, '', 1, 1, '2015-02-03', 1),
(13, 'P0000007', 0, 9, 'Bumper belakang', 0, '', 1, 1, '2015-02-13', 0),
(14, 'P0000008', 0, 9, 'Bumper Depan', 0, '', 1, 1, '2015-02-13', 0),
(15, 'P0000009', 0, 9, 'Pintu Bagasi', 0, '', 1, 1, '2015-02-13', 0),
(16, 'P0000010', 0, 9, 'Pintu Tengah/Belakang Kiri', 0, '', 1, 1, '2015-02-13', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_histories`
--

CREATE TABLE IF NOT EXISTS `product_histories` (
`product_history_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_history_type` int(11) NOT NULL,
  `product_history_date` datetime NOT NULL,
  `product_history_qty` int(11) NOT NULL,
  `product_history_stock` int(11) NOT NULL,
  `product_history_description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_prices`
--

CREATE TABLE IF NOT EXISTS `product_prices` (
`product_price_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `pst_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_prices`
--

INSERT INTO `product_prices` (`product_price_id`, `product_id`, `product_type_id`, `pst_id`, `product_price`) VALUES
(2, 2, 9, 9, 300000),
(3, 2, 8, 9, 600000),
(4, 2, 7, 9, 900000),
(5, 2, 9, 8, 200000),
(6, 2, 8, 8, 500000),
(7, 2, 7, 8, 800000),
(8, 2, 9, 7, 100000),
(9, 2, 8, 7, 400000),
(10, 2, 7, 7, 700000),
(11, 3, 9, 9, 120000),
(12, 3, 8, 9, 110000),
(13, 3, 7, 9, 100000),
(14, 3, 9, 8, 220000),
(15, 3, 8, 8, 210000),
(16, 3, 7, 8, 200000),
(17, 3, 9, 7, 320000),
(18, 3, 8, 7, 310000),
(19, 3, 7, 7, 300000),
(20, 4, 6, 6, 400000),
(21, 5, 9, 9, 0),
(22, 5, 8, 9, 0),
(23, 5, 7, 9, 0),
(24, 5, 9, 8, 0),
(25, 5, 8, 8, 0),
(26, 5, 7, 8, 0),
(27, 5, 9, 7, 0),
(28, 5, 8, 7, 0),
(29, 5, 7, 7, 0),
(30, 6, 9, 9, 0),
(31, 6, 8, 9, 0),
(32, 6, 7, 9, 0),
(33, 6, 9, 8, 0),
(34, 6, 8, 8, 0),
(35, 6, 7, 8, 0),
(36, 6, 9, 7, 0),
(37, 6, 8, 7, 0),
(38, 6, 7, 7, 0),
(39, 7, 9, 9, 0),
(40, 7, 8, 9, 0),
(41, 7, 7, 9, 0),
(42, 7, 9, 8, 0),
(43, 7, 8, 8, 0),
(44, 7, 7, 8, 0),
(45, 7, 9, 7, 0),
(46, 7, 8, 7, 0),
(47, 7, 7, 7, 0),
(48, 8, 9, 9, 0),
(49, 8, 8, 9, 0),
(50, 8, 7, 9, 0),
(51, 8, 9, 8, 0),
(52, 8, 8, 8, 0),
(53, 8, 7, 8, 0),
(54, 8, 9, 7, 0),
(55, 8, 8, 7, 0),
(56, 8, 7, 7, 0),
(57, 9, 9, 9, 0),
(58, 9, 8, 9, 0),
(59, 9, 7, 9, 0),
(60, 9, 9, 8, 0),
(61, 9, 8, 8, 0),
(62, 9, 7, 8, 0),
(63, 9, 9, 7, 0),
(64, 9, 8, 7, 0),
(65, 9, 7, 7, 0),
(66, 10, 9, 9, 0),
(67, 10, 8, 9, 0),
(68, 10, 7, 9, 0),
(69, 10, 9, 8, 0),
(70, 10, 8, 8, 0),
(71, 10, 7, 8, 0),
(72, 10, 9, 7, 0),
(73, 10, 8, 7, 0),
(74, 10, 7, 7, 0),
(75, 11, 9, 9, 0),
(76, 11, 8, 9, 0),
(77, 11, 7, 9, 0),
(78, 11, 9, 8, 0),
(79, 11, 8, 8, 0),
(80, 11, 7, 8, 0),
(81, 11, 9, 7, 0),
(82, 11, 8, 7, 0),
(83, 11, 7, 7, 0),
(84, 12, 9, 9, 0),
(85, 12, 8, 9, 0),
(86, 12, 7, 9, 0),
(87, 12, 9, 8, 0),
(88, 12, 8, 8, 0),
(89, 12, 7, 8, 0),
(90, 12, 9, 7, 0),
(91, 12, 8, 7, 0),
(92, 12, 7, 7, 0),
(93, 13, 23, 23, 350000),
(94, 14, 23, 23, 350000),
(95, 15, 23, 23, 400000),
(96, 16, 23, 23, 400000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_process`
--

CREATE TABLE IF NOT EXISTS `product_process` (
`product_process_id` int(11) NOT NULL,
  `detail_transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_process_booking_date` date NOT NULL,
  `product_process_comming_date` date NOT NULL,
  `product_process_status` int(11) NOT NULL,
  `product_process_description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_stocks`
--

CREATE TABLE IF NOT EXISTS `product_stocks` (
`product_stock_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_stock_qty` int(11) NOT NULL,
  `stand_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_stocks`
--

INSERT INTO `product_stocks` (`product_stock_id`, `product_id`, `product_stock_qty`, `stand_id`) VALUES
(6, 7, 0, 0),
(7, 9, 0, 0),
(8, 10, 100, 1),
(9, 10, 50, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_sub_type`
--

CREATE TABLE IF NOT EXISTS `product_sub_type` (
`pst_id` int(11) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `pst_name` varchar(100) NOT NULL,
  `pst_description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_sub_type`
--

INSERT INTO `product_sub_type` (`pst_id`, `insurance_id`, `pst_name`, `pst_description`) VALUES
(22, 4, 'Replace', ''),
(21, 4, 'Incentive', ''),
(6, 1, 'normal', ''),
(10, 5, '1', '    '),
(11, 6, '1', '    '),
(12, 7, '2', '    2'),
(24, 8, 'normal', '-'),
(20, 4, 'Repair', ''),
(23, 9, 'normal', '-'),
(25, 10, 'normal', ''),
(26, 11, 'normal', '    '),
(27, 12, 'normal', '    '),
(28, 13, 'normal', '    '),
(29, 14, 'normal', '    '),
(30, 15, 'normal', '    '),
(31, 16, 'normal', '    '),
(32, 17, 'normal', '    '),
(33, 18, 'normal', '    ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_types`
--

CREATE TABLE IF NOT EXISTS `product_types` (
`product_type_id` int(11) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `product_type_name` varchar(100) NOT NULL,
  `product_type_desc` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_types`
--

INSERT INTO `product_types` (`product_type_id`, `insurance_id`, `product_type_name`, `product_type_desc`) VALUES
(22, 4, 'Car Type A', '-'),
(21, 4, 'Car type B', '-'),
(20, 4, 'Car Type C', '-'),
(6, 1, 'normal', '-'),
(10, 5, '1', '1'),
(11, 6, '1', '1'),
(12, 7, '1', '1'),
(24, 8, 'normal', '-'),
(23, 9, 'normal', '-'),
(25, 10, 'normal', ''),
(26, 11, 'normal', '    '),
(27, 12, 'normal', '    '),
(28, 13, 'normal', '    '),
(29, 14, 'normal', '    '),
(30, 15, 'normal', '    '),
(31, 16, 'normal', '    '),
(32, 17, 'normal', '    '),
(33, 18, 'normal', '    ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrations`
--

CREATE TABLE IF NOT EXISTS `registrations` (
`registration_id` int(11) NOT NULL,
  `registration_code` varchar(100) NOT NULL,
  `period_id` int(11) NOT NULL,
  `stand_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `incident_date` date NOT NULL,
  `claim_type` int(11) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `claim_no` varchar(100) NOT NULL,
  `spk_no` varchar(100) NOT NULL,
  `pkb_no` varchar(100) NOT NULL,
  `check_in` date NOT NULL,
  `registration_estimation_date` date NOT NULL,
  `check_out` date NOT NULL,
  `registration_date` date NOT NULL,
  `sparepart_total_registration` int(11) NOT NULL,
  `approved_sparepart_total_registration` int(11) NOT NULL,
  `total_registration` int(11) NOT NULL,
  `approved_total_registration` int(11) NOT NULL,
  `insurance_pph` int(11) NOT NULL,
  `status_registration_id` int(11) NOT NULL,
  `registration_description` longtext NOT NULL,
  `own_retention` int(11) NOT NULL,
  `pic_asuransi` varchar(100) NOT NULL,
  `spk_date` date NOT NULL,
  `registration_dp` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrations`
--

INSERT INTO `registrations` (`registration_id`, `registration_code`, `period_id`, `stand_id`, `customer_id`, `car_id`, `employee_id`, `incident_date`, `claim_type`, `insurance_id`, `claim_no`, `spk_no`, `pkb_no`, `check_in`, `registration_estimation_date`, `check_out`, `registration_date`, `sparepart_total_registration`, `approved_sparepart_total_registration`, `total_registration`, `approved_total_registration`, `insurance_pph`, `status_registration_id`, `registration_description`, `own_retention`, `pic_asuransi`, `spk_date`, `registration_dp`) VALUES
(6, 'R0000002', 11, 1, 1, 1, 1, '2015-02-01', 1, 4, '324234', '234234', '23423423', '2015-02-04', '2015-02-12', '2015-02-13', '2015-02-06', 1200000, 1200000, 720000, 700000, 10, 6, '', 300000, '343432', '2015-02-26', 0),
(7, 'R0000003', 11, 1, 2, 3, 1, '2015-02-03', 1, 4, 'KL0002', 'SPK0002', 'PKB0002', '2015-02-09', '2015-02-10', '2015-02-13', '2015-02-09', 200000, 200000, 500000, 500000, 10, 6, '', 20000, 'Wawan', '2015-02-18', 100000),
(8, 'R0000004', 11, 1, 1, 4, 1, '2015-02-02', 1, 4, 'KL0007', 'SPK0007', 'PKB0007', '2015-02-12', '2015-02-19', '2015-02-12', '2015-02-12', 400000, 400000, 120000, 120000, 10, 6, '', 200000, 'ASC0007', '2015-02-26', 0),
(9, 'R0000005', 11, 1, 3, 6, 1, '0000-00-00', 1, 9, '05020911000048-000770', '17280', '34090', '2014-11-27', '2014-12-10', '2015-02-13', '2015-02-13', 2699000, 2699000, 1500000, 1365050, 2, 6, '', 600000, '-', '2014-11-30', 0),
(10, 'R0000006', 11, 1, 1, 6, 1, '0000-00-00', 1, 9, 'KL0001', 'SPK0001', '00001', '2015-02-24', '2015-02-28', '0000-00-00', '2015-02-24', 200000, 200000, 700000, 700000, 2, 2, '', 200000, 'Adi', '2015-02-25', 0),
(11, 'R0000007', 11, 1, 4, 7, 1, '0000-00-00', 1, 9, 'KL0007', 'SPK0007', '00001', '2015-03-02', '2015-03-24', '2015-03-02', '2015-03-02', 2000000, 2000000, 750000, 700000, 2, 6, '', 200000, 'Lastito', '2015-03-31', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `registration_spareparts`
--

CREATE TABLE IF NOT EXISTS `registration_spareparts` (
`rs_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `rs_qty` int(11) NOT NULL,
  `rs_part_number` varchar(20) NOT NULL,
  `rs_name` varchar(100) NOT NULL,
  `rs_repair` int(11) NOT NULL,
  `rs_approved_repair` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registration_spareparts`
--

INSERT INTO `registration_spareparts` (`rs_id`, `registration_id`, `rs_qty`, `rs_part_number`, `rs_name`, `rs_repair`, `rs_approved_repair`) VALUES
(8, 6, 1, '123213', 'Bemper belakang', 200000, 200000),
(9, 6, 2, '435345', 'High Beam', 1000000, 1000000),
(10, 7, 1, 'PR0002', 'High Beam', 200000, 200000),
(12, 8, 1, 'PART0007', 'Low Beam', 400000, 400000),
(15, 9, 1, '866111W200', 'BUMPER BELAKANG', 1329500, 1329500),
(16, 9, 1, '866111W000', 'BUMPER BELAKANG BAWAH', 1369500, 1369500),
(18, 10, 1, '1', 'Inner depan', 200000, 200000),
(20, 11, 1, 'Part00002', 'Bumper Depan Ori', 2000000, 2000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) DEFAULT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `user_agent` varchar(50) DEFAULT NULL,
  `last_activity` int(11) DEFAULT NULL,
  `user_data` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('1b5a3083665e4865290246b3a0602df9', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/53', 1425273657, 'a:5:{s:5:"redir";a:1:{s:9:"redir_url";s:25:"approved/form_approved/11";}s:6:"logged";i:1;s:9:"user_info";a:19:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:10:"user_email";s:0:"";s:10:"user_phone";s:0:"";s:9:"job_title";s:0:"";s:7:"company";s:0:"";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:12:"expired_date";s:10:"0000-00-00";s:12:"employee_pic";N;s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1425272015;s:7:"menubar";s:4211:"<ul class="sidebar-menu"><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-edit"></i>\r\n					<span>Master List</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/insurance">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Asuransi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/workshop_service">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Harga Borongan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/product">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/price">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Harga Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/customer">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pelanggan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/car">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/stand">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Cabang Bengkel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/car_model">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Model Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/employee">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pegawai</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/employee_position">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Posisi Pegawai</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-shopping-cart"></i>\r\n					<span>transaksi</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/registration">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Registrasi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/approved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Persetujuan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/transaction">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Progress</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/upload_photo">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Upload Foto</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/payment">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pembayaran</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/transaction_status">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Status</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/1">\r\n					<i class="fa fa-print"></i>\r\n					<span>Laporan</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/summary_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Laporan Summary</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/po_received_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Detail Per Mobil</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-asterisk"></i>\r\n					<span>User Management</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/user">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>User</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/permit">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Permission</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/user_aproved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>user approved</span></a>\r\n					</li>\n</li>\n</ul></ul>";}'),
('44ea4253f2f3e847445dc27d8775d8de', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/53', 1425272003, 'a:4:{s:6:"logged";i:1;s:9:"user_info";a:19:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:10:"user_email";s:0:"";s:10:"user_phone";s:0:"";s:9:"job_title";s:0:"";s:7:"company";s:0:"";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:12:"expired_date";s:10:"0000-00-00";s:12:"employee_pic";N;s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1425015877;s:7:"menubar";s:4211:"<ul class="sidebar-menu"><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-edit"></i>\r\n					<span>Master List</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/insurance">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Asuransi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/workshop_service">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Harga Borongan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/product">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/price">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Harga Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/customer">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pelanggan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/car">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/stand">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Cabang Bengkel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/car_model">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Model Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/employee">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pegawai</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/employee_position">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Posisi Pegawai</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-shopping-cart"></i>\r\n					<span>transaksi</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/registration">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Registrasi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/approved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Persetujuan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/transaction">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Progress</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/upload_photo">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Upload Foto</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/payment">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pembayaran</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/transaction_status">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Status</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/1">\r\n					<i class="fa fa-print"></i>\r\n					<span>Laporan</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/summary_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Laporan Summary</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/po_received_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Detail Per Mobil</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-asterisk"></i>\r\n					<span>User Management</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/user">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>User</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/permit">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Permission</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/user_aproved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>user approved</span></a>\r\n					</li>\n</li>\n</ul></ul>";}'),
('78062211db1caabbee12bd9415339e3f', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:36.0) Gecko', 1425357396, 'a:4:{s:6:"logged";i:1;s:9:"user_info";a:19:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:10:"user_email";s:0:"";s:10:"user_phone";s:0:"";s:9:"job_title";s:0:"";s:7:"company";s:0:"";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:12:"expired_date";s:10:"0000-00-00";s:12:"employee_pic";N;s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1425357433;s:7:"menubar";s:4211:"<ul class="sidebar-menu"><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-edit"></i>\r\n					<span>Master List</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/insurance">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Asuransi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/workshop_service">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Harga Borongan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/product">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/price">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Harga Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/customer">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pelanggan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/car">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/stand">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Cabang Bengkel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/car_model">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Model Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/employee">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pegawai</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/employee_position">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Posisi Pegawai</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-shopping-cart"></i>\r\n					<span>transaksi</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/registration">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Registrasi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/approved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Persetujuan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/transaction">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Progress</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/upload_photo">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Upload Foto</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/payment">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pembayaran</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/transaction_status">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Status</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/1">\r\n					<i class="fa fa-print"></i>\r\n					<span>Laporan</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/summary_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Laporan Summary</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/po_received_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Detail Per Mobil</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://localhost/autofocus/#">\r\n					<i class="fa fa-asterisk"></i>\r\n					<span>User Management</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://localhost/autofocus/user">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>User</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/permit">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Permission</span></a>\r\n					</li>\n<li >\r\n					<a href="http://localhost/autofocus/user_aproved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>user approved</span></a>\r\n					</li>\n</li>\n</ul></ul>";}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `side_menus`
--

CREATE TABLE IF NOT EXISTS `side_menus` (
`menu_id` int(11) NOT NULL,
  `menu_parent` int(11) DEFAULT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_url` varchar(50) DEFAULT NULL,
  `menu_weight` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `menu_level` int(11) DEFAULT NULL,
  `menu_active` varchar(1) DEFAULT NULL,
  `menu_icon` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34001 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `side_menus`
--

INSERT INTO `side_menus` (`menu_id`, `menu_parent`, `menu_name`, `menu_url`, `menu_weight`, `module_id`, `menu_level`, `menu_active`, `menu_icon`) VALUES
(18002, 18000, 'Permission', 'permit', 0, 20, 2, '1', ''),
(11000, 1, 'Master List', '#', 0, 0, 1, '1', 'fa-edit'),
(10000, 1, 'Dashboard', 'dashboard', 0, 1, 1, '0', 'fa-bar-chart-o'),
(13006, 13000, 'Status', 'transaction_status', 0, 0, 2, '1', ''),
(14002, 14000, 'Detail Per Mobil', 'po_received_report', 0, 14, 2, '1', ''),
(13003, 13000, 'Progress', 'transaction', 0, 0, 2, '1', ''),
(11014, 11000, 'Kategori Panel', 'product_category', 0, 4, 2, '0', ''),
(11004, 11000, 'Panel', 'product', 0, 5, 2, '1', ''),
(13000, 1, 'transaksi', '#', 0, 0, 1, '1', 'fa-shopping-cart'),
(13001, 13000, 'Registrasi', 'registration', 0, 9, 2, '1', ''),
(13004, 13000, 'Upload Foto', 'upload_photo', 0, 0, 2, '1', ''),
(18000, 1, 'User Management', '#', 0, 0, 1, '1', 'fa-asterisk'),
(18001, 18000, 'User', 'user', 0, 19, 2, '1', ''),
(14003, 14000, 'Laporan Stok', 'po_reservation_summary_report', 0, 15, 2, '0', ''),
(14001, 14000, 'Laporan Summary', 'summary_report', 0, 13, 2, '1', ''),
(14000, 1, 'Laporan', '1', 0, 0, 1, '1', 'fa-print'),
(11002, 11000, 'Asuransi', 'insurance', 0, 6, 2, '1', ''),
(13002, 13000, 'Persetujuan', 'approved', 0, 0, 2, '1', ''),
(18003, 18000, 'user approved', 'user_aproved', 0, 21, 2, '1', ''),
(14004, 14000, 'Gaji', 'salary_report', 0, 0, 2, '0', ''),
(11006, 11000, 'Harga Panel', 'price', 0, 0, 2, '1', ''),
(11007, 11000, 'Pelanggan', 'customer', 0, 0, 2, '1', ''),
(11008, 11000, 'Mobil', 'car', 0, 0, 2, '1', ''),
(11009, 11000, 'Cabang Bengkel', 'stand', 0, 0, 2, '1', ''),
(11010, 11000, 'Model Mobil', 'car_model', 0, 0, 2, '1', ''),
(11011, 11000, 'Pegawai', 'employee', 0, 23, 2, '1', ''),
(11012, 11000, 'Posisi Pegawai', 'employee_position', 0, 24, 2, '1', ''),
(11013, 11000, 'Stok Produk', 'stock', 0, 25, 2, '0', ''),
(11003, 11000, 'Harga Borongan', 'workshop_service', 0, 0, 2, '1', ''),
(13005, 13000, 'Pembayaran', 'payment', 0, 0, 2, '1', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stands`
--

CREATE TABLE IF NOT EXISTS `stands` (
`stand_id` int(11) NOT NULL,
  `stand_code` varchar(50) NOT NULL,
  `stand_name` varchar(200) DEFAULT NULL,
  `stand_leader` int(11) DEFAULT NULL COMMENT 'same as employeeid',
  `stand_description` text,
  `stand_pict` text,
  `stand_address` text,
  `stand_phone` varchar(50) DEFAULT NULL,
  `stand_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stands`
--

INSERT INTO `stands` (`stand_id`, `stand_code`, `stand_name`, `stand_leader`, `stand_description`, `stand_pict`, `stand_address`, `stand_phone`, `stand_status`) VALUES
(1, 'S0000001', 'Sidosermo', 1, 'Lokasi kantor pusat', NULL, 'Jl. Sidosermo 2 no. 72, Surabaya, East Java, Indonesia', '0819231323', 1),
(3, 'S0000002', 'Kedungturi', 1, 'Surabaya2', NULL, 'Surabaya2', '032131232', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
`transaction_id` int(11) NOT NULL,
  `employee_group_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `transaction_total` int(11) NOT NULL,
  `transaction_material_total` int(11) NOT NULL,
  `transaction_discount` int(11) NOT NULL,
  `transaction_plain_first_date` date NOT NULL,
  `transaction_plain_last_date` date NOT NULL,
  `transaction_actual_date` date NOT NULL,
  `transaction_target_date` date NOT NULL,
  `transaction_progress` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `employee_group_id`, `registration_id`, `transaction_total`, `transaction_material_total`, `transaction_discount`, `transaction_plain_first_date`, `transaction_plain_last_date`, `transaction_actual_date`, `transaction_target_date`, `transaction_progress`) VALUES
(7, 2, 6, 45000, 350000, 0, '2015-02-01', '2015-02-07', '2015-02-02', '2015-02-06', 100),
(8, 2, 7, 45000, 200000, 0, '2015-01-02', '2015-02-02', '2015-02-03', '2015-02-04', 100),
(9, 2, 8, 20000, 200000, 0, '2015-02-01', '2015-02-12', '2015-02-12', '2015-02-13', 100),
(10, 2, 9, 140000, 100000, 0, '2015-02-01', '2015-02-02', '2015-02-03', '2015-02-04', 100),
(11, 2, 11, 65000, 200000, 0, '2015-02-03', '2015-03-31', '2015-03-03', '2015-03-31', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_details`
--

CREATE TABLE IF NOT EXISTS `transaction_details` (
`transaction_detail_id` int(11) NOT NULL,
  `transaction_detail_description` varchar(100) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `transaction_detail_date` date NOT NULL,
  `transaction_detail_progress` int(11) NOT NULL,
  `workshop_service_id` int(11) NOT NULL,
  `workshop_service_price` int(11) NOT NULL,
  `workshop_service_job_price` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaction_details`
--

INSERT INTO `transaction_details` (`transaction_detail_id`, `transaction_detail_description`, `transaction_id`, `transaction_detail_date`, `transaction_detail_progress`, `workshop_service_id`, `workshop_service_price`, `workshop_service_job_price`) VALUES
(102, '', 7, '2015-02-04', 100, 1, 200000, 20000),
(101, '', 7, '2015-02-03', 100, 2, 250000, 25000),
(114, '', 8, '2015-02-10', 100, 2, 250000, 25000),
(113, '', 8, '2015-02-01', 100, 1, 200000, 20000),
(115, '', 9, '2015-02-12', 100, 1, 200000, 20000),
(116, '', 10, '2015-02-01', 100, 14, 300000, 30000),
(117, '', 10, '2015-02-02', 100, 98, 400000, 40000),
(118, '', 10, '2015-02-03', 100, 48, 400000, 40000),
(119, '', 10, '2015-02-04', 100, 12, 300000, 30000),
(122, '', 11, '2015-03-02', 100, 14, 300000, 30000),
(123, '', 11, '2015-03-04', 100, 89, 350000, 35000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_materials`
--

CREATE TABLE IF NOT EXISTS `transaction_materials` (
`tm_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `tm_name` varchar(100) NOT NULL,
  `tm_qty` varchar(11) NOT NULL,
  `tm_description` text NOT NULL,
  `tm_price` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaction_materials`
--

INSERT INTO `transaction_materials` (`tm_id`, `transaction_id`, `tm_name`, `tm_qty`, `tm_description`, `tm_price`) VALUES
(50, 7, 'Cat mahal', '3 liter', '', 300000),
(51, 7, 'Cat Murah', '1 L', '', 50000),
(57, 8, 'Cat avian', '2 L', 'Warna merah', 200000),
(58, 9, 'Cat Merah', '1 L', '', 200000),
(59, 10, 'Cat Mobil', '1 L', '', 100000),
(61, 11, 'Cat Mobil', '2 L', '', 200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_types`
--

CREATE TABLE IF NOT EXISTS `transaction_types` (
`transaction_type_id` int(11) NOT NULL,
  `transaction_type_name` varchar(100) NOT NULL,
  `transaction_type_price` int(11) NOT NULL,
  `transaction_type_description` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaction_types`
--

INSERT INTO `transaction_types` (`transaction_type_id`, `transaction_type_name`, `transaction_type_price`, `transaction_type_description`) VALUES
(1, 'Bongkar komponen', 100000, '-'),
(2, 'Las/Ketok', 50000, '-'),
(3, 'Dempul', 30000, '-'),
(4, 'Cat', 60000, '-'),
(5, 'Poles', 20000, '-'),
(6, 'Rakit', 200000, '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `user_login` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(50) NOT NULL,
  `job_title` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `user_password` varchar(32) DEFAULT NULL,
  `user_group_id` int(11) DEFAULT NULL,
  `user_last_login` datetime DEFAULT NULL,
  `user_registered` datetime DEFAULT NULL,
  `user_is_active` tinyint(1) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `user_is_login` int(11) NOT NULL,
  `expired_date` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_name`, `user_email`, `user_phone`, `job_title`, `company`, `user_password`, `user_group_id`, `user_last_login`, `user_registered`, `user_is_active`, `employee_id`, `user_is_login`, `expired_date`) VALUES
(1, 'admin', 'Administrator', '', '', '', '', 'cdaeb1282d614772beb1e74c192bebda', 1, NULL, NULL, 1, 1, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `workshop_services`
--

CREATE TABLE IF NOT EXISTS `workshop_services` (
`workshop_service_id` int(11) NOT NULL,
  `workshop_service_name` varchar(100) NOT NULL,
  `workshop_service_description` text NOT NULL,
  `workshop_service_price` int(11) NOT NULL,
  `workshop_service_job_price` int(11) NOT NULL,
  `workshop_service_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `workshop_service_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=226 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `workshop_services`
--

INSERT INTO `workshop_services` (`workshop_service_id`, `workshop_service_name`, `workshop_service_description`, `workshop_service_price`, `workshop_service_job_price`, `workshop_service_active_status`, `created_by_id`, `workshop_service_date`, `inactive_by_id`) VALUES
(1, 'Afron belakang (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(2, 'Afron belakang (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(3, 'Afron depan (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(4, 'Afron depan (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(5, 'All body berat (G + C)', '', 5600000, 560000, 1, 1, '2015-01-01', 0),
(6, 'All body berat (K + C)', '', 6300000, 630000, 1, 1, '2015-01-01', 0),
(7, 'All body ringan (K + C)', '', 5600000, 560000, 1, 1, '2015-01-01', 0),
(8, 'Bracker bumper (G + C)', '', 65000, 6500, 1, 1, '2015-01-01', 0),
(9, 'Bracker bumper (K + C)', '', 65000, 6500, 1, 1, '2015-01-01', 0),
(10, 'Bullhead (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(11, 'Bullhead (K + C)', '', 225000, 22500, 1, 1, '2015-01-01', 0),
(12, 'Bumper belakang (G + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(13, 'Bumper belakang (K + C)', '', 325000, 32500, 1, 1, '2015-01-01', 0),
(14, 'Bumper depan (G + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(15, 'Bumper depan (K + C)', '', 325000, 32500, 1, 1, '2015-01-01', 0),
(16, 'Chassis belakang (G + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(17, 'Chassis belakang (K + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(18, 'Chassis depan (G + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(19, 'Chassis depan (K + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(20, 'Cooling System (G + C)', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(21, 'Cooling System (K + C)', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(22, 'Cross member bawah radiator (G + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(23, 'Cross member bawah radiator (K + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(24, 'Dashboard (G + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(25, 'Electric System (G + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(26, 'Ext fender (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(27, 'Ext fender (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(28, 'Ext. bumper (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(29, 'Ext. bumper (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(30, 'Fender / Spackboard depan (G + C)', '', 350000, 35000, 1, 1, '2015-01-01', 0),
(31, 'Fender / Spackboard depan (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(32, 'Foot step (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(33, 'Foot step (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(34, 'Gardan (K + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(35, 'Garnish / Spoiler (G + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(36, 'Garnish / Spoiler (K + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(37, 'Grill (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(38, 'Grill (K + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(39, 'Handle Pintu (K + C)', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(40, 'Handle Pintu (K + C)', '', 75000, 7500, 1, 1, '2015-01-01', 0),
(41, 'Inner Bumper (K + C)', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(42, 'Interior (G + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(43, 'Interior (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(44, 'Kaca belakang (G + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(45, 'Kaca depan (G + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(46, 'Kaca samping (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(47, 'Kap bagasi (G + C)', '', 350000, 35000, 1, 1, '2015-01-01', 0),
(48, 'Kap bagasi (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(49, 'Kap Motor (G + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(50, 'Kap Motor (K + C)', '', 450000, 45000, 1, 1, '2015-01-01', 0),
(51, 'Kedok depan (G + C)', '', 350000, 35000, 1, 1, '2015-01-01', 0),
(52, 'Kedok depan (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(53, 'Knalpot (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(54, 'Knalpot (K + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(55, 'Lantai bagasi (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(56, 'Lantai bagasi (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(57, 'Lantai belakang/dak belakang (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(58, 'Lantai belakang/dak belakang (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(59, 'Lantai depan (dek depan) (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(60, 'Lantai depan (dek depan) (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(61, 'Lantai tengah (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(62, 'Lantai tengah (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(63, 'List body pintu (G + C)', '', 75000, 7500, 1, 1, '2015-01-01', 0),
(64, 'List body pintu (K + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(65, 'Lock Kap Motor (G + C)', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(66, 'Lock Kap Motor (K + C)', '', 80000, 8000, 1, 1, '2015-01-01', 0),
(67, 'Mesin (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(68, 'Mudguard/penahan lumpur (G + C)', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(69, 'Naik / Turun body (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(70, 'Naik turun mesin (K + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(71, 'Panel Atas Bumper belakang (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(72, 'Panel Atas Bumper belakang (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(73, 'Panel Atas Bumper depan (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(74, 'Panel Atas Bumper depan (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(75, 'Panel Atas Radiator (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(76, 'Panel Atas Radiator (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(77, 'Panel Bagasi (G + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(78, 'Panel Bagasi (K + C)', '', 175000, 17500, 1, 1, '2015-01-01', 0),
(79, 'Panel Bawah Bumper belakang (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(80, 'Panel Bawah Bumper belakang (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(81, 'Panel Bawah Bumper depan (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(82, 'Panel Bawah Bumper depan (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(83, 'Panel bawah kaca belakang (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(84, 'Panel bawah kaca belakang (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(85, 'Panel bawah Kaca depan (cowl) (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(86, 'Panel bawah Kaca depan (cowl) (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(87, 'Panel Bawah Radiator (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(88, 'Panel Bawah Radiator (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(89, 'Panel belakang (pintu mati) (G + C)', '', 350000, 35000, 1, 1, '2015-01-01', 0),
(90, 'Panel belakang (pintu mati) (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(91, 'Panel belakang mesin (G + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(92, 'Panel belakang mesin (K + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(93, 'Panel depan mesin (G + C)', '', 250000, 25000, 1, 1, '2015-01-01', 0),
(94, 'Panel depan mesin (K + C)', '', 300000, 30000, 1, 1, '2015-01-01', 0),
(95, 'Panel lampu stop (G + C)', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(96, 'Panel lampu stop (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(97, 'Pintu belakan (G + C)', '', 375000, 37500, 1, 1, '2015-01-01', 0),
(98, 'Pintu belakan (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(99, 'Pintu belakang bagasi (minibus) (G + C)', '', 375000, 37500, 1, 1, '2015-01-01', 0),
(100, 'Pintu belakang bagasi (minibus) (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(101, 'Pintu depan (G + C)', '', 375000, 37500, 1, 1, '2015-01-01', 0),
(102, 'Pintu depan (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(103, 'Panel Pipi (G + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(104, 'Panel Pipi (K + C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(105, 'Plafond (G + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(106, 'Plafond (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(107, 'Radiator', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(108, 'Roof (G + C)', '', 450000, 45000, 1, 1, '2015-01-01', 0),
(109, 'Roof (K + C)', '', 500000, 50000, 1, 1, '2015-01-01', 0),
(110, 'Spackboard belakang (no pintu) (G + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(111, 'Spackboard belakang (no pintu) (K + C)', '', 450000, 45000, 1, 1, '2015-01-01', 0),
(112, 'Spackboard belakang / quarter panel (G + C)', '', 375000, 37500, 1, 1, '2015-01-01', 0),
(113, 'Spackboard belakang / quarter panel (K + C)', '', 400000, 40000, 1, 1, '2015-01-01', 0),
(114, 'Spion (G + C)', '', 60000, 6000, 1, 1, '2015-01-01', 0),
(115, 'Spion (K + C)', '', 80000, 8000, 1, 1, '2015-01-01', 0),
(116, 'Steering system (K + C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(117, 'Suspensi System (G + C)', '', 92000, 9200, 1, 1, '2015-01-01', 0),
(118, 'Talang air (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(119, 'Talang air (K + C)', '', 225000, 22500, 1, 1, '2015-01-01', 0),
(120, 'Tarik chassis total (car O line) (K + C)', '', 1500000, 150000, 1, 1, '2015-01-01', 0),
(121, 'Tiang kaca belakang (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(122, 'Tiang kaca belakang (K + C)', '', 225000, 22500, 1, 1, '2015-01-01', 0),
(123, 'Tiang kaca depan (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(124, 'Tiang kaca depan (K + C)', '', 225000, 22500, 1, 1, '2015-01-01', 0),
(125, 'Tiang pintu tengah (pilar) (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(126, 'Tiang pintu tengah (pilar) (K + C)', '', 225000, 22500, 1, 1, '2015-01-01', 0),
(127, 'Triplang (G + C)', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(128, 'Triplang  (K + C)', '', 225000, 22500, 1, 1, '2015-01-01', 0),
(129, 'Tutup bensin (K + C)', '', 50000, 5000, 1, 1, '2015-01-01', 0),
(130, 'Tanduk (G+C)', '', 125000, 12500, 1, 1, '2015-01-01', 0),
(131, 'Tanduk (K+C)', '', 150000, 15000, 1, 1, '2015-01-01', 0),
(132, 'Velg', '', 100000, 10000, 1, 1, '2015-01-01', 0),
(133, 'Bumper depan bawah', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(134, 'Bumper depan bawah', '', 200000, 20000, 1, 1, '2015-01-01', 0),
(135, 'Tutup ban serep', '', 100000, 10000, 1, 1, '2015-01-01', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
 ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `car_models`
--
ALTER TABLE `car_models`
 ADD PRIMARY KEY (`car_model_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
 ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `detail_registrations`
--
ALTER TABLE `detail_registrations`
 ADD PRIMARY KEY (`detail_registration_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
 ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_groups`
--
ALTER TABLE `employee_groups`
 ADD PRIMARY KEY (`employee_group_id`);

--
-- Indexes for table `employee_group_histories`
--
ALTER TABLE `employee_group_histories`
 ADD PRIMARY KEY (`employee_group_history_id`);

--
-- Indexes for table `employee_group_items`
--
ALTER TABLE `employee_group_items`
 ADD PRIMARY KEY (`employee_group_item_id`);

--
-- Indexes for table `employee_positions`
--
ALTER TABLE `employee_positions`
 ADD PRIMARY KEY (`employee_position_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
 ADD PRIMARY KEY (`insurance_id`);

--
-- Indexes for table `log_data`
--
ALTER TABLE `log_data`
 ADD PRIMARY KEY (`log_data_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
 ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
 ADD PRIMARY KEY (`period_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
 ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `photo_types`
--
ALTER TABLE `photo_types`
 ADD PRIMARY KEY (`photo_type_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_histories`
--
ALTER TABLE `product_histories`
 ADD PRIMARY KEY (`product_history_id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
 ADD PRIMARY KEY (`product_price_id`);

--
-- Indexes for table `product_process`
--
ALTER TABLE `product_process`
 ADD PRIMARY KEY (`product_process_id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
 ADD PRIMARY KEY (`product_stock_id`);

--
-- Indexes for table `product_sub_type`
--
ALTER TABLE `product_sub_type`
 ADD PRIMARY KEY (`pst_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
 ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
 ADD PRIMARY KEY (`registration_id`);

--
-- Indexes for table `registration_spareparts`
--
ALTER TABLE `registration_spareparts`
 ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `side_menus`
--
ALTER TABLE `side_menus`
 ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `stands`
--
ALTER TABLE `stands`
 ADD PRIMARY KEY (`stand_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
 ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
 ADD PRIMARY KEY (`transaction_detail_id`);

--
-- Indexes for table `transaction_materials`
--
ALTER TABLE `transaction_materials`
 ADD PRIMARY KEY (`tm_id`);

--
-- Indexes for table `transaction_types`
--
ALTER TABLE `transaction_types`
 ADD PRIMARY KEY (`transaction_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `workshop_services`
--
ALTER TABLE `workshop_services`
 ADD PRIMARY KEY (`workshop_service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `car_models`
--
ALTER TABLE `car_models`
MODIFY `car_model_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `detail_registrations`
--
ALTER TABLE `detail_registrations`
MODIFY `detail_registration_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=600012;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `employee_groups`
--
ALTER TABLE `employee_groups`
MODIFY `employee_group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employee_group_histories`
--
ALTER TABLE `employee_group_histories`
MODIFY `employee_group_history_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_group_items`
--
ALTER TABLE `employee_group_items`
MODIFY `employee_group_item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `employee_positions`
--
ALTER TABLE `employee_positions`
MODIFY `employee_position_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `log_data`
--
ALTER TABLE `log_data`
MODIFY `log_data_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
MODIFY `period_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `photo_types`
--
ALTER TABLE `photo_types`
MODIFY `photo_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `product_histories`
--
ALTER TABLE `product_histories`
MODIFY `product_history_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
MODIFY `product_price_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `product_process`
--
ALTER TABLE `product_process`
MODIFY `product_process_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
MODIFY `product_stock_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_sub_type`
--
ALTER TABLE `product_sub_type`
MODIFY `pst_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `registration_spareparts`
--
ALTER TABLE `registration_spareparts`
MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `side_menus`
--
ALTER TABLE `side_menus`
MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34001;
--
-- AUTO_INCREMENT for table `stands`
--
ALTER TABLE `stands`
MODIFY `stand_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
MODIFY `transaction_detail_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `transaction_materials`
--
ALTER TABLE `transaction_materials`
MODIFY `tm_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `transaction_types`
--
ALTER TABLE `transaction_types`
MODIFY `transaction_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `workshop_services`
--
ALTER TABLE `workshop_services`
MODIFY `workshop_service_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=226;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
