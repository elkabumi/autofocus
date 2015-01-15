-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 15, 2015 at 11:45 
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autofocus`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `car_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_nopol` varchar(100) NOT NULL,
  `car_model_id` int(11) NOT NULL,
  `car_no_machine` varchar(100) NOT NULL,
  `car_no_rangka` varchar(100) NOT NULL,
  `car_color` varchar(100) NOT NULL,
  `car_type` varchar(50) NOT NULL,
  `car_year` varchar(4) NOT NULL,
  `car_description` text NOT NULL,
  PRIMARY KEY (`car_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_nopol`, `car_model_id`, `car_no_machine`, `car_no_rangka`, `car_color`, `car_type`, `car_year`, `car_description`) VALUES
(1, 'W 6082 TZ', 1, '123', '456', 'Hitam', 'City Car', '', 'ok'),
(3, 'L 6973 TU', 1, '5745645', '34234234', 'Putih', 'City Car', '', ''),
(4, 'L 6004 TY', 1, '2143254', '2523523', 'Hitam', 'City car', '2000', ''),
(5, 'W 3534 WL', 2, '234rrr', '234234rrr', 'Putih', 'Sedang', '2003', '');

-- --------------------------------------------------------

--
-- Table structure for table `car_models`
--

CREATE TABLE IF NOT EXISTS `car_models` (
  `car_model_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_model_merk` varchar(100) NOT NULL,
  `car_model_name` varchar(100) NOT NULL,
  `car_model_description` text NOT NULL,
  PRIMARY KEY (`car_model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `car_models`
--

INSERT INTO `car_models` (`car_model_id`, `car_model_merk`, `car_model_name`, `car_model_description`) VALUES
(1, 'Daihatsu', 'Xenia', ''),
(2, 'Suzuki', 'Ertiga', '');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_ktp_number` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_addres` varchar(100) NOT NULL,
  `customer_phone_number` varchar(100) NOT NULL,
  `customer_hp` varchar(50) NOT NULL,
  `customer_description` text NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_ktp_number`, `customer_name`, `customer_addres`, `customer_phone_number`, `customer_hp`, `customer_description`) VALUES
(1, '666 777 999 ', 'Candra Dwi Prasetyo', '', '', '', ''),
(2, '35345345', 'Andri Febri', 'Mojokerto', '08534535', '0534634545345', '');

-- --------------------------------------------------------

--
-- Table structure for table `detail_registrations`
--

CREATE TABLE IF NOT EXISTS `detail_registrations` (
  `detail_registration_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `detail_registration_type_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `product_price_id` int(11) NOT NULL,
  `detail_registration_ panel_damage` varchar(100) NOT NULL,
  `detail_registration_qty` int(11) NOT NULL,
  `detail_registration_price` int(11) NOT NULL,
  `detail_registration_total_price` int(11) NOT NULL,
  `detail_registration_start_date` date NOT NULL,
  `detail_registration_completed_date` date NOT NULL,
  `detail_registration_status` int(11) NOT NULL,
  `detail_registration_description` text NOT NULL,
  PRIMARY KEY (`detail_registration_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `detail_registrations`
--

