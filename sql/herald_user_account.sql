-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 21, 2013 at 09:47 AM
-- Server version: 5.5.31-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `herald_user_account`
--
CREATE DATABASE IF NOT EXISTS `herald_user_account` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `herald_user_account`;

-- --------------------------------------------------------

--
-- Table structure for table `herald_admin`
--

CREATE TABLE IF NOT EXISTS `herald_admin` (
  `id` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `herald_admin`
--

INSERT INTO `herald_admin` (`id`, `name`, `password`, `grade`) VALUES
('admin', '郭耿瑞', '202cb962ac59075b964b07152d234b70', 1);

-- --------------------------------------------------------

--
-- Table structure for table `herald_session`
--

CREATE TABLE IF NOT EXISTS `herald_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `login_time` varchar(45) NOT NULL,
  `expired_time` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `herald_session`
--

INSERT INTO `herald_session` (`id`, `session_id`, `ip`, `login_time`, `expired_time`, `user_id`) VALUES
(1, 'b251db0d56084b8392118d3e747f8725', '', '1369216245', '', 213111517),
(2, 'bc062cf7083241dd9d26886780912b10', '', '1369216360', '', 213111517),
(3, '7c4fcd5ca689a00c4bbe123903fe3b45', '127.0.0.1', '1369218819', '', 213111517),
(4, '5926a53654d4d8a09969bd3ae64039f3', '127.0.0.1', '1369223425', '1369227025', 213111517),
(6, 'd79549b6ad9dcb9394c5d39b7cd5c97b', '127.0.0.1', '1372907561', '1376507561', 213111517),
(7, '5c0bd80d3e912af190713beffaf47d59', '127.0.0.1', '1373694815', '1377294815', 213111517),
(8, '7135909028e714b508e36b54c2f8fecd', '127.0.0.1', '1373699887', '1377299887', 213111517),
(9, '0c41cff66a8446801316f41c7cfa8de6', '127.0.0.1', '1373701767', '1377301767', 213111517);

-- --------------------------------------------------------

--
-- Table structure for table `herald_user`
--

CREATE TABLE IF NOT EXISTS `herald_user` (
  `card_num` int(11) NOT NULL,
  `true_name` varchar(255) NOT NULL,
  `nick_name` varchar(255) NOT NULL DEFAULT '未添加',
  `avatar_address` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL DEFAULT '未添加',
  `speciality` varchar(255) NOT NULL DEFAULT '未添加',
  `qq` varchar(45) NOT NULL DEFAULT '未添加',
  `email` varchar(45) NOT NULL DEFAULT '未添加',
  `phone` varchar(45) NOT NULL DEFAULT '未添加',
  `last_login_time` datetime NOT NULL,
  `login_times` int(11) NOT NULL,
  PRIMARY KEY (`card_num`),
  KEY `card_num` (`card_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `herald_user`
--

INSERT INTO `herald_user` (`card_num`, `true_name`, `nick_name`, `avatar_address`, `college`, `speciality`, `qq`, `email`, `phone`, `last_login_time`, `login_times`) VALUES
(213111517, '郭耿瑞', '未添加', '', '未添加', '未添加', '未添加', '未添加', '未添加', '2013-07-04 11:12:41', 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
