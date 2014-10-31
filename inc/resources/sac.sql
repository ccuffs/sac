-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2014 at 11:09 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sac`
--
CREATE DATABASE IF NOT EXISTS `sac` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sac`;

-- --------------------------------------------------------

--
-- Table structure for table `attending`
--

CREATE TABLE IF NOT EXISTS `attending` (
  `fk_event` int(10) unsigned NOT NULL,
  `fk_user` int(10) unsigned NOT NULL,
  `date` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  UNIQUE KEY `main` (`fk_event`,`fk_user`),
  KEY `fk_event` (`fk_event`,`fk_user`,`paid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE IF NOT EXISTS `competition` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prizes` text NOT NULL,
  `rules` text NOT NULL,
  `style` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_competition` int(10) unsigned DEFAULT NULL,
  `day` tinyint(4) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `time` varchar(200) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `place` varchar(200) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `capacity` int(11) NOT NULL DEFAULT '0',
  `waiting_capacity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `day` (`day`,`month`),
  KEY `fk_competition` (`fk_competition`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_user` int(10) unsigned NOT NULL,
  `date` int(11) NOT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_log`
--

CREATE TABLE IF NOT EXISTS `payment_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_leader` int(10) unsigned NOT NULL,
  `fk_competition` int(10) unsigned NOT NULL,
  `fk_payment` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `members` text NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_leader` (`fk_leader`),
  KEY `fk_competition` (`fk_competition`),
  KEY `fk_payment` (`fk_payment`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_3` FOREIGN KEY (`fk_payment`) REFERENCES `payment` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`fk_competition`) REFERENCES `competition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`fk_leader`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