INSERT INTO `detail_registrations` (`detail_registration_id`, `registration_id`, `detail_registration_type_id`, `employee_id`, `product_price_id`, `detail_registration_ panel_damage`, `detail_registration_qty`, `detail_registration_price`, `detail_registration_total_price`, `detail_registration_start_date`, `detail_registration_completed_date`, `detail_registration_status`, `detail_registration_description`) VALUES
(1, 2, 1, 1, 2, '', 1, 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(2, 2, 1, 1, 3, '', 1, 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(3, 3, 1, 1, 4, '', 1, 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(4, 3, 1, 1, 8, '', 1, 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(5, 4, 1, 1, 3, '', 1, 600000, 600000, '0000-00-00', '0000-00-00', 0, ''),
(6, 5, 1, 1, 4, '', 1, 900000, 900000, '0000-00-00', '0000-00-00', 0, ''),
(7, 6, 1, 1, 7, '', 1, 800000, 800000, '0000-00-00', '0000-00-00', 0, ''),
(8, 7, 1, 1, 5, '', 1, 200000, 200000, '0000-00-00', '0000-00-00', 0, ''),
(9, 7, 1, 1, 8, '', 1, 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(10, 8, 1, 1, 5, '', 1, 200000, 200000, '0000-00-00', '0000-00-00', 0, ''),
(11, 8, 1, 1, 8, '', 1, 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(12, 9, 1, 1, 2, '', 1, 300000, 300000, '0000-00-00', '0000-00-00', 0, ''),
(13, 9, 1, 1, 13, '', 1, 100000, 100000, '0000-00-00', '0000-00-00', 0, ''),
(14, 10, 1, 1, 2, '', 1, 300000, 300000, '0000-00-00', '0000-00-00', 0, ''),
(15, 10, 1, 1, 5, '', 1, 200000, 200000, '0000-00-00', '0000-00-00', 0, ''),
(16, 10, 1, 1, 11, '', 1, 120000, 120000, '0000-00-00', '0000-00-00', 0, ''),
(17, 10, 1, 1, 14, '', 1, 220000, 220000, '0000-00-00', '0000-00-00', 0, ''),
(18, 11, 1, 1, 2, '', 1, 300000, 300000, '0000-00-00', '0000-00-00', 0, ''),
(19, 11, 1, 1, 11, '', 1, 120000, 120000, '0000-00-00', '0000-00-00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `employee_pic` mediumtext,
  PRIMARY KEY (`employee_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_nip`, `employee_name`, `employee_birth`, `employee_gender`, `employee_position_id`, `employee_ktp`, `employee_address`, `employee_phone`, `employee_email`, `employee_bank_number`, `employee_bank_name`, `employee_bank_beneficiary`, `employee_active_status`, `employee_pic`) VALUES
(1, NULL, 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL),
(19, 'E0000001', 'Sangkan', '1974-01-23', 1, 2, '890910002', 'surabaya', '0876287181', 'sangkan@yahoo.com', '456787686', 'BCA', 'sangkan', '1', NULL),
(20, 'E0000002', 'paijo', '2014-12-01', 1, 2, '1212121', '-', '353535', 'paijo@gmail.com', '123456788', 'bca', 'paijo', '1', NULL),
(21, 'E0000003', 'supali', '2014-12-24', 2, 3, '575757', 'adoh', '53543545', 'supali@yahoo.co.id', '09876543', 'mandiri', 'supali', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_groups`
--

CREATE TABLE IF NOT EXISTS `employee_groups` (
  `employee_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_group_name` varchar(100) NOT NULL,
  `employee_group_description` varchar(100) NOT NULL,
  PRIMARY KEY (`employee_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employee_groups`
--

INSERT INTO `employee_groups` (`employee_group_id`, `employee_group_name`, `employee_group_description`) VALUES
(2, 'Group 2', 'sementara');

-- --------------------------------------------------------

--
-- Table structure for table `employee_group_histories`
--

CREATE TABLE IF NOT EXISTS `employee_group_histories` (
  `employee_group_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_group_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `employee_group_histories`
--


-- --------------------------------------------------------

--
-- Table structure for table `employee_group_items`
--

CREATE TABLE IF NOT EXISTS `employee_group_items` (
  `employee_group_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_group_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_group_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `employee_group_items`
--

INSERT INTO `employee_group_items` (`employee_group_item_id`, `employee_group_id`, `employee_id`) VALUES
(4, 1, 19),
(2, 2, 20),
(3, 2, 21),
(5, 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `employee_positions`
--

CREATE TABLE IF NOT EXISTS `employee_positions` (
  `employee_position_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_position_name` varchar(100) NOT NULL,
  `employee_position_description` varchar(100) NOT NULL,
  PRIMARY KEY (`employee_position_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employee_positions`
--

INSERT INTO `employee_positions` (`employee_position_id`, `employee_position_name`, `employee_position_description`) VALUES
(1, 'Sekretaris', ''),
(2, 'Otomotif', ''),
(3, 'Manager', '');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) DEFAULT NULL,
  `group_is_active` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_is_active`) VALUES
(1, 'Administrator', '1');

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE IF NOT EXISTS `insurances` (
  `insurance_id` int(11) NOT NULL AUTO_INCREMENT,
  `insurance_name` varchar(100) NOT NULL,
  `insurance_addres` varchar(100) NOT NULL,
  `insurance_phone` varchar(100) NOT NULL,
  `insurance_description` text NOT NULL,
  `insurance_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `insurance_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  PRIMARY KEY (`insurance_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `insurances`
--

INSERT INTO `insurances` (`insurance_id`, `insurance_name`, `insurance_addres`, `insurance_phone`, `insurance_description`, `insurance_active_status`, `created_by_id`, `insurance_date`, `inactive_by_id`) VALUES
(4, 'Autocillin', '-', '-', '', 1, 1, '2014-11-24', 0),
(1, 'Pribadi', '-', '-', '', 1, 1, '2014-11-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log_action_types`
--

CREATE TABLE IF NOT EXISTS `log_action_types` (
  `log_action_type_id` int(11) DEFAULT NULL,
  `log_action_type_name` varchar(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_action_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `log_data`
--

CREATE TABLE IF NOT EXISTS `log_data` (
  `log_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_data_time` datetime DEFAULT NULL,
  `log_data_module_id` int(11) DEFAULT NULL,
  `log_data_ip` varchar(254) DEFAULT NULL,
  `log_data_user_id` int(11) DEFAULT NULL,
  `log_data_type` smallint(6) DEFAULT NULL,
  `log_data_data_id` int(11) DEFAULT NULL,
  `log_data_remark` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`log_data_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `log_data`
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
(33, '2015-01-05 15:01:03', 25, '127.0.0.1', 1, 2, 3, 'Produk');

-- --------------------------------------------------------

--
-- Table structure for table `log_sys`
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
-- Dumping data for table `log_sys`
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
('2015-01-05 15:01:11', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit');

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE IF NOT EXISTS `markets` (
  `market_id` int(11) NOT NULL,
  `market_code` varchar(100) NOT NULL,
  `market_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`market_id`, `market_code`, `market_name`) VALUES
(1, 'C0000001', 'Kantor Pusat'),
(3, 'S0000002', 'Cabang 2');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_code` varchar(50) DEFAULT NULL,
  `module_name` varchar(40) DEFAULT NULL,
  `module_approval_url` varchar(50) DEFAULT NULL,
  `module_group` varchar(50) DEFAULT NULL,
  `module_view_url` varchar(50) DEFAULT NULL,
  `module_cancel_url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `modules`
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
-- Table structure for table `periods`
--

CREATE TABLE IF NOT EXISTS `periods` (
  `period_id` int(11) NOT NULL AUTO_INCREMENT,
  `period_code` varchar(100) NOT NULL,
  `period_name` varchar(100) NOT NULL,
  `period_month` varchar(2) NOT NULL,
  `period_year` varchar(4) NOT NULL,
  `period_closed` int(11) NOT NULL,
  `period_description` text NOT NULL,
  PRIMARY KEY (`period_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `periods`
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
-- Table structure for table `permits`
--

CREATE TABLE IF NOT EXISTS `permits` (
  `permit_group_id` int(11) DEFAULT NULL,
  `permit_module_id` int(11) DEFAULT NULL,
  `permit_crud_mode` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permits`
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
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(100) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `product_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `product_category_id`, `insurance_id`, `product_name`, `product_qty`, `product_description`, `product_active_status`, `created_by_id`, `product_date`, `inactive_by_id`) VALUES
(2, '0', 2, 4, 'High beam', 0, '', 1, 1, '2014-11-24', 0),
(3, 'A00004', 1, 4, 'Low Beam', 0, '', 1, 1, '2014-11-24', 0),
(4, 'A00005', 1, 1, 'Bemper Depan', 0, '', 1, 1, '2014-11-24', 0),
(5, 'AC0003', 1, 4, 'AC dalam', 0, '-', 1, 1, '2014-12-17', 0),
(6, '1', 1, 4, '1', 0, '', 1, 1, '2014-12-26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_name` varchar(100) NOT NULL,
  `product_category_description` text NOT NULL,
  `product_category_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `product_categories_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  PRIMARY KEY (`product_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`product_category_id`, `product_category_name`, `product_category_description`, `product_category_active_status`, `created_by_id`, `product_categories_date`, `inactive_by_id`) VALUES
(1, 'sperpart', '', 1, 1, '2014-11-12', 1),
(2, 'jasa', '', 1, 1, '2014-11-12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_histories`
--

CREATE TABLE IF NOT EXISTS `product_histories` (
  `product_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_history_type` int(11) NOT NULL,
  `product_history_date` datetime NOT NULL,
  `product_history_qty` int(11) NOT NULL,
  `product_history_stock` int(11) NOT NULL,
  `product_history_description` text NOT NULL,
  PRIMARY KEY (`product_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `product_histories`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE IF NOT EXISTS `product_prices` (
  `product_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `pst_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  PRIMARY KEY (`product_price_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `product_prices`
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
(38, 6, 7, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_process`
--

CREATE TABLE IF NOT EXISTS `product_process` (
  `product_process_id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_process_booking_date` date NOT NULL,
  `product_process_comming_date` date NOT NULL,
  `product_process_status` int(11) NOT NULL,
  `product_process_description` text NOT NULL,
  PRIMARY KEY (`product_process_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `product_process`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE IF NOT EXISTS `product_stocks` (
  `product_stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_stock_kode` varchar(50) NOT NULL,
  `product_stock_name` varchar(100) NOT NULL,
  `product_stock_jumlah` int(11) NOT NULL,
  `product_stock_description` varchar(20) NOT NULL,
  PRIMARY KEY (`product_stock_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `product_stocks`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_sub_type`
--

CREATE TABLE IF NOT EXISTS `product_sub_type` (
  `pst_id` int(11) NOT NULL AUTO_INCREMENT,
  `insurance_id` int(11) NOT NULL,
  `pst_name` varchar(100) NOT NULL,
  `pst_description` text NOT NULL,
  PRIMARY KEY (`pst_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `product_sub_type`
--

INSERT INTO `product_sub_type` (`pst_id`, `insurance_id`, `pst_name`, `pst_description`) VALUES
(9, 4, 'Replace', '    '),
(8, 4, 'Repair', '    '),
(7, 4, 'Incentive', '    '),
(6, 1, 'normal', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE IF NOT EXISTS `product_types` (
  `product_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `insurance_id` int(11) NOT NULL,
  `product_type_name` varchar(100) NOT NULL,
  `product_type_desc` text NOT NULL,
  PRIMARY KEY (`product_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`product_type_id`, `insurance_id`, `product_type_name`, `product_type_desc`) VALUES
(9, 4, 'Car Type C', '-'),
(8, 4, 'Car type B', '-'),
(7, 4, 'Car Type A', '-'),
(6, 1, 'normal', '-');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE IF NOT EXISTS `registrations` (
  `registration_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `total_registration` int(11) NOT NULL,
  `status_registration_id` int(11) NOT NULL,
  `registration_description` longtext NOT NULL,
  `own_retention` int(11) NOT NULL,
  `pic_asuransi` varchar(100) NOT NULL,
  `spk_date` date NOT NULL,
  PRIMARY KEY (`registration_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registration_id`, `registration_code`, `period_id`, `stand_id`, `customer_id`, `car_id`, `employee_id`, `incident_date`, `claim_type`, `insurance_id`, `claim_no`, `spk_no`, `pkb_no`, `check_in`, `registration_estimation_date`, `check_out`, `registration_date`, `total_registration`, `status_registration_id`, `registration_description`, `own_retention`, `pic_asuransi`, `spk_date`) VALUES
(3, 'T0000002', 11, 1, 1, 1, 1, '0000-00-00', 1, 4, '123456', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '2014-11-24', 200000, 2, 'ok', 0, '', '0000-00-00'),
(2, 'T0000001', 11, 1, 1, 1, 1, '0000-00-00', 1, 4, '123', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 200000, 2, 'ok', 0, '', '0000-00-00'),
(4, 'T0000003', 11, 1, 2, 5, 1, '0000-00-00', 1, 4, '34234234', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '2014-11-28', 600000, 1, '-', 0, '', '0000-00-00'),
(5, 'T0000004', 11, 1, 1, 3, 1, '0000-00-00', 1, 4, '234234234', '', '', '2014-11-28', '2014-11-29', '0000-00-00', '2014-11-28', 900000, 2, '-', 0, '', '0000-00-00'),
(6, 'T0000005', 11, 1, 1, 3, 1, '0000-00-00', 1, 4, '12314124', '54353453', '65654655', '2014-11-28', '2014-11-29', '0000-00-00', '2014-11-28', 800000, 1, '', 200000, 'Agus Salim', '2014-11-29'),
(7, 'T0000006', 11, 1, 1, 5, 1, '0000-00-00', 1, 4, '9090909', '91919191', '929292929', '2014-11-28', '2014-11-30', '0000-00-00', '2014-11-28', 300000, 2, '-', 3, 'sabar', '2014-11-30'),
(8, 'T0000007', 11, 1, 1, 5, 1, '0000-00-00', 1, 4, '00000009', '00000009', '00000009', '2014-11-28', '2014-11-30', '0000-00-00', '2014-11-28', 300000, 1, '-', 9, 'riduwan', '2014-11-30'),
(9, 'T0000008', 11, 1, 1, 5, 1, '0000-00-00', 1, 4, '1111', '1111', '1111', '2014-12-04', '2014-12-31', '0000-00-00', '2014-12-04', 400000, 2, '-', 1111, '1111', '2014-12-30'),
(10, 'T0000009', 11, 3, 1, 4, 1, '0000-00-00', 1, 4, '2222', '2222', '2222', '2014-12-04', '2014-12-17', '0000-00-00', '2014-12-04', 840000, 2, '-', 2222, '2222', '2014-12-31'),
(11, 'R0000001', 11, 1, 1, 3, 1, '0000-00-00', 1, 4, '8787', '8787', '78778', '2014-12-29', '2014-12-02', '0000-00-00', '2014-12-29', 420000, 2, '1', 78787, '8787', '2014-12-08');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) DEFAULT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `user_agent` varchar(50) DEFAULT NULL,
  `last_activity` int(11) DEFAULT NULL,
  `user_data` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('474d329521493a04a7f04aff2c1b286b', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.2; rv:34.0) Gecko/201001', 1420613797, 'a:4:{s:6:"logged";i:1;s:9:"user_info";a:19:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:10:"user_email";s:0:"";s:10:"user_phone";s:0:"";s:9:"job_title";s:0:"";s:7:"company";s:0:"";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:12:"expired_date";s:10:"0000-00-00";s:12:"employee_pic";N;s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1420445231;s:7:"menubar";s:4724:"<ul class="sidebar-menu"><li >\r\n					<a href="http://127.0.0.1/autofocus/dashboard">\r\n					<i class="fa fa-bar-chart-o"></i>\r\n					<span>Dashboard</span></a>\r\n					</li>\n<li  class="treeview">\r\n					<a href="http://127.0.0.1/autofocus/#">\r\n					<i class="fa fa-edit"></i>\r\n					<span>Master List</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://127.0.0.1/autofocus/insurance">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Asuransi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/product_category">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Kategori Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/product">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/price">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Harga Panel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/customer">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pelanggan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/car">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/stand">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Cabang Bengkel</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/car_model">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Model Mobil</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/employee">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Pegawai</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/employee_position">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Posisi Pegawai</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/stock">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Stok Produk</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://127.0.0.1/autofocus/#">\r\n					<i class="fa fa-shopping-cart"></i>\r\n					<span>transaksi</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://127.0.0.1/autofocus/registration">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Registrasi</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/approved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Persetujuan</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/transaction">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Transaksi</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://127.0.0.1/autofocus/1">\r\n					<i class="fa fa-print"></i>\r\n					<span>Laporan</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://127.0.0.1/autofocus/po_received_summary_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>trnasaction</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/po_received_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>transaction detail</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/po_reservation_summary_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>transaction summary</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/po_reservation_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>transaction range tanggal</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/material_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Material </span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/site_report">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Site</span></a>\r\n					</li>\n</li>\n</ul><li  class="treeview">\r\n					<a href="http://127.0.0.1/autofocus/#">\r\n					<i class="fa fa-asterisk"></i>\r\n					<span>User Management</span><i class="fa fa-angle-left pull-right"></i></a>\r\n					<ul class="treeview-menu"><li >\r\n					<a href="http://127.0.0.1/autofocus/user">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>User</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/permit">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>Permission</span></a>\r\n					</li>\n<li >\r\n					<a href="http://127.0.0.1/autofocus/user_aproved">\r\n					<i class="fa fa-chevron-circle-right"></i>\r\n					<span>user approved</span></a>\r\n					</li>\n</li>\n</ul></ul>";}'),
('4a7f8be3b378e0c9098499ef5a85cd76', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (K', 1420448033, 'a:1:{s:5:"redir";a:1:{s:9:"redir_url";s:10:"stock/form";}}'),
('b8e9ec727b3c56ba74437dd1f78986b8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.2; rv:34.0) Gecko/201001', 1420623636, NULL),
('2f4cad7eec4727f7f0e1f765282da470', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (K', 1420178367, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `side_menus`
--

CREATE TABLE IF NOT EXISTS `side_menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_parent` int(11) DEFAULT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_url` varchar(50) DEFAULT NULL,
  `menu_weight` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `menu_level` int(11) DEFAULT NULL,
  `menu_active` varchar(1) DEFAULT NULL,
  `menu_icon` text NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34001 ;

--
-- Dumping data for table `side_menus`
--

INSERT INTO `side_menus` (`menu_id`, `menu_parent`, `menu_name`, `menu_url`, `menu_weight`, `module_id`, `menu_level`, `menu_active`, `menu_icon`) VALUES
(18002, 18000, 'Permission', 'permit', 0, 20, 2, '1', ''),
(11000, 1, 'Master List', '#', 0, 0, 1, '1', 'fa-edit'),
(10000, 1, 'Dashboard', 'dashboard', 0, 1, 1, '1', 'fa-bar-chart-o'),
(14007, 14000, 'Material ', 'material_report', 0, 18, 2, '1', ''),
(14002, 14000, 'transaction detail', 'po_received_report', 0, 14, 2, '1', ''),
(13003, 13000, 'Transaksi', 'transaction', 0, 0, 2, '1', ''),
(11003, 11000, 'Kategori Panel', 'product_category', 0, 4, 2, '1', ''),
(11004, 11000, 'Panel', 'product', 0, 5, 2, '1', ''),
(13000, 1, 'transaksi', '#', 0, 0, 1, '1', 'fa-shopping-cart'),
(13001, 13000, 'Registrasi', 'registration', 0, 9, 2, '1', ''),
(14004, 14000, 'transaction range tanggal', 'po_reservation_report', 0, 16, 2, '1', ''),
(18000, 1, 'User Management', '#', 0, 0, 1, '1', 'fa-asterisk'),
(18001, 18000, 'User', 'user', 0, 19, 2, '1', ''),
(14003, 14000, 'transaction summary', 'po_reservation_summary_report', 0, 15, 2, '1', ''),
(14001, 14000, 'trnasaction', 'po_received_summary_report', 0, 13, 2, '1', ''),
(14000, 1, 'Laporan', '1', 0, 0, 1, '1', 'fa-print'),
(11002, 11000, 'Asuransi', 'insurance', 0, 6, 2, '1', ''),
(13002, 13000, 'Persetujuan', 'approved', 0, 0, 2, '1', ''),
(18003, 18000, 'user approved', 'user_aproved', 0, 21, 2, '1', ''),
(14008, 14000, 'Site', 'site_report', 0, 22, 2, '1', ''),
(11006, 11000, 'Harga Panel', 'price', 0, 0, 2, '1', ''),
(11007, 11000, 'Pelanggan', 'customer', 0, 0, 2, '1', ''),
(11008, 11000, 'Mobil', 'car', 0, 0, 2, '1', ''),
(11009, 11000, 'Cabang Bengkel', 'stand', 0, 0, 2, '1', ''),
(11010, 11000, 'Model Mobil', 'car_model', 0, 0, 2, '1', ''),
(11011, 11000, 'Pegawai', 'employee', 0, 23, 2, '1', ''),
(11012, 11000, 'Posisi Pegawai', 'employee_position', 0, 24, 2, '1', ''),
(11013, 11000, 'Stok Produk', 'stock', 0, 25, 2, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `stands`
--

CREATE TABLE IF NOT EXISTS `stands` (
  `stand_id` int(11) NOT NULL AUTO_INCREMENT,
  `stand_code` varchar(50) NOT NULL,
  `stand_name` varchar(200) DEFAULT NULL,
  `stand_leader` int(11) DEFAULT NULL COMMENT 'same as employeeid',
  `stand_description` text,
  `stand_pict` text,
  `stand_address` text,
  `stand_phone` varchar(50) DEFAULT NULL,
  `stand_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`stand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stands`
--

INSERT INTO `stands` (`stand_id`, `stand_code`, `stand_name`, `stand_leader`, `stand_description`, `stand_pict`, `stand_address`, `stand_phone`, `stand_status`) VALUES
(1, 'S0000001', 'Kantor Pusat', 2, 'Lokasi kantor pusat', NULL, 'Bandung', '0819231323', 1),
(3, 'S0000002', 'Cabang 2', 1, 'Surabaya2', NULL, 'Surabaya2', '032131232', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_group_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `transaction_total` int(11) NOT NULL,
  `transaction_plain_first_date` date NOT NULL,
  `transaction_plain_last_date` date NOT NULL,
  `transaction_actual_date` date NOT NULL,
  `transaction_target_date` date NOT NULL,
  `transaction_komponen` varchar(100) NOT NULL,
  `transaction_lasketok` varchar(100) NOT NULL,
  `transaction_dempul` varchar(100) NOT NULL,
  `transaction_cat` varchar(100) NOT NULL,
  `transaction_poles` varchar(100) NOT NULL,
  `transaction_rakit` varchar(100) NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `employee_group_id`, `registration_id`, `transaction_total`, `transaction_plain_first_date`, `transaction_plain_last_date`, `transaction_actual_date`, `transaction_target_date`, `transaction_komponen`, `transaction_lasketok`, `transaction_dempul`, `transaction_cat`, `transaction_poles`, `transaction_rakit`) VALUES
(1, 2, 2, 550000, '2014-12-29', '2014-12-29', '2014-12-29', '2014-12-29', '1', '1', '1', '1', '1', '1'),
(2, 2, 3, 160000, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE IF NOT EXISTS `transaction_details` (
  `transaction_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_detail_plain_first_date` date NOT NULL,
  `transaction_detail_plain_last_date` date NOT NULL,
  `transaction_detail_actual_date` date NOT NULL,
  `transaction_detail_target_date` date NOT NULL,
  `transaction_detail_description` varchar(100) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `transaction_detail_bongkar_komponen` int(11) NOT NULL,
  `transaction_detail_lasketok` int(11) NOT NULL,
  `transaction_detail_dempul` int(11) NOT NULL,
  `transaction_detail_cat` int(11) NOT NULL,
  `transaction_detail_poles` int(11) NOT NULL,
  `transaction_detail_rakit` int(11) NOT NULL,
  `transaction_detail_total` int(11) NOT NULL,
  `detail_registration_id` int(11) NOT NULL,
  `transaction_detail_date` date NOT NULL,
  PRIMARY KEY (`transaction_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`transaction_detail_id`, `transaction_detail_plain_first_date`, `transaction_detail_plain_last_date`, `transaction_detail_actual_date`, `transaction_detail_target_date`, `transaction_detail_description`, `transaction_id`, `transaction_detail_bongkar_komponen`, `transaction_detail_lasketok`, `transaction_detail_dempul`, `transaction_detail_cat`, `transaction_detail_poles`, `transaction_detail_rakit`, `transaction_detail_total`, `detail_registration_id`, `transaction_detail_date`) VALUES
(13, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', 1, 1, 0, 0, 0, 0, 6, 300000, 1, '2014-12-18'),
(14, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', 1, 0, 2, 0, 0, 0, 6, 250000, 2, '2014-12-18'),
(7, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', 2, 0, 0, 0, 0, 0, 0, 0, 4, '0000-00-00'),
(8, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', 2, 1, 0, 0, 4, 0, 0, 160000, 3, '2014-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

CREATE TABLE IF NOT EXISTS `transaction_types` (
  `transaction_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type_name` varchar(100) NOT NULL,
  `transaction_type_price` int(11) NOT NULL,
  `transaction_type_description` varchar(100) NOT NULL,
  PRIMARY KEY (`transaction_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `transaction_types`
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
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `expired_date` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_name`, `user_email`, `user_phone`, `job_title`, `company`, `user_password`, `user_group_id`, `user_last_login`, `user_registered`, `user_is_active`, `employee_id`, `user_is_login`, `expired_date`) VALUES
(1, 'admin', 'Administrator', '', '', '', '', 'cdaeb1282d614772beb1e74c192bebda', 1, NULL, NULL, 1, 1, 1, '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
