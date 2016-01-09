-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Feb 18, 2014 alle 16:45
-- Versione del server: 5.5.35-0ubuntu0.13.10.2
-- Versione PHP: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my1318`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Evento`
--

CREATE TABLE IF NOT EXISTS `Evento` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Subtype` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Lat` float NOT NULL,
  `Lng` float NOT NULL,
  `StartTime` int(11) DEFAULT NULL,
  `Freshness` int(11) DEFAULT NULL,
  `Status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Nnotifications` int(11) NOT NULL,
  `Open` text COLLATE utf8_unicode_ci,
  `Closed` text COLLATE utf8_unicode_ci,
  `Archived` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Notifica`
--

CREATE TABLE IF NOT EXISTS `Notifica` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_User` int(11) NOT NULL,
  `Type` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Subtype` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Indirizzo` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `Lat` float(20,15) NOT NULL,
  `Lng` float(20,15) NOT NULL,
  `Description` text COLLATE utf8_unicode_ci,
  `Id_Evento` int(11) DEFAULT NULL,
  `UnixTime` int(11) DEFAULT NULL,
  `Credibilita` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `Id_Evento` (`Id_Evento`),
  KEY `Id_User` (`Id_User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

CREATE TABLE IF NOT EXISTS `Utente` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Tipologia` tinyint(1) NOT NULL,
  `Assiduita` double NOT NULL DEFAULT '0',
  `Credibilita` double NOT NULL DEFAULT '0',
  `Raggio` float DEFAULT '2000',
  `Lat` float DEFAULT '44.4958',
  `Lng` float DEFAULT '11.3447',
  `Richiesta_Scope` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'local',
  `Richiesta_Type` varchar(40) COLLATE utf8_unicode_ci DEFAULT 'all',
  `Richiesta_Subtype` varchar(40) COLLATE utf8_unicode_ci DEFAULT 'all',
  `Richiesta_Timemin` int(11) DEFAULT '1300000000',
  `Richiesta_Timemax` int(11) DEFAULT '1500000000',
  `Richiesta_Status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'all',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `Utente`
--

INSERT INTO `Utente` (`Id`, `Username`, `Password`, `Tipologia`, `Assiduita`, `Credibilita`, `Raggio`, `Lat`, `Lng`, `Richiesta_Scope`, `Richiesta_Type`, `Richiesta_Subtype`, `Richiesta_Timemin`, `Richiesta_Timemax`, `Richiesta_Status`) VALUES
(1, 'FabioVitali', 'fv', 1, 1.09, 0, 2000, 44.4958, 11.3447, 'local', 'all', 'all', 1300000000, 1500000000, 'all'),
(2, 'Fabio', 'fv', 0, 0, 0, 2000, 44.4958, 11.3447, 'local', 'all', 'all', 1300000000, 1500000000, 'all');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
