-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2015 at 11:56 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `classroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `academicyears`
--

CREATE TABLE IF NOT EXISTS `academicyears` (
  `school_id` int(6) unsigned NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academicyears`
--

INSERT INTO `academicyears` (`school_id`, `date_start`, `date_end`, `active`) VALUES
(1, '2015-01-05', '2016-04-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
`booking_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `period_id` int(6) unsigned DEFAULT NULL,
  `week_id` int(6) unsigned DEFAULT NULL,
  `day_num` int(1) unsigned DEFAULT NULL,
  `room_id` int(6) unsigned DEFAULT NULL,
  `user_id` int(6) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancelled` tinyint(1) unsigned DEFAULT '0',
  `status` int(6) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `school_id`, `period_id`, `week_id`, `day_num`, `room_id`, `user_id`, `date`, `notes`, `cancelled`, `status`, `active`) VALUES
(1, 1, 1, 1, 5, 3, 5, '2015-04-24', 'MAKE-UP CLASS', 0, 1, 1),
(2, 1, 2, 1, 5, 3, 5, '2015-04-24', 'MAKE-UP CLASS', 0, 1, 1),
(4, 1, 1, 1, 5, 2, 1, NULL, '1T126', 0, 0, 1),
(5, 1, 1, 1, 6, 3, 5, '2015-04-25', 'Exam', 0, 1, 1),
(6, 1, 2, 1, 6, 3, 5, '2015-04-25', 'Exam', 0, 1, 1),
(7, 1, 3, 1, 6, 3, 5, '2015-04-25', 'Exam', 0, 1, 1),
(8, 1, 1, 1, 6, 2, 1, NULL, 'TEST', 0, 0, 1),
(10, 1, 5, 1, 6, 3, 3, '2015-04-25', 'WEHE', 0, 1, 1),
(11, 1, 6, 1, 6, 3, 3, '2015-04-25', 'WEHE', 0, 1, 1),
(12, 1, 2, 1, 6, 2, 1, NULL, 'TELL ME WHY', 0, 0, 1),
(13, 1, 3, 1, 6, 2, 6, '2015-04-25', 'WELL', 0, 1, 1),
(14, 1, 4, 1, 6, 2, 6, '2015-04-25', 'WELL', 0, 1, 1),
(15, 1, 5, 1, 6, 2, 6, '2015-04-25', 'WELL', 0, 1, 1),
(16, 1, 1, 1, 1, 3, 1, NULL, 'TESTING PLS', 0, 0, 1),
(17, 1, 1, 1, 3, 3, 1, NULL, '', 0, 0, 1),
(18, 1, 2, 1, 3, 3, 1, NULL, '', 0, 0, 1),
(22, 1, 1, 1, 3, 4, 3, '2015-05-06', 'Revision', 0, 0, 1),
(23, 1, 2, 1, 3, 4, 3, '2015-05-06', 'Revision', 0, 0, 1),
(24, 1, 3, 1, 3, 4, 3, '2015-05-06', 'Revision', 0, 0, 1),
(25, 1, 3, 1, 3, 1, 7, '2015-05-06', 'Conference', 0, 0, 1),
(26, 1, 4, 1, 3, 1, 7, '2015-05-06', 'Conference', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
`department_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `school_id`, `name`, `description`, `icon`, `active`) VALUES
(0, 1, 'Computer Science', 'Computer Science Department', 'asterisk_orange.gif', 1),
(1, 1, 'Guests', 'Guests', 'asterisk_orange.gif', 1),
(2, 1, 'Archi', '', 'rainbow.gif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE IF NOT EXISTS `holidays` (
`holiday_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `itemfields`
--

CREATE TABLE IF NOT EXISTS `itemfields` (
  `field_id` int(6) unsigned NOT NULL DEFAULT '0',
  `school_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('TEXT','SELECT','CHECKBOX','MULTI') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `itemoptions`
--

CREATE TABLE IF NOT EXISTS `itemoptions` (
  `option_id` int(6) unsigned NOT NULL DEFAULT '0',
  `field_id` int(6) unsigned DEFAULT NULL,
  `value` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
`item_id` int(6) unsigned NOT NULL,
  `item_group_id` int(6) NOT NULL,
  `equipment_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `serial` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `user_id` int(6) unsigned DEFAULT NULL,
  `item_type_id` int(6) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bookable` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_group_id`, `equipment_id`, `serial`, `school_id`, `user_id`, `item_type_id`, `name`, `location`, `bookable`, `status`, `icon`, `notes`, `photo`, `active`) VALUES
(1, 1, 'CEACCS-CAM-1', '123745345', 1, 0, 0, '1', 'CAM-1', 1, 1, '0', '', NULL, 1),
(2, 1, 'CEACCS-CAM-2', '123123121', 1, 0, 0, '1', 'CAM-2', 1, 1, '0', '', NULL, 1),
(3, 2, 'CEACCS-MIC-1', '123123123', 1, 0, 0, '2', 'MIC-1', 1, 1, '0', '', NULL, 1),
(4, 2, 'CEACCS-MIC-2', '123123213', 1, 0, 0, '2', 'MIC-2', 1, 1, '0', '', NULL, 1),
(5, 3, 'CEACCS-MIC-3', '1231231', 1, 0, 0, '3', 'MIC-3', 1, 1, '0', 'HFHSDCSDSDF', NULL, 1),
(6, 1, 'CEACCS-CAM-3', '234242432', 1, 0, 0, '1', 'CAM-3', 1, 1, '0', 'sasdscc', NULL, 1),
(7, 4, 'CEACCS-LENS-1', '123123', 1, 0, 0, '4', 'LENS-1', 1, 1, '0', 'WQEQWEQ', NULL, 1),
(8, 4, 'CEACCS-LENS-2', '2131231', 1, 0, 0, '4', 'LENS-2', 1, 1, '0', '', NULL, 1),
(9, 8, 'CEACCS-ACER-3', '111111', 1, 0, 0, '8', 'ACER-3', 1, 1, '0', '', NULL, 1),
(10, 5, 'CEACCS-TAB-1', '12213123', 1, 0, 0, '5', 'NEXUS-1', 1, 1, '0', 'ewqeq', NULL, 1),
(11, 5, 'CEACCS-TAB-1', '12312', 1, 0, 0, '5', 'NEXUS-2', 1, 1, '0', '', NULL, 1),
(12, 6, 'CEACCS-TAB-2', '2323234', 1, 0, 0, '6', 'IPAD-1', 1, 1, '0', 'sdawdd', NULL, 1),
(13, 6, '21321311', '23qdwd', 1, 0, 0, '6', 'IPAD-2', 1, 1, '0', '', NULL, 1),
(14, 8, 'WHY YOU NO', 'WEQWE', 1, 0, 0, '8', 'ACER-1', 1, 1, '0', 'WQWE', NULL, 1),
(15, 8, 'WHWHHW', '34232', 1, 0, 0, '8', 'ACER-2', 1, 1, '0', 'DDSDDDS', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `itemvalues`
--

CREATE TABLE IF NOT EXISTS `itemvalues` (
  `value_id` int(6) unsigned NOT NULL DEFAULT '0',
  `item_id` int(6) unsigned DEFAULT NULL,
  `field_id` int(6) unsigned DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_groups`
--

CREATE TABLE IF NOT EXISTS `item_groups` (
`item_group_id` int(11) NOT NULL,
  `item_type_id` int(6) NOT NULL,
  `school_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_groups`
--

INSERT INTO `item_groups` (`item_group_id`, `item_type_id`, `school_id`, `name`, `description`, `icon`, `photo`, `active`) VALUES
(1, 1, 1, 'DSLR Camera (60D)', '', 'asterisk_orange.gif', 'e3071ce64347e6f6b081faf15d16b16b.jpg', 1),
(2, 2, 1, 'Shennheiser', '', 'asterisk_orange.gif', '6a393c0d1c20104d8e8bb8b0c7bfe93e.jpg', 1),
(3, 2, 1, 'Shure', '', 'asterisk_orange.gif', '46c6ed882f697f06dbeb7971c040fb0a.jpg', 1),
(4, 4, 1, 'DSLR Zoom Lens (18-135mm)', 'heol nice', 'asterisk_orange.gif', '46c6ed882f697f06dbeb7971c040fb0a.jpg', 1),
(5, 1, 1, 'Nexus Tablet', '', 'asterisk_orange.gif', '2d3538b114384db50825e75bf5d3bd2a.jpg', 1),
(6, 5, 1, 'Ipad Mini', '', 'asterisk_orange.gif', '12a916b934491e6ef2218f6efb4afcf0.jpg', 1),
(7, 2, 1, 'Rhode', '', 'asterisk_orange.gif', '5c983abcc02c4ac8c7eb9aae779348dd.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE IF NOT EXISTS `item_types` (
`item_type_id` int(6) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`item_type_id`, `school_id`, `name`, `description`, `icon`, `active`) VALUES
(1, 1, 'CAMERA', '', 'asterisk_orange.gif', 1),
(2, 1, 'MICROPHONE', '', 'asterisk_orange.gif', 1),
(3, 1, 'SPEAKER', '', 'asterisk_orange.gif', 1),
(4, 1, 'LENS', '', 'asterisk_orange.gif', 1),
(5, 1, 'TABLETS', '', 'asterisk_orange.gif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE IF NOT EXISTS `periods` (
`period_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `days` int(2) unsigned DEFAULT NULL,
  `bookable` tinyint(1) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periods`
--

INSERT INTO `periods` (`period_id`, `school_id`, `time_start`, `time_end`, `name`, `days`, `bookable`, `active`) VALUES
(1, 1, '07:30:00', '08:00:00', '1', 126, 1, 1),
(2, 1, '08:00:00', '08:30:00', '2', 126, 1, 1),
(3, 1, '08:30:00', '09:00:00', '3', 126, 1, 1),
(4, 1, '09:00:00', '09:30:00', '4', 126, 1, 1),
(5, 1, '09:30:00', '10:00:00', '5', 126, 1, 1),
(6, 1, '10:00:00', '10:30:00', '6', 126, 1, 1),
(7, 1, '10:30:00', '11:00:00', '7', 126, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quotas`
--

CREATE TABLE IF NOT EXISTS `quotas` (
  `user_id` int(6) NOT NULL,
  `quota` int(3) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
`reservation_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `period_id` int(6) unsigned DEFAULT NULL,
  `week_id` int(6) unsigned DEFAULT NULL,
  `day_num` int(1) unsigned DEFAULT NULL,
  `item_id` int(6) unsigned DEFAULT NULL,
  `user_id` int(6) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancelled` tinyint(1) unsigned DEFAULT '0',
  `status` int(5) NOT NULL DEFAULT '0',
  `action` int(1) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `school_id`, `period_id`, `week_id`, `day_num`, `item_id`, `user_id`, `date`, `notes`, `cancelled`, `status`, `action`, `active`) VALUES
(1, 1, 1, 1, 5, 1, 1, NULL, 'Well', 0, 0, 0, 1),
(2, 1, 2, 1, 5, 1, 1, NULL, 'Well', 0, 0, 0, 1),
(3, 1, 1, 1, 5, 2, 5, '2015-04-24', 'Party', 0, 1, 1, 1),
(4, 1, 2, 1, 5, 2, 5, '2015-04-24', 'Party', 0, 1, 1, 1),
(5, 1, 3, 1, 5, 1, 3, '2015-04-24', 'Testing', 0, 1, 0, 1),
(6, 1, 4, 1, 5, 1, 3, '2015-04-24', 'Testing', 0, 1, 0, 1),
(7, 1, 1, 1, 5, 7, 1, NULL, 'Well', 0, 0, 0, 1),
(8, 1, 2, 1, 5, 7, 1, NULL, 'Well', 0, 0, 0, 1),
(9, 1, 1, 1, 6, 6, 3, '2015-04-25', 'CES', 0, 1, 0, 1),
(10, 1, 2, 1, 6, 6, 3, '2015-04-25', 'CES', 0, 1, 0, 1),
(11, 1, 3, 1, 6, 6, 3, '2015-04-25', 'CES', 0, 1, 0, 1),
(12, 1, 1, 1, 6, 1, 1, NULL, 'TEST', 0, 0, 0, 1),
(13, 1, 2, 1, 6, 1, 1, NULL, 'TEST', 0, 0, 0, 1),
(14, 1, 3, 1, 6, 1, 1, NULL, 'TEST', 0, 0, 0, 1),
(15, 1, 1, 1, 1, 15, 1, NULL, '', 0, 0, 0, 1),
(16, 1, 2, 1, 1, 15, 1, NULL, '', 0, 0, 0, 1),
(17, 1, 1, 1, 1, 1, 1, NULL, 'hey', 0, 0, 0, 1),
(20, 1, 1, 1, 1, 5, 7, '2015-05-04', 'Concert', 0, 0, 0, 1),
(21, 1, 2, 1, 1, 5, 7, '2015-05-04', 'Concert', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roomfields`
--

CREATE TABLE IF NOT EXISTS `roomfields` (
`field_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('TEXT','SELECT','CHECKBOX','MULTI') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roomoptions`
--

CREATE TABLE IF NOT EXISTS `roomoptions` (
`option_id` int(6) unsigned NOT NULL,
  `field_id` int(6) unsigned DEFAULT NULL,
  `value` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
`room_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `user_id` int(6) unsigned DEFAULT NULL,
  `type_id` int(6) unsigned NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bookable` tinyint(1) DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `school_id`, `user_id`, `type_id`, `name`, `location`, `bookable`, `icon`, `notes`, `photo`, `active`) VALUES
(1, 1, 0, 1, 'LB466', '', 1, '0', '', '1fc384a79adb53d30a6e1163e8ecb33b.jpg', 1),
(2, 1, 0, 2, 'LB446', '', 1, 'asterisk_orange.gif', '', '867cff3d3eed460a2929c17556a05c26.jpg', 1),
(3, 1, 0, 3, 'LB402', '', 1, '0', '', NULL, 1),
(4, 1, 0, 4, 'LB469', 'SAAS', 1, '0', '', '1fc384a79adb53d30a6e1163e8ecb33b.jpg', 1),
(5, 1, 0, 2, 'ROOM TEST', '', 1, 'asterisk_orange.gif', '', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roomtypes`
--

CREATE TABLE IF NOT EXISTS `roomtypes` (
`type_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roomvalues`
--

CREATE TABLE IF NOT EXISTS `roomvalues` (
`value_id` int(6) unsigned NOT NULL,
  `room_id` int(6) unsigned DEFAULT NULL,
  `field_id` int(6) unsigned DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
`school_id` int(6) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `colour` char(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bia` int(3) unsigned DEFAULT '0',
  `d_columns` enum('periods','rooms','days') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `displaytype` enum('room','day') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `name`, `website`, `colour`, `logo`, `bia`, `d_columns`, `displaytype`, `active`) VALUES
(1, 'USC', 'http://localhost', '468ED8', NULL, 3, 'periods', 'day', 1);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
`type_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `school_id`, `name`, `description`, `icon`, `active`) VALUES
(1, 1, 'Lecture', '', 'asterisk_orange.gif', 1),
(2, 1, 'Laboratory', '', 'computer.gif', 1),
(3, 1, 'Studio', '', 'asterisk_orange.gif', 1),
(4, 1, 'Research', '', 'book_open.gif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `department_id` int(6) unsigned DEFAULT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` char(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `authlevel` int(3) DEFAULT NULL,
  `displayname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ext` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enabled` int(1) NOT NULL DEFAULT '0',
  `created` date DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `school_id`, `department_id`, `username`, `firstname`, `lastname`, `email`, `password`, `authlevel`, `displayname`, `ext`, `lastlogin`, `enabled`, `created`, `active`) VALUES
(1, 1, 0, 'labhead', 'Elmo ', 'Ranolo', 'elmo@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, 'Administrator', '', '2015-05-06 20:24:18', 1, NULL, 1),
(2, 1, 0, '111222333', 'Jessarie', 'Dahil', 'jd13@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 2, 'Jessarie', '', '2015-04-24 14:36:40', 1, NULL, 1),
(3, 1, 0, '12345678', 'Alji', 'Ondoy', 'amjondoy@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 2, 'Alji', '', '2015-05-03 20:29:07', 1, NULL, 1),
(4, 1, 1, 'guest', 'Guest', '', 'guest@guest.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 4, 'Hello, Guest', '', '2015-05-06 20:23:56', 1, NULL, 1),
(5, 1, 0, '126126126', 'Christina', 'Pena', 'chrisp@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 2, 'Chrisp', '', '2015-05-03 18:32:57', 1, NULL, 1),
(6, 1, 2, '10036002', 'Eun Hye', 'Yoon', 'eunhye@hotmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'Grace', '', '2015-04-25 04:06:59', 1, NULL, 1),
(7, 1, 0, '11100113', 'Joan ', 'Tero', 'joan@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'Joan ', '', '2015-05-03 20:26:02', 1, NULL, 1),
(8, 1, 0, '88888888', 'JEON', 'JI HYUN', 'teacher@gmail.com', '112bb791304791ddcf692e29fd5cf149b35fea37', 2, 'TEACHER KO', '', '0000-00-00 00:00:00', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `weekdates`
--

CREATE TABLE IF NOT EXISTS `weekdates` (
  `school_id` int(6) unsigned NOT NULL,
  `week_id` int(6) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weekdates`
--

INSERT INTO `weekdates` (`school_id`, `week_id`, `date`, `active`) VALUES
(1, 2, '2015-06-15', 1),
(1, 2, '2015-06-22', 1),
(1, 2, '2015-06-29', 1),
(1, 2, '2015-07-06', 1),
(1, 2, '2015-07-13', 1),
(1, 2, '2015-07-20', 1),
(1, 2, '2015-07-27', 1),
(1, 2, '2015-08-03', 1),
(1, 2, '2015-08-10', 1),
(1, 2, '2015-08-17', 1),
(1, 2, '2015-08-24', 1),
(1, 1, '2015-04-13', 1),
(1, 1, '2015-04-20', 1),
(1, 1, '2015-04-27', 1),
(1, 1, '2015-05-04', 1),
(1, 1, '2015-05-11', 1),
(1, 1, '2015-05-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `weeks`
--

CREATE TABLE IF NOT EXISTS `weeks` (
`week_id` int(6) unsigned NOT NULL,
  `school_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `fgcol` char(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bgcol` char(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weeks`
--

INSERT INTO `weeks` (`week_id`, `school_id`, `name`, `fgcol`, `bgcol`, `icon`, `active`) VALUES
(1, 1, 'Summer 2015', '', '', 'asterisk_orange.gif', 1),
(2, 1, 'First Semester', '', '', 'asterisk_orange.gif', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academicyears`
--
ALTER TABLE `academicyears`
 ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
 ADD PRIMARY KEY (`booking_id`), ADD KEY `school_id` (`school_id`,`period_id`,`room_id`,`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
 ADD PRIMARY KEY (`department_id`), ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
 ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
 ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_groups`
--
ALTER TABLE `item_groups`
 ADD PRIMARY KEY (`item_group_id`);

--
-- Indexes for table `item_types`
--
ALTER TABLE `item_types`
 ADD PRIMARY KEY (`item_type_id`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
 ADD PRIMARY KEY (`period_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
 ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `roomfields`
--
ALTER TABLE `roomfields`
 ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `roomoptions`
--
ALTER TABLE `roomoptions`
 ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
 ADD PRIMARY KEY (`room_id`), ADD KEY `school_id` (`school_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roomtypes`
--
ALTER TABLE `roomtypes`
 ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `roomvalues`
--
ALTER TABLE `roomvalues`
 ADD PRIMARY KEY (`value_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
 ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
 ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD KEY `authlevel` (`authlevel`), ADD KEY `enabled` (`enabled`);

--
-- Indexes for table `weekdates`
--
ALTER TABLE `weekdates`
 ADD KEY `week_id` (`week_id`);

--
-- Indexes for table `weeks`
--
ALTER TABLE `weeks`
 ADD PRIMARY KEY (`week_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
MODIFY `booking_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
MODIFY `department_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
MODIFY `holiday_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `item_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `item_groups`
--
ALTER TABLE `item_groups`
MODIFY `item_group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
MODIFY `item_type_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
MODIFY `period_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
MODIFY `reservation_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `roomfields`
--
ALTER TABLE `roomfields`
MODIFY `field_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roomoptions`
--
ALTER TABLE `roomoptions`
MODIFY `option_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
MODIFY `room_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `roomtypes`
--
ALTER TABLE `roomtypes`
MODIFY `type_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roomvalues`
--
ALTER TABLE `roomvalues`
MODIFY `value_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
MODIFY `school_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
MODIFY `type_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `weeks`
--
ALTER TABLE `weeks`
MODIFY `week_id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
