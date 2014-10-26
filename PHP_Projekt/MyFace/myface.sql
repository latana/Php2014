-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 23 okt 2014 kl 14:05
-- Serverversion: 5.6.15-log
-- PHP-version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `myface`
--
CREATE DATABASE IF NOT EXISTS `myface` DEFAULT CHARACTER SET swe7 COLLATE swe7_bin;
USE `myface`;

-- --------------------------------------------------------

--
-- Tabellstruktur `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `GalleryID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(25) CHARACTER SET swe7 NOT NULL,
  `Picname` varchar(35) COLLATE swe7_bin NOT NULL,
  `URL` varchar(250) COLLATE swe7_bin NOT NULL,
  `Piccomment` text COLLATE swe7_bin,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`GalleryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=swe7 COLLATE=swe7_bin AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `gallerycomment`
--

CREATE TABLE IF NOT EXISTS `gallerycomment` (
  `GalleryCommentID` int(250) NOT NULL AUTO_INCREMENT,
  `GalleryID` int(250) NOT NULL,
  `Username` varchar(50) COLLATE swe7_bin NOT NULL,
  `GalleryComment` text COLLATE swe7_bin NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`GalleryCommentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=swe7 COLLATE=swe7_bin AUTO_INCREMENT=187 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `PostID` int(250) NOT NULL AUTO_INCREMENT,
  `Username` varchar(25) CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL,
  `Comment` text CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL,
  `URL` varchar(250) CHARACTER SET swe7 DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PostID`)
) ENGINE=MyISAM  DEFAULT CHARSET=swe7 COLLATE=swe7_bin AUTO_INCREMENT=285 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `Username` varchar(30) COLLATE utf32_swedish_ci NOT NULL,
  `Password` varchar(250) COLLATE utf32_swedish_ci NOT NULL,
  `ProfilePic` varchar(250) COLLATE utf32_swedish_ci NOT NULL DEFAULT 'default.jpg',
  `CookiePass` varchar(250) CHARACTER SET swe7 COLLATE swe7_bin NOT NULL,
  UNIQUE KEY `Username` (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32 COLLATE=utf32_swedish_ci;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`Username`, `Password`, `ProfilePic`, `CookiePass`) VALUES
('Admin', 'Üd~¶^gáU7R!+9d', '3B571FEE-85D8-4477-92E7-755AD8E8D0FE12.jpg', 'xZ3OTCY4VqYvYHrzh7nHHiuMWA9QXJGhx8eelzomfqps80rp3H');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
