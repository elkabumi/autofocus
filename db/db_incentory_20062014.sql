-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 20, 2014 at 10:36 AM
-- Server version: 5.5.36-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `birdflys_inventori`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` text NOT NULL,
  `company_addres` text NOT NULL,
  `company_phone` int(11) NOT NULL,
  `company_email` text NOT NULL,
  `company_logo` text NOT NULL,
  `company_desc` text NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_addres`, `company_phone`, `company_email`, `company_logo`, `company_desc`) VALUES
(1, 'inventory5', 'surabaya', 12343, 'inventory@yahoo.com', '', '0555');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_number` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phone` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_description` text NOT NULL,
  `customer_ktp_number` char(100) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_number`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `customer_description`, `customer_ktp_number`) VALUES
(1, 'C0000001', 'Indosat', '08815550999', 'elkabumi@yahoo.com', 'Surabaya', '', ''),
(2, 'C0000002', 'Three', '0898777555', 'three@gmail.com', 'Surabaya', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_nip`, `employee_name`, `employee_birth`, `employee_gender`, `employee_position_id`, `employee_ktp`, `employee_address`, `employee_phone`, `employee_email`, `employee_bank_number`, `employee_bank_name`, `employee_bank_beneficiary`, `employee_active_status`, `employee_pic`) VALUES
(1, NULL, 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_positions`
--

CREATE TABLE IF NOT EXISTS `employee_positions` (
  `employee_position_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_position_name` varchar(200) NOT NULL,
  `employee_position_description` text NOT NULL,
  PRIMARY KEY (`employee_position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `employee_positions`
--

INSERT INTO `employee_positions` (`employee_position_id`, `employee_position_name`, `employee_position_description`) VALUES
(1, 'DCC', ''),
(2, 'GDC', ''),
(3, 'RAL', ''),
(4, 'PCR', 'Project Controller Regional'),
(5, 'PCN', 'Project Controller National');

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
(1, 'Administrator', '1'),
(2, 'test', NULL),
(3, 'Regional', NULL),
(4, 'Jakarta', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log_action_types`
--

CREATE TABLE IF NOT EXISTS `log_action_types` (
  `log_action_type_id` int(11) DEFAULT NULL,
  `log_action_type_name` varchar(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `log_data`
--

INSERT INTO `log_data` (`log_data_id`, `log_data_time`, `log_data_module_id`, `log_data_ip`, `log_data_user_id`, `log_data_type`, `log_data_data_id`, `log_data_remark`) VALUES
(1, '2014-05-22 06:05:26', 1, '::1', 1, 0, 3, 'customer [sad]'),
(2, '2014-05-22 06:05:32', 1, '::1', 1, 2, 3, 'customer'),
(3, '2014-06-02 15:06:20', 7, '127.0.0.1', 1, 0, 1, 'PO Received'),
(4, '2014-06-06 08:06:51', 2, '39.252.74.142', 1, 0, 11, 'produk[Module FSME]'),
(5, '2014-06-06 08:06:06', 2, '39.252.74.142', 1, 2, 11, 'Produk'),
(6, '2014-06-06 08:06:39', 3, '39.252.74.142', 1, 0, 5, 'Kategori Produk [IM USD]'),
(7, '2014-06-06 08:06:06', 3, '39.252.74.142', 1, 0, 6, 'Kategori Produk [IM IDR]'),
(8, '2014-06-06 09:06:01', 7, '39.252.74.142', 1, 0, 3, 'PO Received'),
(9, '2014-06-06 09:06:51', 7, '39.252.74.142', 1, 0, 4, 'PO Received'),
(10, '2014-06-06 09:06:34', 2, '39.252.74.142', 1, 0, 12, 'produk[Module FSME]'),
(11, '2014-06-06 09:06:16', 7, '39.252.74.142', 1, 0, 5, 'PO Received'),
(12, '2014-06-06 09:06:14', 2, '39.252.74.142', 1, 2, 12, 'Produk'),
(13, '2014-06-08 09:06:13', 8, '182.9.164.81', 1, 0, 0, 'Group'),
(14, '2014-06-08 09:06:28', 8, '182.9.164.81', 1, 0, 0, 'Group'),
(15, '2014-06-08 09:06:45', 11, '182.9.164.81', 1, 0, 1, 'Jabatan Pegawai [DCC]'),
(16, '2014-06-08 09:06:54', 11, '182.9.164.81', 1, 0, 2, 'Jabatan Pegawai [GDC]'),
(17, '2014-06-08 09:06:05', 11, '182.9.164.81', 1, 0, 3, 'Jabatan Pegawai [RAL]'),
(18, '2014-06-08 09:06:21', 11, '182.9.164.81', 1, 0, 4, 'Jabatan Pegawai [PCR]'),
(19, '2014-06-08 09:06:35', 11, '182.9.164.81', 1, 0, 5, 'Jabatan Pegawai [PCN]'),
(20, '2014-06-08 09:06:58', 11, '182.9.164.81', 1, 1, 5, 'Jabatan Pegawai [PCN]'),
(21, '2014-06-08 10:06:18', 11, '182.9.164.81', 1, 1, 4, 'Jabatan Pegawai [PCR]'),
(22, '2014-06-08 16:06:04', 7, '39.214.102.59', 1, 1, 5, 'PO Received');

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
('2014-04-28 06:04:41', 0, '::1', 0, 'LOGOUT', 'login/logout/1'),
('2014-04-28 06:04:15', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 06:04:32', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 06:04:24', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-04-28 06:04:29', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 06:04:51', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-04-28 06:04:56', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 06:04:57', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-04-28 06:04:01', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 06:04:10', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-04-28 06:04:15', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 08:04:35', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-04-28 08:04:40', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 08:04:47', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 08:04:57', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-04-28 08:04:59', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-04-28 08:04:06', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-02 05:05:06', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-02 06:05:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-02 07:05:39', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-02 07:05:50', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-02 07:05:57', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-02 11:05:35', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-05 05:05:11', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-06 10:05:38', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-07 09:05:56', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-08 07:05:44', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-08 07:05:54', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-08 16:05:33', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-08 16:05:54', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-08 16:05:00', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-08 16:05:20', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 10:05:52', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 10:05:00', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 11:05:14', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 11:05:20', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 15:05:46', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 15:05:57', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 15:05:54', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 15:05:59', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 15:05:10', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 15:05:16', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 15:05:20', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 15:05:25', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 15:05:09', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 15:05:14', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 15:05:41', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 15:05:47', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-09 23:05:20', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-09 23:05:31', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-10 00:05:07', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-10 00:05:14', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-10 00:05:57', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-10 00:05:04', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-10 21:05:54', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-10 21:05:01', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-10 21:05:40', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-10 21:05:47', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-11 12:05:00', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-11 12:05:58', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-11 19:05:21', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-11 19:05:34', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 11:05:13', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 11:05:55', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 11:05:45', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 11:05:52', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 11:05:15', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-12 11:05:21', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 11:05:54', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-12 11:05:21', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 14:05:15', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-12 14:05:20', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 14:05:47', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 15:05:18', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 15:05:47', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 09:05:50', 0, '::1', 0, 'LOGOUT', 'login/logout/1'),
('2014-05-12 09:05:58', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-12 10:05:16', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-12 10:05:36', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-13 10:05:00', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-13 10:05:07', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-14 06:05:36', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-14 06:05:44', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-14 06:05:47', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-14 07:05:35', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-14 07:05:27', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-19 11:05:31', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-20 09:05:29', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-21 11:05:10', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-21 11:05:44', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-21 11:05:53', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-21 11:05:43', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-21 11:05:56', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-22 10:05:49', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-22 10:05:54', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-26 11:05:21', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-26 11:05:48', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-28 05:05:17', 0, '::1', 1, 'LOGOUT', 'login/logout/1'),
('2014-05-28 05:05:23', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-28 07:05:56', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-28 10:05:41', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-05-30 11:05:49', 0, '192.168.1.179', 1, 'LOGIN', 'login/submit'),
('2014-06-01 07:06:26', 0, '::1', 1, 'LOGIN', 'login/submit'),
('2014-06-02 15:06:16', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-06-02 15:06:54', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-02 15:06:01', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-06-02 15:06:53', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-02 15:06:39', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-06-02 16:06:24', 0, '127.0.0.1', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-02 16:06:15', 0, '127.0.0.1', 1, 'LOGIN', 'login/submit'),
('2014-06-03 16:06:28', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-03 18:06:35', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-04 11:06:09', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-04 11:06:15', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-05 18:06:35', 0, '112.215.89.186', 1, 'LOGIN', 'login/submit'),
('2014-06-05 18:06:17', 0, '112.215.89.186', 1, 'LOGIN', 'login/submit'),
('2014-06-06 07:06:17', 0, '120.177.60.216', 1, 'LOGIN', 'login/submit'),
('2014-06-06 08:06:14', 0, '39.252.74.142', 1, 'LOGIN', 'login/submit'),
('2014-06-06 08:06:37', 0, '39.252.74.142', 1, 'LOGIN', 'login/submit'),
('2014-06-07 22:06:49', 0, '182.9.164.81', 1, 'LOGIN', 'login/submit'),
('2014-06-07 23:06:35', 0, '182.9.164.81', 1, 'LOGIN', 'login/submit'),
('2014-06-07 23:06:56', 0, '182.9.164.81', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-07 23:06:52', 0, '182.9.164.81', 1, 'LOGIN', 'login/submit'),
('2014-06-07 23:06:13', 0, '182.9.164.81', 1, 'LOGIN', 'login/submit'),
('2014-06-08 09:06:02', 0, '182.9.164.81', 1, 'LOGIN', 'login/submit'),
('2014-06-08 10:06:34', 0, '114.124.33.109', 1, 'LOGIN', 'login/submit'),
('2014-06-08 15:06:19', 0, '39.214.102.59', 1, 'LOGIN', 'login/submit'),
('2014-06-10 13:06:43', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-10 13:06:06', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-10 13:06:44', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-12 11:06:14', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-12 15:06:59', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-12 15:06:15', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-12 15:06:50', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-12 15:06:22', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-12 15:06:39', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-12 16:06:20', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-12 16:06:20', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-12 16:06:42', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-12 16:06:55', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-12 16:06:35', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-12 22:06:38', 0, '39.199.135.1', 1, 'LOGIN', 'login/submit'),
('2014-06-12 23:06:27', 0, '39.252.179.12', 1, 'LOGIN', 'login/submit'),
('2014-06-12 23:06:46', 0, '114.124.30.143', 1, 'LOGIN', 'login/submit'),
('2014-06-13 11:06:38', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-13 12:06:02', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-13 12:06:10', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-13 21:06:03', 0, '39.193.209.182', 1, 'LOGIN', 'login/submit'),
('2014-06-13 21:06:12', 0, '39.193.209.182', 1, 'LOGIN', 'login/submit'),
('2014-06-15 22:06:36', 0, '39.208.64.135', 1, 'LOGIN', 'login/submit'),
('2014-06-16 13:06:50', 0, '112.215.89.186', 1, 'LOGIN', 'login/submit'),
('2014-06-17 13:06:51', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-17 14:06:11', 0, '140.0.199.2', 1, 'LOGOUT', 'login/logout/1'),
('2014-06-17 14:06:18', 0, '140.0.199.2', 1, 'LOGIN', 'login/submit'),
('2014-06-18 22:06:51', 0, '182.10.97.95', 1, 'LOGIN', 'login/submit');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_code`, `module_name`, `module_approval_url`, `module_group`, `module_view_url`, `module_cancel_url`) VALUES
(1, 'master.customer', 'Client', NULL, 'master.customer', NULL, NULL),
(2, 'master.product', 'Material List', NULL, 'master.product', NULL, NULL),
(3, 'master.product_category', 'Material Type', NULL, 'master.product_category', NULL, NULL),
(4, 'master.phase', 'Phase', NULL, 'master.phase', NULL, NULL),
(5, 'master.project_name', 'Project name', NULL, 'master.project_name', NULL, NULL),
(6, 'master.uom', 'Uom', NULL, 'master.uom', NULL, NULL),
(7, 'transaction.po_received', 'PO received', NULL, 'transaction.po_received', NULL, NULL),
(8, 'tool.user', 'User', NULL, 'tool.user', NULL, NULL),
(9, 'tool.permit', 'Permissions', NULL, 'tool.permit', NULL, NULL),
(10, 'employee.employee', 'Employee', NULL, 'employee.employee', NULL, NULL),
(11, 'employee.employee_position', 'Employee Position', NULL, 'employee.employee_position', NULL, NULL),
(12, 'report.client_report', 'Client Report', NULL, 'report.client_report', NULL, NULL),
(13, 'report.material_report', 'Material Report', NULL, 'report.material_report', NULL, NULL),
(14, 'report.transaction_received_report', 'PO Received Report', NULL, 'report.transaction_received_report', NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permits`
--

CREATE TABLE IF NOT EXISTS `permits` (
  `permit_group_id` int(11) DEFAULT NULL,
  `permit_module_id` int(11) DEFAULT NULL,
  `permit_crud_mode` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phase`
--

CREATE TABLE IF NOT EXISTS `phase` (
  `phase_id` int(11) NOT NULL AUTO_INCREMENT,
  `phase_code` varchar(45) NOT NULL,
  `phase_name` varchar(100) NOT NULL,
  `phase_description` text NOT NULL,
  `phase_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `phase_date` int(11) NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  PRIMARY KEY (`phase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `phase`
--

INSERT INTO `phase` (`phase_id`, `phase_code`, `phase_name`, `phase_description`, `phase_active_status`, `created_by_id`, `phase_date`, `inactive_by_id`) VALUES
(2, 'PH0000001', '2014', 'qw', 0, 1, 2014, 1),
(3, 'PH0000002', '2015', '', 1, 1, 2014, 0),
(4, 'PH0000003', 'Carry Over 2014', '', 1, 1, 2014, 0),
(5, 'PH0000004', 'sdad', '', 1, 1, 2014, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) NOT NULL,
  `product_code` varchar(45) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_description` text,
  `product_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `product_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_products_product_categories_idx` (`product_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_category_id`, `product_code`, `product_name`, `product_description`, `product_active_status`, `created_by_id`, `product_date`, `inactive_by_id`) VALUES
(4, 1, 'P0000004', 'Kabel1', '', 1, 1, '2014-05-02', 0),
(5, 1, 'P0000005', 'Antena', '', 0, 1, '2014-05-02', 1),
(6, 2, 'P0000006', 'software', 'www', 1, 1, '2014-05-10', 0),
(7, 1, '1100000299', 'Flexi Multiradio 2G System Module up to 18 TRX', '', 1, 1, '2014-05-21', 0),
(8, 1, '1100001194', 'Flexi Multiradio 2G System Module up to 36 TRX', '', 1, 1, '2014-05-21', 0),
(9, 4, '4100001110', '(config C) G900/G1800/U900/U2100', '', 1, 1, '2014-05-21', 0),
(10, 4, '4100000747', 'Antenna Mounting Bracket', '', 1, 1, '2014-05-21', 0),
(11, 1, '123456', 'Module FSME', 'System Module 3G', 0, 1, '2014-06-06', 1),
(12, 1, '12345', 'Module FSME', 'FMSE for 3G', 0, 1, '2014-06-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_code` varchar(100) DEFAULT NULL,
  `product_category_name` varchar(100) DEFAULT NULL,
  `product_category_description` text NOT NULL,
  PRIMARY KEY (`product_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`product_category_id`, `product_category_code`, `product_category_name`, `product_category_description`) VALUES
(1, NULL, 'Hardware', ''),
(2, NULL, 'Software', ''),
(3, NULL, 'IM', ''),
(4, NULL, 'Service', ''),
(5, NULL, 'IM USD', ''),
(6, NULL, 'IM IDR', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_code` varchar(100) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_description` text NOT NULL,
  `customer_id` int(11) NOT NULL,
  `project_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `project_date` date NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_code`, `project_name`, `project_description`, `customer_id`, `project_active_status`, `created_by_id`, `project_date`, `inactive_by_id`) VALUES
(1, 'PN0000001', 'Tower Gayungsari33', 'wwwwww', 1, 0, 0, '2000-01-06', 1),
(2, 'PN0000002', 'antena', '111', 2, 1, 1, '2014-05-10', 0),
(3, 'PN0000003', 'East Java New Site', '', 1, 1, 1, '2014-05-21', 0),
(4, 'PN0000004', 'asdasd', '', 2, 1, 1, '2014-05-22', 0),
(5, '123421', 'asad', '', 1, 1, 1, '2014-05-22', 0);

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
('281335d189b7177cd82b9020a61ec2ec', '39.208.64.135', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1402842790, NULL),
('4a4020611df80371c80afa26f5d88170', '39.208.64.135', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1402842853, 'a:4:{s:6:"logged";i:1;s:9:"user_info";a:13:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1402842816;s:7:"menubar";s:3684:"<ul id="mainmenu" class="sf-menu sf-vertical"><li> <i class="fa fa-bar-chart-o"></i> <span><a href="http://www.birdflyshoes.com/inventory/dashboard">Dashboard</a></span></li>\n<li> <i class="fa fa-edit"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">Master List</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="11000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/phase">Project Phase</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/project_name">Project name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/product_category">Material Type</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/product">Material List</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/site">Site</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/uom">Uom</a></span></li>\n</li>\n</ul><li> <i class="fa fa-shopping-cart"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">PO Inventory</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="13000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received">PO Received</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation">PO Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_retur">Cancel Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_process">PO Closing</a></span></li>\n</li>\n</ul><li> <i class="fa fa-print"></i> <span><a href="http://www.birdflyshoes.com/inventory/1">PO Report</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="14000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/project_report">Project Name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received_summary_report">PO Received Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received_report">PO Received Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation_summary_report">PO Reservation Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation_report">PO Reservation Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/phase_report">Project Phase </a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/material_report">Material </a></span></li>\n</li>\n</ul><li> <i class="fa fa-asterisk"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">User Management</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="18000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/user">User</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/permit">Permission</a></span></li>\n</li>\n</ul></ul>";}'),
('0cb99e1cd37b26b63ad011bc7608f863', '150.70.97.118', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1;', 1402842885, NULL),
('10f30082f279bc629128c9826d0dd7a0', '150.70.75.34', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)', 1402842911, NULL),
('de2b327ac5801bba40a7cd0bca88cb03', '112.215.89.186', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1403006976, 'a:4:{s:6:"logged";i:1;s:9:"user_info";a:13:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1402895210;s:7:"menubar";s:3684:"<ul id="mainmenu" class="sf-menu sf-vertical"><li> <i class="fa fa-bar-chart-o"></i> <span><a href="http://www.birdflyshoes.com/inventory/dashboard">Dashboard</a></span></li>\n<li> <i class="fa fa-edit"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">Master List</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="11000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/phase">Project Phase</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/project_name">Project name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/product_category">Material Type</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/product">Material List</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/site">Site</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/uom">Uom</a></span></li>\n</li>\n</ul><li> <i class="fa fa-shopping-cart"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">PO Inventory</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="13000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received">PO Received</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation">PO Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_retur">Cancel Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_process">PO Closing</a></span></li>\n</li>\n</ul><li> <i class="fa fa-print"></i> <span><a href="http://www.birdflyshoes.com/inventory/1">PO Report</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="14000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/project_report">Project Name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received_summary_report">PO Received Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received_report">PO Received Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation_summary_report">PO Reservation Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation_report">PO Reservation Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/phase_report">Project Phase </a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/material_report">Material </a></span></li>\n</li>\n</ul><li> <i class="fa fa-asterisk"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">User Management</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="18000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/user">User</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/permit">Permission</a></span></li>\n</li>\n</ul></ul>";}'),
('fbe9bacfb08c4f1533937553bc26dccb', '150.70.173.51', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1;', 1402895255, NULL),
('7aa89ca3a1a25a58bd6ac05dd4f0594c', '140.0.199.2', 'Mozilla/5.0 (Windows NT 6.2; rv:30.0) Gecko/201001', 1402985289, 'a:4:{s:6:"logged";i:1;s:9:"user_info";a:13:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1402985298;s:7:"menubar";s:3588:"<ul id="mainmenu" class="sf-menu sf-vertical"><li> <i class="fa fa-bar-chart-o"></i> <span><a href="http://birdflyshoes.com/inventory/dashboard">Dashboard</a></span></li>\n<li> <i class="fa fa-edit"></i> <span><a href="http://birdflyshoes.com/inventory/#">Master List</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="11000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/phase">Project Phase</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/project_name">Project name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/product_category">Material Type</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/product">Material List</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/site">Site</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/uom">Uom</a></span></li>\n</li>\n</ul><li> <i class="fa fa-shopping-cart"></i> <span><a href="http://birdflyshoes.com/inventory/#">PO Inventory</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="13000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_received">PO Received</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_reservation">PO Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_retur">Cancel Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_process">PO Closing</a></span></li>\n</li>\n</ul><li> <i class="fa fa-print"></i> <span><a href="http://birdflyshoes.com/inventory/1">PO Report</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="14000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/project_report">Project Name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_received_summary_report">PO Received Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_received_report">PO Received Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_reservation_summary_report">PO Reservation Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/po_reservation_report">PO Reservation Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/phase_report">Project Phase </a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/material_report">Material </a></span></li>\n</li>\n</ul><li> <i class="fa fa-asterisk"></i> <span><a href="http://birdflyshoes.com/inventory/#">User Management</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="18000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/user">User</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://birdflyshoes.com/inventory/permit">Permission</a></span></li>\n</li>\n</ul></ul>";}'),
('12ff781d4e0ff96cd6fdf0fc8c49bf42', '150.70.173.56', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1;', 1402996178, NULL),
('5728a5fdcf378adc9662108986c51095', '141.0.9.32', 'Opera/9.80 (J2ME/MIDP; Opera Mini/4.4.31891/35.288', 1403003285, NULL),
('3f5ec7d596a9d3082f87c5e76e353fb6', '150.70.173.51', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1;', 1403007027, NULL),
('63d6eb96588e6517059d94b2b2f70d2f', '150.70.172.207', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)', 1403007335, NULL),
('82057076e9aa2a9f4d8b0b05d57549a8', '182.10.97.95', 'Mozilla/5.0 (Linux; Android 4.0.3; GT-P5100 Build/', 1403101405, 'a:4:{s:6:"logged";i:1;s:9:"user_info";a:13:{s:7:"user_id";s:1:"1";s:10:"user_login";s:5:"admin";s:9:"user_name";s:13:"Administrator";s:13:"user_password";s:32:"cdaeb1282d614772beb1e74c192bebda";s:13:"user_group_id";s:1:"1";s:15:"user_last_login";N;s:15:"user_registered";N;s:14:"user_is_active";s:1:"1";s:11:"employee_id";s:1:"1";s:13:"user_is_login";s:1:"1";s:13:"employee_name";s:13:"Administrator";s:12:"employee_nip";N;s:10:"group_name";s:13:"Administrator";}s:10:"login_time";i:1403101251;s:7:"menubar";s:3684:"<ul id="mainmenu" class="sf-menu sf-vertical"><li> <i class="fa fa-bar-chart-o"></i> <span><a href="http://www.birdflyshoes.com/inventory/dashboard">Dashboard</a></span></li>\n<li> <i class="fa fa-edit"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">Master List</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="11000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/phase">Project Phase</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/project_name">Project name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/product_category">Material Type</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/product">Material List</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/site">Site</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/uom">Uom</a></span></li>\n</li>\n</ul><li> <i class="fa fa-shopping-cart"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">PO Inventory</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="13000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received">PO Received</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation">PO Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_retur">Cancel Reservation</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_process">PO Closing</a></span></li>\n</li>\n</ul><li> <i class="fa fa-print"></i> <span><a href="http://www.birdflyshoes.com/inventory/1">PO Report</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="14000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/project_report">Project Name</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received_summary_report">PO Received Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_received_report">PO Received Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation_summary_report">PO Reservation Summary</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/po_reservation_report">PO Reservation Detail</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/phase_report">Project Phase </a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/material_report">Material </a></span></li>\n</li>\n</ul><li> <i class="fa fa-asterisk"></i> <span><a href="http://www.birdflyshoes.com/inventory/#">User Management</a></span><i class="fa fa-angle-left pull-right"></i><ul parent="18000"><li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/user">User</a></span></li>\n<li> <i class="fa fa-chevron-circle-right"></i> <span><a href="http://www.birdflyshoes.com/inventory/permit">Permission</a></span></li>\n</li>\n</ul></ul>";}');

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
(14000, 1, 'PO Report', '1', 0, 0, 1, '1', 'fa-print'),
(14001, 14000, 'PO Received Summary', 'po_received_summary_report', 0, 0, 2, '1', ''),
(14003, 14000, 'PO Reservation Summary', 'po_reservation_summary_report', 0, 0, 2, '1', ''),
(18001, 18000, 'User', 'user', 0, 8, 2, '1', ''),
(18000, 1, 'User Management', '#', 0, 0, 1, '1', 'fa-asterisk'),
(14004, 14000, 'PO Reservation Detail', 'po_reservation_report', 0, 0, 2, '1', ''),
(13002, 13000, 'PO Reservation', 'po_reservation', 0, 0, 2, '1', ''),
(13001, 13000, 'PO Received', 'po_received', 0, 7, 2, '1', ''),
(13000, 1, 'PO Inventory', '#', 0, 0, 1, '1', 'fa-shopping-cart'),
(11004, 11000, 'Material List', 'product', 0, 2, 2, '1', ''),
(11003, 11000, 'Material Type', 'product_category', 0, 3, 2, '1', ''),
(13003, 13000, 'Cancel Reservation', 'po_retur', 0, 0, 2, '1', ''),
(14002, 14000, 'PO Received Detail', 'po_received_report', 0, 14, 2, '1', ''),
(14007, 14000, 'Material ', 'material_report', 0, 13, 2, '1', ''),
(10000, 1, 'Dashboard', 'dashboard', 0, 1, 1, '1', 'fa-bar-chart-o'),
(11000, 1, 'Master List', '#', 0, 0, 1, '1', 'fa-edit'),
(18002, 18000, 'Permission', 'permit', 0, 9, 2, '1', ''),
(11001, 11000, 'Project Phase', 'phase', 0, 4, 2, '1', ''),
(11002, 11000, 'Project name', 'project_name', 0, 5, 2, '1', ''),
(14006, 14000, 'Project Name', 'project_report', NULL, 0, 2, '1', ''),
(11006, 11000, 'Uom', 'uom', 0, 6, 2, '1', ''),
(14005, 14000, 'Project Phase ', 'phase_report', 0, 0, 2, '1', ''),
(11005, 11000, 'Site', 'site', 0, NULL, 2, '1', ''),
(13004, 13000, 'PO Closing', 'po_process', 0, 0, 2, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_code` varchar(100) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `site_description` text NOT NULL,
  `site_date` date NOT NULL,
  `site_active_status` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`site_id`, `site_code`, `site_name`, `site_description`, `site_date`, `site_active_status`, `created_by_id`, `inactive_by_id`) VALUES
(1, 'S0000001', 'Gayungsari', '    ', '2014-05-14', 1, 1, 1),
(2, '20SBY332', 'KERTAJAYA_TBG', 'Tower Green Field TBG', '2014-05-21', 1, 1, 0),
(3, 'S0000002', 'asdasd', '    ', '2014-05-22', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type_id` int(11) NOT NULL,
  `transaction_code` varchar(45) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `transaction_description` text,
  `transaction_status` int(11) DEFAULT NULL,
  `transaction_sent_id` int(11) NOT NULL,
  `transaction_retur_id` int(11) NOT NULL,
  `phase_id` int(11) NOT NULL,
  `transaction_received_date` date NOT NULL,
  `transaction_delivery_date` date NOT NULL,
  `transaction_product_category_id` int(11) NOT NULL,
  `transaction_active_status` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `create_by_id` int(11) NOT NULL,
  `inactive_by_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `site_mapping_id` int(11) NOT NULL,
  `transaction_wpid_no` varchar(100) NOT NULL,
  `transaction_so_no` varchar(100) NOT NULL,
  `transaction_bast_no` varchar(100) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `fk_transactions_transaction_types1_idx` (`transaction_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `transaction_type_id`, `transaction_code`, `transaction_date`, `project_id`, `transaction_description`, `transaction_status`, `transaction_sent_id`, `transaction_retur_id`, `phase_id`, `transaction_received_date`, `transaction_delivery_date`, `transaction_product_category_id`, `transaction_active_status`, `create_date`, `create_by_id`, `inactive_by_id`, `site_id`, `site_mapping_id`, `transaction_wpid_no`, `transaction_so_no`, `transaction_bast_no`) VALUES
(19, 1, 'PO0000001', '2014-06-02 00:00:00', 3, '', 1, 0, 0, 4, '2014-06-02', '2014-06-02', 1, 1, '2014-06-02', 1, 0, 0, 0, '', '', ''),
(20, 2, 'PR00001', '2014-06-02 00:00:00', 3, '', 1, 19, 0, 4, '2014-06-02', '2014-06-02', 1, 1, '2014-06-02', 1, 0, 1, 0, '', '', ''),
(21, 1, '4000009944', '2014-06-02 00:00:00', 3, '', 1, 0, 0, 4, '2014-05-01', '2014-08-31', 1, 1, '2014-06-02', 1, 0, 0, 0, '', '', ''),
(22, 1, '4000010233', '2014-06-02 00:00:00', 3, '', 1, 0, 0, 4, '2014-05-01', '2014-08-31', 4, 1, '2014-06-02', 1, 0, 0, 0, '', '', ''),
(23, 2, 'HW0001', '2014-06-02 00:00:00', 3, '', 1, 21, 0, 4, '2014-06-02', '2014-06-02', 1, 1, '2014-06-02', 1, 0, 2, 0, '', '', ''),
(24, 2, 'SV0001', '2014-06-02 00:00:00', 3, '', 1, 22, 0, 4, '2014-06-02', '2014-06-02', 4, 1, '2014-06-02', 1, 0, 2, 0, '4', '5', '6'),
(25, 3, 'RN0001', '2014-06-02 00:00:00', 3, '', 1, 0, 23, 4, '2014-06-02', '2014-06-02', 1, 1, '2014-06-02', 1, 0, 0, 0, '', '', ''),
(26, 1, 'PO0000002', '2014-06-09 00:00:00', 3, 'test', 1, 0, 0, 2, '2014-06-10', '2014-06-09', 1, 0, '2014-06-09', 1, 1, 0, 0, '', '', ''),
(27, 3, '232', '2014-06-10 00:00:00', 3, '', 1, 0, 20, 4, '2014-06-10', '2014-06-10', 1, 1, '2014-06-10', 1, 0, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE IF NOT EXISTS `transaction_details` (
  `transaction_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `transaction_detail_qty` int(11) DEFAULT NULL,
  `transaction_detail_description` text,
  `transaction_detail_ordered` int(11) NOT NULL,
  `transaction_detail_return` int(11) NOT NULL,
  `transaction_detail_balance` int(11) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `transaction_detail_quantity_ordered` int(11) NOT NULL,
  `transaction_detail_quantity_boq` int(11) NOT NULL,
  `transaction_detail_quantity_so` int(11) NOT NULL,
  `transaction_detail_quantity_bast` int(11) NOT NULL,
  `transaction_detail_remarks_project` text NOT NULL,
  `transaction_detail_remarks_gdc` text NOT NULL,
  `transaction_detail_remarks_soc` text NOT NULL,
  `transaction_detail_remarks_ccm` text NOT NULL,
  PRIMARY KEY (`transaction_detail_id`),
  KEY `fk_transaction_details_transactions1_idx` (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`transaction_detail_id`, `transaction_id`, `product_id`, `transaction_detail_qty`, `transaction_detail_description`, `transaction_detail_ordered`, `transaction_detail_return`, `transaction_detail_balance`, `uom_id`, `transaction_detail_quantity_ordered`, `transaction_detail_quantity_boq`, `transaction_detail_quantity_so`, `transaction_detail_quantity_bast`, `transaction_detail_remarks_project`, `transaction_detail_remarks_gdc`, `transaction_detail_remarks_soc`, `transaction_detail_remarks_ccm`) VALUES
(33, 19, 4, 50, '    ', 10, 0, 40, 2, 0, 0, 0, 0, '', '', '', ''),
(34, 19, 7, 60, '    ', 25, 3, 38, 2, 0, 0, 0, 0, '', '', '', ''),
(35, 20, 4, 50, '', 10, 0, 40, 2, 1, 2, 3, 4, '8', '9', '', '11'),
(36, 20, 7, 60, '', 25, 0, 35, 2, 0, 0, 0, 0, '', '', '', ''),
(37, 21, 7, 4, '    ', 1, 1, 4, 2, 0, 0, 0, 0, '', '', '', ''),
(38, 21, 8, 4, '    ', 1, 0, 3, 2, 0, 0, 0, 0, '', '', '', ''),
(39, 22, 9, 4, '    ', 1, 0, 3, 2, 0, 0, 0, 0, '', '', '', ''),
(40, 22, 10, 4, '    ', 1, 0, 3, 2, 0, 0, 0, 0, '', '', '', ''),
(41, 23, 7, 4, '', 1, 0, 3, 2, 1, 1, 1, 1, '', '', '', ''),
(42, 23, 8, 4, '', 1, 0, 3, 2, 0, 0, 0, 0, '', '', '', ''),
(43, 24, 9, 4, '', 1, 0, 3, 2, 1, 1, 1, 1, '1', '2', '', '4'),
(44, 24, 10, 4, '', 1, 0, 3, 2, 0, 0, 0, 0, '', '', '', ''),
(45, 25, 7, 1, '', 0, 1, 0, 2, 0, 0, 0, 0, '', '', '', ''),
(46, 26, 4, 50, '    ', 0, 0, 50, 2, 0, 0, 0, 0, '', '', '', ''),
(47, 27, 7, 25, '', 0, 3, 0, 2, 0, 0, 0, 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

CREATE TABLE IF NOT EXISTS `transaction_types` (
  `transaction_type_id` int(11) NOT NULL,
  `transaction_type_code` varchar(45) DEFAULT NULL,
  `transaction_type_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`transaction_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`transaction_type_id`, `transaction_type_code`, `transaction_type_name`) VALUES
(1, '001', 'PO Received'),
(2, '002', 'PO Reservation'),
(3, '003', 'Retur');

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE IF NOT EXISTS `uom` (
  `uom_id` int(11) NOT NULL AUTO_INCREMENT,
  `uom_name` varchar(100) NOT NULL,
  PRIMARY KEY (`uom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`uom_id`, `uom_name`) VALUES
(2, 'Unit'),
(3, 'Pc');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(12) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `user_password` varchar(32) DEFAULT NULL,
  `user_group_id` int(11) DEFAULT NULL,
  `user_last_login` datetime DEFAULT NULL,
  `user_registered` datetime DEFAULT NULL,
  `user_is_active` tinyint(1) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `user_is_login` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_name`, `user_password`, `user_group_id`, `user_last_login`, `user_registered`, `user_is_active`, `employee_id`, `user_is_login`) VALUES
(1, 'admin', 'Administrator', 'cdaeb1282d614772beb1e74c192bebda', 1, NULL, NULL, 1, 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_transaction_types1` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`transaction_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
