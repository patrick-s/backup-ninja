-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 08, 2017 at 06:22 PM
-- Server version: 5.6.35
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bbninja_ninjastar`
--

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `config_id` int(4) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(64) NOT NULL,
  `config_info` longtext NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE IF NOT EXISTS `errors` (
  `error_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `error` varchar(256) NOT NULL,
  `error_date` date NOT NULL,
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `host_name` varchar(25) NOT NULL,
  `host_location` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(16) NOT NULL AUTO_INCREMENT,
  `site_url` varchar(128) NOT NULL,
  `site_username` varchar(128) NOT NULL,
  `site_password` varchar(128) NOT NULL,
  `site_host` varchar(128) NOT NULL,
  `ftp_username` varchar(64) NOT NULL,
  `ftp_password` varchar(128) NOT NULL,
  `ftp_host` varchar(128) NOT NULL,
  `ftp_port` int(4) NOT NULL,
  `ftp_destination` varchar(256) NOT NULL,
  `comments` text NOT NULL,
  `backup_schedule` int(1) NOT NULL,
  `last_backup` int(128) NOT NULL,
  `backup_active` int(1) NOT NULL,
  `comp_cycle` int(1) NOT NULL,
  `cpanel_theme` varchar(16) NOT NULL,
  `hosting` int(2) NOT NULL,
  `fingerprint_uname` varchar(64) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(16) NOT NULL,
  `user_name` varchar(32) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_permission_level` int(1) NOT NULL,
  `user_active` int(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
