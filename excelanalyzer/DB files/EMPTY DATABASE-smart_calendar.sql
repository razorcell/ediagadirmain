-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2016 at 10:16 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smart_calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `forcasts_closed`
--

CREATE TABLE IF NOT EXISTS `forcasts_closed` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EventID` text NOT NULL,
  `YEAR` text NOT NULL,
  `COMMENT` longtext,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `missing_pay_date`
--

CREATE TABLE IF NOT EXISTS `missing_pay_date` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EventID` text NOT NULL,
  `CLOSED_CASE` tinyint(1) NOT NULL DEFAULT '0',
  `COMMENT` longtext,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wca_gross_data`
--

CREATE TABLE IF NOT EXISTS `wca_gross_data` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EventID` text NOT NULL,
  `Actflag` text,
  `Created` date DEFAULT NULL,
  `Incorp` text,
  `issuer_name` text,
  `ISIN` text,
  `primary_exchange` text,
  `ex_date` date DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
