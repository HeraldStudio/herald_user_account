-- phpMyAdmin SQL Dump
-- version 4.1.13
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2014 at 07:31 PM
-- Server version: 5.5.35-0ubuntu0.12.04.2
-- PHP Version: 5.3.10-1ubuntu3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `herald_user_account`
--

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
  `user_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `herald_user`
--

CREATE TABLE IF NOT EXISTS `herald_user` (
  `card_num` int(11) NOT NULL,
  `true_name` varchar(255) NOT NULL,
  `nick_name` varchar(255) NOT NULL DEFAULT '未添加',
  `avatar_address` varchar(255) NOT NULL DEFAULT '未添加',
  `college` varchar(255) NOT NULL DEFAULT '未添加',
  `speciality` varchar(255) NOT NULL DEFAULT '未添加',
  `qq` varchar(45) NOT NULL DEFAULT '未添加',
  `email` varchar(45) NOT NULL DEFAULT '未添加',
  `phone` varchar(45) NOT NULL DEFAULT '未添加',
  `last_login_time` datetime NOT NULL,
  `login_times` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`card_num`),
  KEY `card_num` (`card_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
