-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Počítač: wm70.wedos.net:3306
-- Vygenerováno: Čtv 05. říj 2017, 19:40
-- Verze serveru: 5.6.17
-- Verze PHP: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `d79175_vlcata`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `utrata_akt_hodnota`
--

CREATE TABLE IF NOT EXISTS `utrata_akt_hodnota` (
  `ID` bigint(4) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `datum` datetime NOT NULL,
  `hodnota` double NOT NULL,
  `duvod` varchar(61) COLLATE utf8_czech_ci DEFAULT NULL,
  `typ` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT 'karta',
  `idToDelete` bigint(18) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=149 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `utrata_check_state`
--

CREATE TABLE IF NOT EXISTS `utrata_check_state` (
  `ID` bigint(4) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `typ` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT 'karta',
  `checked` datetime NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=301 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `utrata_items`
--

CREATE TABLE IF NOT EXISTS `utrata_items` (
  `ID` bigint(4) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `nazev` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `popis` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `cena` double NOT NULL,
  `kurz` double DEFAULT '1',
  `datum` datetime NOT NULL,
  `pozn` int(11) NOT NULL,
  `platnost` int(1) DEFAULT '1',
  `typ` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT 'karta',
  `vyber` int(1) DEFAULT '0',
  `odepsat` int(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `pozn` (`pozn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1330 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `utrata_members`
--

CREATE TABLE IF NOT EXISTS `utrata_members` (
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `login` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `passwd` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `sendMonthly` tinyint(1) NOT NULL DEFAULT '1',
  `sendByOne` tinyint(1) NOT NULL DEFAULT '1',
  `mother` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `me` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `LanguageCode` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT 'CZK',
  `currencyID` int(11) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `logged` tinyint(1) NOT NULL DEFAULT '0',
  `HASH` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `access` datetime NOT NULL DEFAULT '2016-12-31 23:59:59',
  PRIMARY KEY (`name`),
  KEY `FK_memberCurrency` (`currencyID`),
  KEY `LanguageCode` (`LanguageCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `utrata_Purposes`
--

CREATE TABLE IF NOT EXISTS `utrata_Purposes` (
  `PurposeID` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `LanguageCode` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT 'CZK',
  `base` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PurposeID`),
  KEY `LanguageCode` (`LanguageCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `utrata_UserPurposes`
--

CREATE TABLE IF NOT EXISTS `utrata_UserPurposes` (
  `UserPurposeID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `PurposeID` int(11) NOT NULL,
  PRIMARY KEY (`UserPurposeID`),
  KEY `FK_Users` (`UserID`),
  KEY `FK_Purposes` (`PurposeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `utr_currencies`
--

CREATE TABLE IF NOT EXISTS `utr_currencies` (
  `CurrencyID` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`CurrencyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `utr_languages`
--

CREATE TABLE IF NOT EXISTS `utr_languages` (
  `LanguageCode` varchar(5) COLLATE utf8_czech_ci NOT NULL,
  `Name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`LanguageCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `utr_translations`
--

CREATE TABLE IF NOT EXISTS `utr_translations` (
  `TranslateCode` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `LanguageCode` varchar(5) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `Value` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`TranslateCode`,`LanguageCode`),
  KEY `LanguageCode` (`LanguageCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `utrata_akt_hodnota`
--
ALTER TABLE `utrata_akt_hodnota`
  ADD CONSTRAINT `utrata_akt_hodnota_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `utrata_members` (`name`);

--
-- Omezení pro tabulku `utrata_check_state`
--
ALTER TABLE `utrata_check_state`
  ADD CONSTRAINT `utrata_check_state_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `utrata_members` (`name`);

--
-- Omezení pro tabulku `utrata_items`
--
ALTER TABLE `utrata_items`
  ADD CONSTRAINT `utrata_items_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `utrata_members` (`name`),
  ADD CONSTRAINT `utrata_items_ibfk_2` FOREIGN KEY (`pozn`) REFERENCES `utrata_Purposes` (`PurposeID`);

--
-- Omezení pro tabulku `utrata_members`
--
ALTER TABLE `utrata_members`
  ADD CONSTRAINT `utrata_members_ibfk_1` FOREIGN KEY (`LanguageCode`) REFERENCES `utr_languages` (`LanguageCode`),
  ADD CONSTRAINT `FK_memberCurrency` FOREIGN KEY (`currencyID`) REFERENCES `utr_currencies` (`CurrencyID`);

--
-- Omezení pro tabulku `utrata_Purposes`
--
ALTER TABLE `utrata_Purposes`
  ADD CONSTRAINT `utrata_Purposes_ibfk_1` FOREIGN KEY (`LanguageCode`) REFERENCES `utr_languages` (`LanguageCode`);

--
-- Omezení pro tabulku `utrata_UserPurposes`
--
ALTER TABLE `utrata_UserPurposes`
  ADD CONSTRAINT `FK_Purposes` FOREIGN KEY (`PurposeID`) REFERENCES `utrata_Purposes` (`PurposeID`),
  ADD CONSTRAINT `FK_Users` FOREIGN KEY (`UserID`) REFERENCES `utrata_members` (`name`);

--
-- Omezení pro tabulku `utr_translations`
--
ALTER TABLE `utr_translations`
  ADD CONSTRAINT `utr_translations_ibfk_1` FOREIGN KEY (`LanguageCode`) REFERENCES `utr_languages` (`LanguageCode`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
