-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2014 at 12:17 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gala`
--
CREATE DATABASE IF NOT EXISTS `gala` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gala`;

-- --------------------------------------------------------

--
-- Table structure for table `candidat`
--

CREATE TABLE IF NOT EXISTS `candidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `candidat`
--

INSERT INTO `candidat` (`id`, `nom`, `avatar`) VALUES
(9, 'PrÃ©sident', '9.png'),
(10, 'Secretaire', '10.png');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Le (la) plus <br/>sexy'),
(2, 'Le (la) plus drÃ´le'),
(3, 'Le (la) plus studieux (-se)'),
(4, 'Le (la) plus populaire'),
(5, 'Le (la) plus fÃªtard(e)'),
(6, 'Le (la) plus associatif (-ve)');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) NOT NULL,
  `id_candidat` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `time`, `ip`, `id_candidat`, `id_categorie`) VALUES
(1, '2014-11-18 10:14:14', '', 9, 1),
(2, '2014-11-18 10:14:14', '', 9, 1),
(3, '2014-11-18 10:14:28', '', 9, 2),
(4, '2014-11-18 10:14:28', '', 9, 3),
(5, '2014-11-18 10:14:35', '', 9, 2),
(6, '2014-11-18 10:14:35', '', 9, 1),
(7, '2014-11-18 10:15:42', '', 10, 1),
(8, '2014-11-18 10:15:42', '', 10, 1),
(9, '2014-11-18 11:03:26', '127.0.0.1', 9, 1),
(10, '2014-11-18 11:03:41', '127.0.0.1', 10, 2),
(11, '2014-11-18 11:10:46', '127.0.0.1', 10, 3),
(12, '2014-11-18 11:12:02', '127.0.0.1', 10, 5),
(13, '2014-11-18 11:12:19', '127.0.0.1', 9, 6),
(14, '2014-11-18 11:12:34', '127.0.0.1', 10, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
